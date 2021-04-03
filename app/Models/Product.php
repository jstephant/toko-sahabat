<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = ['code', 'name', 'sub_category_id', 'hpp', 'image_url', 'barcode', 'is_active', 'created_by', 'created_at', 'updated_by', 'udpated_at'];

    public function product_sub_category()
    {
        return $this->hasMany(ProductSubCategory::class, 'product_id', 'id');
    }

    public function created_user()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    public function updated_user()
    {
        return $this->belongsTo(Users::class, 'updated_by');
    }

    public function product_price_list()
    {
        return $this->hasMany(ProductPriceList::class, 'product_id', 'id');
    }

    public function getCreatedAtAttribute($date)
    {
        return date('j F Y H:i', strtotime($date));
    }
}
