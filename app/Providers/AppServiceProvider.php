<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Setting;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $setting = Schema::hasTable('settings') ? Setting::query()->first() : null;

        View::share('appSetting', $setting);

        if ($setting && $setting->smtp_host) {
            Config::set('mail.default', 'smtp');
            Config::set('mail.mailers.smtp.host', $setting->smtp_host);
            Config::set('mail.mailers.smtp.port', (int) ($setting->smtp_port ?: 587));
            Config::set('mail.mailers.smtp.username', $setting->smtp_username);
            Config::set('mail.mailers.smtp.password', $setting->smtp_password);
            Config::set('mail.mailers.smtp.scheme', $setting->smtp_encryption ?: null);
            Config::set('mail.from.address', $setting->smtp_from_email ?: config('mail.from.address'));
            Config::set('mail.from.name', $setting->smtp_from_name ?: config('mail.from.name'));
        }

        View::composer('layouts.frontend', function ($view): void {
            $cartCount = 0;
            $wishlistCount = 0;

            if (Auth::check()) {
                $cartCount = (int) Cart::where('user_id', Auth::id())->sum('quantity');
                $wishlistCount = (int) Wishlist::where('user_id', Auth::id())->count();
            }

            $view->with('headerCartCount', $cartCount)
                ->with('headerWishlistCount', $wishlistCount);
        });
    }
}
