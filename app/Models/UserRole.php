<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_role';
    protected $fillable = ['user_id', 'role_id'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
}
