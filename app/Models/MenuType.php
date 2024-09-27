<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'name', 'slug', 'description', 'active' ];


    public function menus()
    {
        return $this->hasMany(Menu::class)->withTrashed();
    }

}
