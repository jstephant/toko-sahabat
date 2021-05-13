<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseStatus extends Model
{
    protected $table = 'purchase_status';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
