<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'is_active'];
    public $timestamps = false;

    public function sub_category()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
