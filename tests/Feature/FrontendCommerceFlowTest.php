<?php

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\PaymentProvider;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\User;
use App\Models\Wishlist;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

function checkoutPayloadForCommerceTest(array $overrides = []): array
{
    return array_merge([
        'payment_method' => 'cod',
        'billing_name' => 'John Doe',
        'billing_email' => 'john@example.com',
        'billing_phone' => '9999999999',
        'billing_line1' => 'Street 1',
        'billing_city' => 'Mumbai',
        'billing_state' => 'MH',
        'billing_zip' => '400001',
        'billing_country' => 'India',
        'shipping_same_as_billing' => '1',
    ], $overrides);
}

it('adds cart item with product_id and increments same product quantity only', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $productA = Product::create([
        'name' => 'Bench Press',
        'slug' => 'bench-press-' . uniqid(),
        'base_price' => 120,
        'is_active' => true,
    ]);

    $productB = Product::create([
        'name' => 'Dumbbell Set',
        'slug' => 'dumbbell-set-' . uniqid(),
        'base_price' => 80,
        'is_active' => true,
    ]);

    actingAs($user);

    post(route('cart.add'), [
        'product_id' => $productA->id,
        'quantity' => 1,
    ])->assertSessionHas('success');

    post(route('cart.add'), [
        'product_id' => $productA->id,
        'quantity' => 2,
    ])->assertSessionHas('success');

    post(route('cart.add'), [
        'product_id' => $productB->id,
        'quantity' => 1,
    ])->assertSessionHas('success');

    $itemA = Cart::where('user_id', $user->id)->where('product_id', $productA->id)->first();
    $itemB = Cart::where('user_id', $user->id)->where('product_id', $productB->id)->first();

    expect($itemA)->not->toBeNull();
    expect((int) $itemA->quantity)->toBe(3);
    expect((int) Cart::where('user_id', $user->id)->count())->toBe(2);
    expect($itemB)->not->toBeNull();
});

it('asks guest to login first when adding product to cart', function () {
    $product = Product::create([
        'name' => 'Guest Cart Product',
        'slug' => 'guest-cart-product-' . uniqid(),
        'base_price' => 149,
        'is_active' => true,
    ]);

    post(route('cart.add'), [
        'product_id' => $product->id,
        'quantity' => 1,
    ])->assertRedirect(route('login'))
      ->assertSessionHas('error', 'Please login first to add products to cart.');
});

it('applies and removes coupon from checkout session', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $product = Product::create([
        'name' => 'Kettlebell',
        'slug' => 'kettlebell-' . uniqid(),
        'base_price' => 100,
        'is_active' => true,
    ]);

    Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'product_variation_id' => null,
        'quantity' => 1,
        'price' => 100,
    ]);

    Coupon::create([
        'code' => 'SAVE10',
        'type' => 'percent',
        'amount' => 10,
        'is_active' => true,
    ]);

    actingAs($user);

    post(route('checkout.coupon.apply'), [
        'coupon_code' => 'save10',
    ])->assertSessionHas('checkout_coupon.code', 'SAVE10');

    delete(route('checkout.coupon.remove'))
        ->assertSessionMissing('checkout_coupon');
});

it('toggles wishlist for authenticated user', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $product = Product::create([
        'name' => 'Treadmill',
        'slug' => 'treadmill-' . uniqid(),
        'base_price' => 900,
        'is_active' => true,
    ]);

    actingAs($user);

    post(route('wishlist.toggle'), [
        'product_id' => $product->id,
    ])->assertSessionHas('success');

    expect((int) Wishlist::where('user_id', $user->id)->where('product_id', $product->id)->count())->toBe(1);

    post(route('wishlist.toggle'), [
        'product_id' => $product->id,
    ])->assertSessionHas('success');

    expect((int) Wishlist::where('user_id', $user->id)->where('product_id', $product->id)->count())->toBe(0);
});

it('asks guest to login first when adding product to wishlist', function () {
    $product = Product::create([
        'name' => 'Guest Wishlist Product',
        'slug' => 'guest-wishlist-product-' . uniqid(),
        'base_price' => 199,
        'is_active' => true,
    ]);

    post(route('wishlist.toggle'), [
        'product_id' => $product->id,
    ])->assertRedirect(route('login'))
      ->assertSessionHas('error', 'Please login first to add products to wishlist.');
});

