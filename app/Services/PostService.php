<?php

namespace App\Services;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostWithPaginationCollection;
use App\Models\Post;

class PostService
{
    private const LATEST_FEATURED_POSTS_COUNT = 4;
    private const POSTS_PER_PAGE = 10;


    public function getLatestFeaturedPosts()
    {
        $posts = Post::where('featured', true)->where('status', 2); // Published Posts
        return (new PostCollection($posts->orderBy('updated_at', 'desc')->take(self::LATEST_FEATURED_POSTS_COUNT)->get()))->resolve();
    }


    public function preparePosts($posts)
    {
        if (!\Auth::check()) {
            $posts = $posts->where('status', 2); // Published Posts
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
