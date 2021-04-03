<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'mobile_phone', 'is_active', 'created_by', 'created_at', 'updated_by', 'updated_at'];

    public function created_user()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    public function updated_user()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    public function getCreatedAtAttribute($date)
    {
        return date('j F Y H:i', strtotime($date));
    }
}
