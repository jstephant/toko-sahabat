<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function order_product()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
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
