<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureRole extends Model
{
    protected $table = 'feature_role';
    protected $fillable = ['feature_id', 'role_id', 'is_access', 'is_create', 'is_edit', 'is_delete', 'is_landing_page'];
    public $timestamps = false;

    public function feature()
    {
        return $this->belongsTo(Features::class, 'feature_id');
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
}
