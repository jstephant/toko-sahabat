<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'user_name', 'email', 'password', 'is_active', 'created_at', 'updated_at'];

    public function user_role()
    {
        return $this->hasMany(UserRole::class, 'user_id', 'id');
    }

    public function getCreatedAtAttribute($date)
    {
        return date('d-m-Y H:i:s', strtotime($date));
    }
}