it('places cod order with coupon discount applied to total', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $product = Product::create([
        'name' => 'Row Machine',
        'slug' => 'row-machine-' . uniqid(),
        'base_price' => 100,
        'is_active' => true,
    ]);

    PaymentProvider::updateOrCreate(
        ['slug' => 'cod'],
        ['name' => 'Cash on Delivery', 'is_active' => true]
    );

    $coupon = Coupon::create([
        'code' => 'LESS50',
        'type' => 'fixed',
        'amount' => 50,
        'is_active' => true,
    ]);

    Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'product_variation_id' => null,
        'quantity' => 2,
        'price' => 100,
    ]);

    actingAs($user);

    post(route('checkout.coupon.apply'), [
        'coupon_code' => 'LESS50',
    ])->assertSessionHas('checkout_coupon.code', 'LESS50');

    post(route('checkout.place'), checkoutPayloadForCommerceTest())
        ->assertRedirect();

    $order = Order::latest('id')->first();

    expect($order)->not->toBeNull();
    expect((float) $order->total)->toBe(150.0);
    expect((int) $coupon->fresh()->used_count)->toBe(1);
    expect(data_get($order->payment_meta, 'coupon.code'))->toBe('LESS50');
});

it('shows cart summary with coupon and supports quantity update and remove', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $product = Product::create([
        'name' => 'Power Rack',
        'slug' => 'power-rack-' . uniqid(),
        'base_price' => 250,
        'is_active' => true,
    ]);

    $cart = Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'product_variation_id' => null,
        'quantity' => 1,
        'price' => 250,
    ]);

    Coupon::create([
        'code' => 'PCT10',
        'type' => 'percent',
        'amount' => 10,
        'is_active' => true,
    ]);

    actingAs($user);

    post(route('checkout.coupon.apply'), [
        'coupon_code' => 'PCT10',
    ])->assertSessionHas('checkout_coupon.code', 'PCT10');

    get(route('cart.index'))
        ->assertOk()
        ->assertSee('PCT10')
        ->assertSee('Rs 250.00')
        ->assertSee('Rs 225.00');

    patch(route('cart.update', $cart), [
        'quantity' => 3,
    ])->assertSessionHas('success');

    expect((int) $cart->fresh()->quantity)->toBe(3);

    delete(route('cart.destroy', $cart))
        ->assertSessionHas('success');

    expect((int) Cart::where('user_id', $user->id)->count())->toBe(0);
});

it('requires variation for variable product cart add and stores selected variation', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $product = Product::create([
        'name' => 'Protein Pack',
        'slug' => 'protein-pack-' . uniqid(),
        'base_price' => 100,
        'is_active' => true,
        'product_type' => 'variable',
    ]);

    $variation = ProductVariation::create([
        'product_id' => $product->id,
        'sku' => 'PROT-' . uniqid(),
        'price' => 120,
        'stock' => 10,
        'attributes' => ['size' => 'Large'],
        'is_active' => true,
    ]);

    actingAs($user);

    post(route('cart.add'), [
        'product_id' => $product->id,
        'quantity' => 1,
    ])->assertSessionHas('error');

    post(route('cart.add'), [
        'product_id' => $product->id,
        'product_variation_id' => $variation->id,
        'quantity' => 2,
    ])->assertSessionHas('success');

    $cartItem = Cart::where('user_id', $user->id)
        ->where('product_id', $product->id)
        ->where('product_variation_id', $variation->id)
        ->first();

    expect($cartItem)->not->toBeNull();
    expect((int) $cartItem->quantity)->toBe(2);
    expect((float) $cartItem->price)->toBe(120.0);
});

it('toggles wishlist by selected variation for variable products', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $product = Product::create([
        'name' => 'Energy Drink Pack',
        'slug' => 'energy-drink-pack-' . uniqid(),
        'base_price' => 75,
        'is_active' => true,
        'product_type' => 'variable',
    ]);

    $variation = ProductVariation::create([
        'product_id' => $product->id,
        'sku' => 'ENRG-' . uniqid(),
        'price' => 90,
        'stock' => 15,
        'attributes' => ['flavor' => 'Orange'],
        'is_active' => true,
    ]);

    actingAs($user);

    post(route('wishlist.toggle'), [
        'product_id' => $product->id,
    ])->assertSessionHas('error');

    post(route('wishlist.toggle'), [
        'product_id' => $product->id,
        'product_variation_id' => $variation->id,
    ])->assertSessionHas('success');

    expect((int) Wishlist::where('user_id', $user->id)
        ->where('product_id', $product->id)
        ->where('product_variation_id', $variation->id)
        ->count())->toBe(1);

    post(route('wishlist.toggle'), [
        'product_id' => $product->id,
        'product_variation_id' => $variation->id,
    ])->assertSessionHas('success');

    expect((int) Wishlist::where('user_id', $user->id)
        ->where('product_id', $product->id)
        ->where('product_variation_id', $variation->id)
        ->count())->toBe(0);
});
