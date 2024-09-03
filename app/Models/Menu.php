<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'text', 'title', 'slug', 'target', 'link', 'icon', 'menu_type_id', 'active', 'order' ];

    public function menuType()
    {
        return $this->belongsTo(MenuType::class);
    }

}
