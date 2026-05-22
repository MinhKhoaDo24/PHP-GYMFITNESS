<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\IAdminRepository;
use App\Repositories\AdminRepository;

use App\Repositories\IProductRepository;
use App\Repositories\ProductRepository;



use App\Repositories\IDanhmucRepository;
use App\Repositories\DanhmucRepository;

use App\Repositories\IOrderRepository;
use App\Repositories\OrderRepository;

use App\Repositories\IKhuyenmaiRepository;
use App\Repositories\KhuyenmaiRepository;

use App\Repositories\IUserRepository;
use App\Repositories\UserRepository;

use App\Repositories\IDangkidichvuRepository;
use App\Repositories\DangkidichvuRepository;


use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Danhmuc;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(IDanhmucRepository::class, DanhmucRepository::class);
        $this->app->bind(IAdminRepository::class, AdminRepository::class);
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
        $this->app->bind(IKhuyenmaiRepository::class, KhuyenmaiRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IDangkidichvuRepository::class,DangkidichvuRepository::class
    );
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $view->with('categories', Danhmuc::all());
        });
    }

}
