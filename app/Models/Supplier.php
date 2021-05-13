<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'mobile_phone', 'email', 'is_active', 'created_by', 'created_at', 'updated_by', 'updated_at'];

    public function purchase()
    {
        return $this->hasMany(Purchase::class, 'supplier_id', 'id');
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
