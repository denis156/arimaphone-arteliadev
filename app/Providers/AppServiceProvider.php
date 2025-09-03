<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductImage;
use App\Observers\UserObserver;
use App\Observers\ProductObserver;
use App\Observers\ProductImageObserver;
use App\Listeners\SetUserOfflineOnLogout;
use App\Listeners\SetUserOnlineOnLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
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
        User::observe(UserObserver::class);
        Product::observe(ProductObserver::class);
        ProductImage::observe(ProductImageObserver::class);

        // Register event listeners untuk login dan logout
        Event::listen([
            Login::class => SetUserOnlineOnLogin::class,
            Logout::class => SetUserOfflineOnLogout::class,
        ]);
    }
}
