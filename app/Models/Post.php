<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use VanOns\Laraberg\Models\Gutenbergable;


class Post extends Model
{
    use HasFactory, SoftDeletes, Gutenbergable;

    protected $fillable = ['title', 'slug', 'body', 'excerpt', 'tags', 'status'];

    protected $casts = [
        'tags' => 'array'
    ];
}
