<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'image', 'role', 'title', 'description', 'featured', 'links', 'active', 'order', 'note' ];

    protected $casts = [ "links" => "object", "image" => "object" ];
}
