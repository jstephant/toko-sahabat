<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = ['order_code', 'order_date', 'cart_id', 'customer_id', 'sub_total', 'disc_price', 'total',
                        'delivery_address', 'notes', 'payment_status_id', 'status_id', 'created_by', 'created_at', 'updated_by', 'updated_at'];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function payment_status()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function transaction_status()
    {
        return $this->belongsTo(TransactionStatus::class, 'status_id');
    }

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
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
