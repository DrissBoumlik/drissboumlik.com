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
        'content', 'cover', 'description', 'published',
        'featured', 'active', 'likes', 'views', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        "cover" => "object",
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

    public function getAllFeedItems()
    {
        return self::where('published', true)->orderBy('published_at')->get();
    }

    public function toFeedItem(): FeedItem
    {
        $post_cover = $this->cover ? "/" . $this->cover->original : '/assets/img/blog/default-post.webp';
        $summary = "<img src='$post_cover' class='post-cover' alt='$this->title' />
                    <p class='description'>$this->excerpt</p>
                    <p class='post-link'><a href='/blog/$this->slug'>Read More...</a></p>";
        return FeedItem::create([
                'id' => $this->id,
                'title' => $this->title,
                'summary' => $summary,
                'updated' => $this->published_at ?? $this->updated_at,
                'link' => "/blog/$this->slug",
                'authorName' => "Driss Boumlik",
            ]);
    }
}
