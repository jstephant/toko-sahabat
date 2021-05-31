<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $id = 'id';
    protected $fillable = ['payment_code', 'payment_date', 'order_id', 'sub_total', 'disc_price', 'grand_total', 'payment_type_id',
                            'pay_total', 'pay_changed', 'card_number', 'batch_no', 'expired_year', 'expired_month', 'status_id',
                            'created_by', 'created_at', 'updated_by', 'updated_at'];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function payment_status()
    {
        return $this->belongsTo(PaymentStatus::class, 'status_id');
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
