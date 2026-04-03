@extends('layouts.app')
@section('content')

{{-- Page Header --}}
<div class="df-page-header">
    <h1 class="df-page-title">Edit Product</h1>
    <nav class="df-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="separator"><i class="bi bi-chevron-right"></i></span>
        <a href="{{ route('admin.products.index') }}">Product</a>
        <span class="separator"><i class="bi bi-chevron-right"></i></span>
        <span class="current">Edit</span>
    </nav>
</div>

@if(session('success'))
    <div class="df-alert df-alert-success">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="df-alert df-alert-danger">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    </div>
@endif

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        {{-- LEFT COLUMN --}}
        <div class="col-lg-8">

            {{-- Current Images --}}
            @if($product->images->count())
                <div class="df-card">
                    <div class="df-card-header">
                        <h5 class="df-card-title"><i class="bi bi-images"></i> Current Images</h5>
                    </div>
                    <div class="df-card-body">
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/' . $image->path) }}" alt=""
                                     style="width:100px;height:100px;object-fit:cover;border-radius:12px;border:1px solid var(--df-border-color);">
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Upload New --}}
            <div class="df-card">
                <div class="df-card-header">
                    <h5 class="df-card-title"><i class="bi bi-cloud-arrow-up"></i> Upload New Images</h5>
                </div>
                <div class="df-card-body">
                    <div class="df-upload-zone" onclick="document.getElementById('product-images').click()">
                        <div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                        <p>Drop your images here or <span class="browse-link">click to browse</span></p>
                    </div>
                    <input type="file" id="product-images" name="images[]" multiple accept="image/*"
                           style="display:none" onchange="previewImages(this)">
                    <div id="image-preview" class="d-flex flex-wrap gap-3 mt-3"></div>
                </div>
            </div>

            {{-- Product Type --}}
            <div class="df-card">
                <div class="df-card-header">
                    <h5 class="df-card-title"><i class="bi bi-toggles"></i> Product Data</h5>
                </div>
                <div class="df-card-body">
                    <label class="df-form-label">Product Type <span class="text-danger">*</span></label>
                    <select name="product_type" id="productType" class="df-form-select" onchange="toggleProductType()">
                        <option value="simple" {{ old('product_type', $product->product_type) == 'simple' ? 'selected' : '' }}>📦 Simple Product</option>
                        <option value="variable" {{ old('product_type', $product->product_type) == 'variable' ? 'selected' : '' }}>🔀 Variable Product</option>
                    </select>
                </div>
            </div>

            {{-- General --}}
            <div class="df-card">
                <div class="df-card-header">
                    <h5 class="df-card-title"><i class="bi bi-info-circle"></i> General</h5>
                </div>
                <div class="df-card-body">
                    <div class="mb-3">
                        <label class="df-form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="df-form-control"
                               value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="df-form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" class="df-form-control"
                               value="{{ old('slug', $product->slug) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="df-form-label">Short Description</label>
                        <textarea name="short_description" class="df-form-control" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="df-form-label">Description</label>
                        <textarea name="description" class="df-form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Pricing --}}
            <div class="df-card">
                <div class="df-card-header">
                    <h5 class="df-card-title"><i class="bi bi-currency-rupee"></i> Pricing</h5>
                </div>
                <div class="df-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="df-form-label">Regular Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" name="base_price" class="df-form-control" step="0.01"
                                   value="{{ old('base_price', $product->base_price) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="df-form-label">Sale Price (₹)</label>
                            <input type="number" name="sale_price" class="df-form-control" step="0.01"
                                   value="{{ old('sale_price', $product->sale_price) }}"
                                   placeholder="Leave blank if not on sale">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Inventory (Simple) --}}
            <div id="simpleFields" class="df-card">
                <div class="df-card-header">
                    <h5 class="df-card-title"><i class="bi bi-box-seam"></i> Inventory</h5>
                </div>
                <div class="df-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="df-form-label">SKU</label>
                            <input type="text" name="sku" class="df-form-control"
                                   value="{{ old('sku', $product->sku) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="df-form-label">Stock Quantity</label>
                            <input type="number" name="stock" class="df-form-control"
                                   value="{{ old('stock', $product->stock) }}">
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <div class="df-form-check">
                                <input type="checkbox" name="manage_stock" value="1" id="manageStock"
                                       {{ old('manage_stock', $product->manage_stock) ? 'checked' : '' }}>
                                <label for="manageStock">Manage Stock?</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="df-form-label">Weight (kg)</label>
                            <input type="number" name="weight" class="df-form-control" step="0.01"
                                   value="{{ old('weight', $product->weight) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Attributes (Variable) --}}
            <div id="variableFields" class="df-card" style="display:none;">
                <div class="df-card-header">
                    <h5 class="df-card-title"><i class="bi bi-sliders"></i> Attributes</h5>
                </div>
                <div class="df-card-body">
                    @php $selectedValues = old('attribute_values', []); @endphp
                    @foreach($attributes as $attribute)
                        <div class="mb-3">
                            <label class="df-form-label">{{ $attribute->name }}</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($attribute->values as $value)
                                    <div class="df-form-check" style="background:var(--df-body-bg); padding:8px 14px; border-radius:10px;">
                                        <input type="checkbox" name="attribute_values[]" value="{{ $value->id }}"
                                               id="attrVal{{ $value->id }}"
                                               {{ in_array($value->id, old('attribute_values', $selectedValues)) ? 'checked' : '' }}>
                                        <label for="attrVal{{ $value->id }}">{{ $value->value }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-4">

            {{-- Publish --}}
            <div class="df-card">
                <div class="df-card-header">
                    <h5 class="df-card-title"><i class="bi bi-send"></i> Publish</h5>
                </div>
                <div class="df-card-body">
                    <label class="df-form-label">Status</label>
                    <select name="is_active" class="df-form-select mb-3">
                        <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>✅ Active</option>
                        <option value="0" {{ old('is_active', $product->is_active) == 0 ? 'selected' : '' }}>📝 Draft</option>
                    </select>
                    <button type="submit" class="df-btn df-btn-primary w-100">
                        <i class="bi bi-check2-circle"></i> Update Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="df-btn df-btn-light w-100 mt-2" style="justify-content: center;">
                        <i class="bi bi-arrow-left"></i> Back to Products
                    </a>
                </div>
            </div>

            {{-- Category --}}
            <div class="df-card">
                <div class="df-card-header">
                    <h5 class="df-card-title"><i class="bi bi-folder2-open"></i> Category</h5>
                </div>
                <div class="df-card-body">
                    <select name="category_id" class="df-form-select">
                        <option value="">— Select Category —</option>
                        @foreach($categories as $cat)
                            @include('backend.categories.partials.category-options', ['category' => $cat, 'level' => 0, 'selected' => old('category_id', $product->category_id)])
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Brand --}}
            <div class="df-card">
                <div class="df-card-header">
                    <h5 class="df-card-title"><i class="bi bi-award"></i> Brand</h5>
                </div>
                <div class="df-card-body">
                    <select name="brand_id" class="df-form-select">
                        <option value="">— Select Brand —</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Tags --}}
            <div class="df-card">
                <div class="df-card-header">
                    <h5 class="df-card-title"><i class="bi bi-bookmark-star"></i> Tags</h5>
                </div>
                <div class="df-card-body">
                    @php $selectedTags = old('tag_ids', $product->tags->pluck('id')->toArray()); @endphp
                    @if($tags->count())
                        <div class="df-tag-list">
                            @foreach($tags as $tag)
                                <div class="df-tag-item">
                                    <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}"
                                           id="tag{{ $tag->id }}"
                                           {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}>
                                    <label for="tag{{ $tag->id }}">{{ $tag->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="df-form-hint text-center">No tags available. <a href="{{ route('admin.tags.create') }}">Create one</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function toggleProductType() {
    const type = document.getElementById('productType').value;
    document.getElementById('simpleFields').style.display   = type === 'simple' ? 'block' : 'none';
    document.getElementById('variableFields').style.display  = type === 'variable' ? 'block' : 'none';
}

function previewImages(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:100px;height:100px;object-fit:cover;border-radius:12px;border:1px solid var(--df-border-color);';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

document.addEventListener('DOMContentLoaded', toggleProductType);
</script>
@endpush

@endsection