<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    protected $table = 'features';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'is_main_menu', 'parent_id', 'sequence', 'has_sub_menu', 'link', 'icon', 'is_access', 'is_create', 'is_edit', 'is_delete', 'is_landing_page', 'is_active'];
    public $timetamps = false;
}
