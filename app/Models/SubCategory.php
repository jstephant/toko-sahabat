<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'product_sub_category';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'category_id', 'is_active'];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'sub_category_id', 'id');
    }
}
