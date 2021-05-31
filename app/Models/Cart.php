<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $id = 'id';
    protected $fillable = ['order_code', 'order_date', 'customer_id', 'customer_name', 'customer_phone', 'sub_total',
        'disc_price', 'total', 'status_id', 'created_by', 'created_at', 'updated_by', 'updated_at'];

    public function cart_detail()
    {
        return $this->hasMany(CartDetail::class, 'cart_id', 'id');
    }

    public function transaction_status()
    {
        return $this->belongsTo(TransactionStatus::class, 'status_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
