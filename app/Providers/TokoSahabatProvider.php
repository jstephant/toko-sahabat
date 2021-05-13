<?php

namespace App\Providers;

use App\Services\Category\ICategory;
use App\Services\Category\SCategory;
use App\Services\Customer\ICustomer;
use App\Services\Customer\SCustomer;
use App\Services\IGlobal;
use App\Services\Product\IProduct;
use App\Services\Product\SProduct;
use App\Services\Purchase\IPurchase;
use App\Services\Purchase\SPurchase;
use App\Services\Roles\IRole;
use App\Services\Roles\SRole;
use App\Services\Satuan\ISatuan;
use App\Services\Satuan\SSatuan;
use App\Services\SGlobal;
use App\Services\SubCategory\ISubCategory;
use App\Services\SubCategory\SSubCategory;
use App\Services\Supplier\ISupplier;
use App\Services\Supplier\SSupplier;
use App\Services\User\IUser;
use App\Services\User\SUser;
use Illuminate\Support\ServiceProvider;

class TokoSahabatProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IGlobal::class, SGlobal::class);
        $this->app->bind(IUser::class, SUser::class);
        $this->app->bind(IRole::class, SRole::class);
        $this->app->bind(ICategory::class, SCategory::class);
        $this->app->bind(ISubCategory::class, SSubCategory::class);
        $this->app->bind(ISatuan::class, SSatuan::class);
        $this->app->bind(IProduct::class. SProduct::class);
        $this->app->bind(ISupplier::class, SSupplier::class);
        $this->app->bind(IPurchase::class, SPurchase::class);
        $this->app->bind(ICustomer::class. SCustomer::class);
    }
}
