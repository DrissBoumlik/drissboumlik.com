<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Post extends Model implements Feedable
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

    public function getAllFeedItems()
    {
        return self::where('status', '=', 2)
            ->orderBy('published_at')->get();
    }

    public function toFeedItem(): FeedItem
    {
        $summary = "<img src='/$this->cover' class='img-fluid'>
                    <p>$this->excerpt</p>
                    <p><a href='/blog/$this->slug'>Read More...</a></p>
                    ";
        return FeedItem::create([
                'id' => $this->id,
                'title' => $this->title,
                'summary' => $summary,
                'updated' => $this->updated_at,
                'link' => "/blog/$this->slug",
                'authorName' => "Driss",
            ]);
    }
}
