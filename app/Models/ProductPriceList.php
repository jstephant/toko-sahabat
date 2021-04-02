<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPriceList extends Model
{
    protected $table = 'product_price_list';
    protected $primaryKey = 'id';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function created_user()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    public function updated_user()
    {
        return $this->belongsTo(Users::class, 'updated_by');
    }
}
