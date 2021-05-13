<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuan';
    protected $primaryKey = 'id';
    protected $fillable = ['code', 'name', 'qty'];
    public $timestamps = false;

    public function order_product()
    {
        return $this->hasMany(OrderProduct::class, 'satuan_id', 'id');
    }

    public function purchase_product()
    {
        return $this->hasMany(PurchaseProduct::class, 'satuan_id', 'id');
    }

    public function product_price_list()
    {
        return $this->hasMany(ProductPriceList::class, 'satuan_id', 'id');
    }

    public function getCreatedAtAttribute($date)
    {
        return date('j F Y H:i', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return ($date) ? date('j F Y H:i', strtotime($date)) : null;
    }
}
