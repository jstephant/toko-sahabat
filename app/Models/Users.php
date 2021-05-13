<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'user_name', 'email', 'password', 'role_id', 'is_active', 'created_at', 'updated_at'];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
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
