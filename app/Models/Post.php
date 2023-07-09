<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id', 'title', 'slug', 'excerpt',
        'content','cover','description','status',
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

    public function relatedPosts($take = 6)
    {
        return self::whereHas('tags', function ($q) {
            return $q->whereIn('tags.id', $this->tags->pluck('id'));
        })->where('id', '!=', $this->id)->take($take)->get();
    }

    public function getDomClass()
    {
        $classes = [
            0 => (object) ['value' => 0, 'class' => 'bg-gray text-gray-dark', 'text' => 'Draft'],
            1 => (object) ['value' => 1, 'class' => 'bg-warning-light text-warning', 'text' => 'Pending'],
            2 => (object) ['value' => 2, 'class' => 'bg-success-light text-success', 'text' => 'Published'],
        ];
        return $classes[$this->status];
    }
}
