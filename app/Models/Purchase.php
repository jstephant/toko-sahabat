<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchase';
    protected $primaryKey = 'id';
    protected $fillable = ['purchase_number', 'purchase_date', 'supplier_id', 'sub_total', 'disc_price', 'total', 'notes', 'status_id', 'created_by', 'created_at', 'updated_by', 'updated_at'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function created_user()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    public function updated_user()
    {
        return $this->belongsTo(Users::class, 'updated_by');
    }

    public function purchase_product()
    {
        return $this->hasMany(PurchaseProduct::class, 'purchase_id', 'id');
    }

    public function transaction_status()
    {
        return $this->belongsTo(TransactionStatus::class, 'status_id');
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
