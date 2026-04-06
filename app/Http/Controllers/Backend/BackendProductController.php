<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackendProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('brand', 'category', 'images', 'tags');

        // Filter by product type
        if ($request->filled('type')) {
            $query->where('product_type', $request->type);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Filter by tag
        if ($request->filled('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::all();
        $brands = Brand::all();
        $tags = Tag::all();

        return view('backend.product.index', compact('products', 'categories', 'brands', 'tags'));
    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::whereNull('parent_id')->with('childrenRecursive')->get();
        $allCategories = Category::all();
        $attributes = Attribute::with('values')->where('is_active', true)->get();
        $tags = Tag::orderBy('name')->get();

        return view('backend.product.create', compact('brands', 'categories', 'allCategories', 'attributes', 'tags'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'              => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:products,slug',
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
            'base_price'        => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'brand_id'          => 'nullable|exists:brands,id',
            'category_id'       => 'nullable|exists:categories,id',
            'is_active'         => 'boolean',
            'product_type'      => 'required|in:simple,variable',
            'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tag_ids'           => 'nullable|array',
            'tag_ids.*'         => 'exists:tags,id',
        ];

        // Simple-product specific fields
        if ($request->product_type === 'simple') {
            $rules['sku']          = 'nullable|string|unique:products,sku';
            $rules['stock']        = 'nullable|integer|min:0';
            $rules['manage_stock'] = 'boolean';
            $rules['weight']       = 'nullable|numeric|min:0';
        }

        // Variable-product specific fields
        if ($request->product_type === 'variable') {
            $rules['attribute_ids']   = 'nullable|array';
            $rules['attribute_ids.*'] = 'exists:attributes,id';
            $rules['attribute_values']   = 'nullable|array';
            $rules['attribute_values.*'] = 'exists:attribute_values,id';
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();

        try {
            $product = Product::create($validated);

            // Attach tags
            if ($request->has('tag_ids')) {
                $product->tags()->sync($request->tag_ids);
            }

            // Attach attributes (variable products only)
            if ($request->product_type === 'variable') {
                $attributeIds = collect($request->input('attribute_ids', []))
                    ->merge(
                        AttributeValue::query()
                            ->whereIn('id', $request->input('attribute_values', []))
                            ->pluck('attribute_id')
                            ->all()
                    )
                    ->filter()
                    ->unique()
                    ->values();

                foreach ($attributeIds as $index => $attributeId) {
                    $product->attributes()->attach($attributeId, ['position' => $index]);
                }
            }

            // Upload images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path'       => $path,
                        'is_primary' => ($key === 0),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.show', $product->id)
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function edit(Product $product)
    {
        $product->load('images', 'variations', 'attributes', 'tags');
        $brands = Brand::all();
        $categories = Category::whereNull('parent_id')->with('childrenRecursive')->get();
        $allCategories = Category::all();
        $attributes = Attribute::with('values')->where('is_active', true)->get();
        $tags = Tag::orderBy('name')->get();

        return view('backend.product.edit', compact('product', 'brands', 'categories', 'allCategories', 'attributes', 'tags'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'name'              => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:products,slug,' . $product->id,
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
            'base_price'        => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'brand_id'          => 'nullable|exists:brands,id',
            'category_id'       => 'nullable|exists:categories,id',
            'is_active'         => 'boolean',
            'product_type'      => 'required|in:simple,variable',
            'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tag_ids'           => 'nullable|array',
            'tag_ids.*'         => 'exists:tags,id',
        ];

        if ($request->product_type === 'simple') {
            $rules['sku']          = 'nullable|string|unique:products,sku,' . $product->id;
            $rules['stock']        = 'nullable|integer|min:0';
            $rules['manage_stock'] = 'boolean';
            $rules['weight']       = 'nullable|numeric|min:0';
        }

        if ($request->product_type === 'variable') {
            $rules['attribute_ids']   = 'nullable|array';
            $rules['attribute_ids.*'] = 'exists:attributes,id';
            $rules['attribute_values']   = 'nullable|array';
            $rules['attribute_values.*'] = 'exists:attribute_values,id';
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();

        try {
            $product->update($validated);

            // Sync tags
            $product->tags()->sync($request->tag_ids ?? []);

            // Handle attributes based on product type
            if ($request->product_type === 'variable') {
                $attributeIds = collect($request->input('attribute_ids', []))
                    ->merge(
                        AttributeValue::query()
                            ->whereIn('id', $request->input('attribute_values', []))
                            ->pluck('attribute_id')
                            ->all()
                    )
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();

                if (! empty($attributeIds)) {
                    $syncData = [];
                    foreach ($attributeIds as $index => $attributeId) {
                        $syncData[$attributeId] = ['position' => $index];
                    }
                    $product->attributes()->sync($syncData);
                } else {
                    $product->attributes()->detach();
                }
            } else {
                // Simple product: remove attributes and variations
                $product->attributes()->detach();
            }

            // Upload new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path'       => $path,
                        'is_primary' => ($key === 0 && $product->images()->count() === 0),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.show', $product->id)
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function show(Product $product)
    {
        $product->load('brand', 'category', 'images', 'variations', 'attributes.values', 'tags');
        return view('backend.product.show', compact('product'));
    }

    /* ───── Variation Methods ───── */

    public function storeVariation(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku'        => 'required|string|unique:product_variations,sku',
            'price'      => 'required|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'attributes' => 'required|array',
            'is_active'  => 'boolean',
        ]);

        $validated['product_id'] = $product->id;

        ProductVariation::create($validated);

        return back()->with('success', 'Variation created successfully');
    }

    public function updateVariation(Request $request, ProductVariation $variation)
    {
        $validated = $request->validate([
            'sku'        => 'required|string|unique:product_variations,sku,' . $variation->id,
            'price'      => 'required|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'attributes' => 'required|array',
            'is_active'  => 'boolean',
        ]);

        $variation->update($validated);

        return back()->with('success', 'Variation updated successfully');
    }

    public function destroyVariation(ProductVariation $variation)
    {
        $variation->delete();
        return back()->with('success', 'Variation deleted successfully');
    }

    public function destroy(Product $product)
    {
        $product->tags()->detach();
        $product->attributes()->detach();
        $product->delete();
        return back()->with('success', 'Product deleted');
    }
}
