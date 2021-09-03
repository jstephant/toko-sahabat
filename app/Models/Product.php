<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = ['code', 'name', 'category_id', 'hpp', 'image_name', 'barcode', 'is_active', 'created_by', 'created_at', 'updated_by', 'udpated_at'];

    public function product_category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function product_satuan()
    {
        return $this->hasMany(ProductSatuan::class, 'product_id', 'id');
    }

    public function product_price_list()
    {
        return $this->hasMany(ProductPriceList::class, 'product_id', 'id');
    }

    public function created_user()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    public function updated_user()
    {
        return $this->belongsTo(Users::class, 'updated_by');
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
