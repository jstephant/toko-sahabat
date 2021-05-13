<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSatuan extends Model
{
    protected $table = 'product_satuan';
    protected $fillable = ['product_id', 'satuan_id'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id', 'id');
    }
}

