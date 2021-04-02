<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';

     public function orders()
     {
         return $this->belongsTo(Orders::class, 'order_id');
     }

     public function product()
     {
         return $this->belongsTo(Product::class, 'product_id');
     }

     public function satuan()
     {
         return $this->belongsTo(Satuan::class, 'satuan_id');
     }
}
