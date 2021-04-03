<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchase';
    protected $primaryKey = 'id';

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
}
