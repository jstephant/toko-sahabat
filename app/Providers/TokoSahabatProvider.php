<?php

namespace App\Providers;

use App\Services\Cart\ICart;
use App\Services\Cart\SCart;
use App\Services\Category\ICategory;
use App\Services\Category\SCategory;
use App\Services\Customer\ICustomer;
use App\Services\Customer\SCustomer;
use App\Services\IGlobal;
use App\Services\Inventory\IInventory;
use App\Services\Inventory\SInventory;
use App\Services\Orders\IOrder;
use App\Services\Orders\SOrder;
use App\Services\Payment\IPayment;
use App\Services\Payment\SPayment;
use App\Services\PriceList\IPriceList;
use App\Services\PriceList\SPriceList;
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
        $this->app->bind(IOrder::class, SOrder::class);
        $this->app->bind(IPayment::class, SPayment::class);
        $this->app->bind(IInventory::class, SInventory::class);
        $this->app->bind(IPriceList::class, SPriceList::class);
        $this->app->bind(ICart::class, SCart::class);
    }
}
