<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id', 'category_id', 'title', 'slug', 'excerpt',
        'content','image','meta_description','tags','status',
        'featured','likes','views'
    ];
}
