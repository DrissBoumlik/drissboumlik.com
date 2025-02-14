<?php

namespace App\Services;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostWithPaginationCollection;
use App\Models\Post;

class PostService
{
    private const LATEST_FEATURED_POSTS_COUNT = 4;
    private const POSTS_PER_PAGE = 10;

    public function publishedOnly($query)
    {
        return $query->where('published', true);
    }

    public function getLatestFeaturedPosts()
    {
        $posts = Post::with('author', 'tags')->where('featured', true)->where('published', true); // Published Posts
        return (new PostCollection($posts->orderBy('updated_at', 'desc')->take(self::LATEST_FEATURED_POSTS_COUNT)->get()))->resolve();
    }


    public function preparePosts($posts, $guestView = false)
    {
        if (isGuest($guestView)) {
            $posts = $this->publishedOnly($posts);
        }
        $posts_data = (object) (new PostWithPaginationCollection($posts
            ->orderBy('created_at', 'desc')
            ->paginate(self::POSTS_PER_PAGE)));

        $posts = $posts_data->resolve();

        return [
            'posts_data' => $posts_data,
            'posts' => $posts
        ];

    }

}
