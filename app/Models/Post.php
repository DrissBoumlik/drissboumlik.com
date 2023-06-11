<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id', 'title', 'slug', 'excerpt',
        'content','image','description','status',
        'featured','likes','views', 'published_at',
    ];
    
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
