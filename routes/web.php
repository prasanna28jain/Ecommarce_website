<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BackendProductController;
use App\Http\Controllers\Backend\BackendCategoryController;
use App\Http\Controllers\Backend\BackendBrandController;
use App\Http\Controllers\Backend\BackendOrderController;
use App\Http\Controllers\Backend\BackendCartController;
use App\Http\Controllers\Backend\BackendProductImageController;
use App\Http\Controllers\Backend\BackendProductVariationController;
use App\Http\Controllers\Backend\BackendUserController;
use App\Http\Controllers\Backend\BackendWishlistController;
use App\Http\Controllers\Backend\BackendOrderItemController;
use App\Http\Controllers\Backend\BackendCouponController;
use App\Http\Controllers\Backend\BackendPaymentProviderController;
use App\Http\Controllers\Backend\BackendSettingController;
use App\Http\Controllers\Backend\BackendPageController;
use App\Http\Controllers\Backend\BackendSliderController;
use App\Http\Controllers\Backend\BackendShipmentController;
use App\Http\Controllers\Backend\BackendDeliveryPartnerController;
use App\Http\Controllers\Backend\BackendAttributeController;
use App\Http\Controllers\Backend\BackendTagController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\FrontendProductController;
use App\Http\Controllers\Frontend\FrontendCategoryController;
use App\Http\Controllers\Frontend\FrontendBrandController;
use App\Http\Controllers\Frontend\FrontendCartController;
use App\Http\Controllers\Frontend\FrontendAccountController;
use App\Http\Controllers\Frontend\FrontendOrderController;
use App\Http\Controllers\Frontend\FrontendCheckoutController;
use App\Http\Controllers\Frontend\FrontendWishlistController;





Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && ($user->hasRole('admin') || $user->can('access admin'))) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('account.index');
})
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/products', [FrontendProductController::class,'index'])->name('products.index');
Route::get('/product/{slug}', [FrontendProductController::class,'show'])->name('product.show');
Route::get('/categories', [FrontendCategoryController::class,'index'])->name('categories.index');
Route::get('/category/{id}', [FrontendCategoryController::class,'show'])->name('category.show');
Route::get('/brands', [FrontendBrandController::class,'index'])->name('brands.index');
Route::get('/brand/{id}', [FrontendBrandController::class,'show'])->name('brand.show');
Route::post('/cart/add', [FrontendCartController::class, 'add'])->name('cart.add');
Route::post('/wishlist/toggle', [FrontendWishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/webhooks/razorpay', [FrontendCheckoutController::class, 'razorpayWebhook'])
    ->name('webhooks.razorpay')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Auth
// Auth::routes();

// User (frontend) protected
Route::middleware(['auth'])->group(function(){
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [FrontendAccountController::class, 'index'])->name('index');
        Route::get('/profile', [FrontendAccountController::class, 'profile'])->name('profile');
        Route::put('/profile', [FrontendAccountController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [FrontendAccountController::class, 'updatePassword'])->name('password.update');
        Route::get('/orders', [FrontendOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [FrontendOrderController::class, 'show'])->name('orders.show');
    });

    Route::get('/cart', [FrontendCartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/{cart}', [FrontendCartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [FrontendCartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/checkout', [FrontendCheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/coupon', [FrontendCheckoutController::class, 'applyCoupon'])->name('checkout.coupon.apply');
    Route::delete('/checkout/coupon', [FrontendCheckoutController::class, 'removeCoupon'])->name('checkout.coupon.remove');
    Route::post('/checkout/place-order', [FrontendCheckoutController::class, 'placeOrder'])->name('checkout.place');
    Route::post('/checkout/razorpay/verify', [FrontendCheckoutController::class, 'verifyRazorpay'])->name('checkout.razorpay.verify');
    Route::get('/checkout/success/{order}', [FrontendCheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/wishlist', [FrontendWishlistController::class, 'index'])->name('wishlist.index');
    Route::get('/orders', [FrontendOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [FrontendOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [FrontendOrderController::class, 'cancel'])->name('orders.cancel');
});

// Admin
Route::prefix('admin')->middleware(['auth','admin'])->name('admin.')->group(function(){
    Route::get('/', DashboardController::class . '@index')->name('dashboard');
    Route::resource('products', BackendProductController::class);
    
    // Product variation routes
    Route::post('products/{product}/variations', [BackendProductController::class, 'storeVariation'])->name('products.variations.store');
    Route::put('variations/{variation}', [BackendProductController::class, 'updateVariation'])->name('variations.update');
    Route::delete('variations/{variation}', [BackendProductController::class, 'destroyVariation'])->name('variations.destroy');
    
    Route::resource('categories', BackendCategoryController::class);
    Route::resource('attributes', BackendAttributeController::class);
    Route::resource('tags', BackendTagController::class);
    Route::resource('coupons', BackendCouponController::class);
    Route::resource('payment-providers', BackendPaymentProviderController::class);
    Route::post('payment-providers/{paymentProvider}/toggle', [BackendPaymentProviderController::class, 'toggleStatus'])->name('payment-providers.toggle');
    Route::get('payment-settings', [BackendPaymentProviderController::class, 'settings'])->name('payment-providers.settings');
    Route::put('payment-settings', [BackendPaymentProviderController::class, 'updateSettings'])->name('payment-providers.settings.update');
    Route::get('settings', [BackendSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [BackendSettingController::class, 'update'])->name('settings.update');
    Route::resource('pages', BackendPageController::class);
    Route::resource('sliders', BackendSliderController::class);
    Route::post('sliders/reorder', [BackendSliderController::class, 'reorder'])->name('sliders.reorder');
    Route::resource('delivery-partners', BackendDeliveryPartnerController::class);
    Route::resource('orders', BackendOrderController::class)->only(['index','show','update']);
    Route::get('orders-export', [BackendOrderController::class, 'exportCsv'])->name('orders.export');
    Route::post('orders/{order}/cancel', [BackendOrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('orders/{order}/refund', [BackendOrderController::class, 'refund'])->name('orders.refund');
    Route::get('orders/{order}/invoice', [BackendOrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('orders/{order}/credit-note/{refund}', [BackendOrderController::class, 'creditNote'])->name('orders.credit-note');
    Route::post('orders/{order}/shipments', [BackendShipmentController::class, 'store'])->name('orders.shipments.store');
    Route::put('shipments/{shipment}', [BackendShipmentController::class, 'update'])->name('shipments.update');
    Route::delete('shipments/{shipment}', [BackendShipmentController::class, 'destroy'])->name('shipments.destroy');
    Route::resource('brands', BackendBrandController::class);
    // Route::resource('orders', BackendOrderController::class);
    // extra admin resources scaffolded from models
    Route::resource('carts', BackendCartController::class);
    Route::resource('product-variations', BackendProductVariationController::class);
    Route::resource('product-images', BackendProductImageController::class)->only(['index','destroy']);
    Route::resource('users', BackendUserController::class)->except(['create','store','show']);
    Route::resource('wishlists', BackendWishlistController::class)->only(['index','destroy']);
    Route::resource('order-items', BackendOrderItemController::class)->only(['index']);
});
require __DIR__.'/auth.php';



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
