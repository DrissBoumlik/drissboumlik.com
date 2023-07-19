<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostWithPaginationCollection;
use App\Http\Resources\TagWithPaginationCollection;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $perPage = 6;


    public function getPosts(Request $request)
    {
        $data = new \stdClass();
        $posts_data = (object) (new PostWithPaginationCollection(Post::with('author')
                                                ->orderBy('created_at', 'desc')
                                                ->paginate($this->perPage)))->resolve();

        $posts = $posts_data->data;
        unset($posts_data->data);


        $data->title = 'Blog | Latest Articles';
        $data->headline = 'Blog | Latest Articles';

        return view('pages.blog.posts.index', ['data' => $data, 'posts_data' => $posts_data, 'posts' => $posts]);
    }

    public function getPost(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->first();
        if ($post == null) {
            abort(404);
        }
        $post->increment('views', 1);
        $data = new \stdClass();

        $related_posts = $post->relatedPosts();
        $related_posts = (new PostCollection($related_posts))->resolve();

        $post = (object)(new PostResource($post))->resolve();
        $data->title = 'Blog | ' . $post->title;

        return view('pages.blog.posts.show', ['data' => $data, 'post' => $post, 'related_posts' => $related_posts]);
    }

    public function likePost(Request $request, $slug, $unlike = null)
    {
        $post = Post::where('slug', $slug)->first();
        $post->increment('likes', (bool) $unlike ? -1 : 1);
        return ['post' => $post];
    }

    public function getPostsByTag(Request $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->first();

        if ($tag == null) {
            abort(404);
        }

        $data = new \stdClass();
        $data->title = 'Blog | Tags | ' . $tag->name;
        $data->headline = 'Blog | Posts with tag : ' . $tag->name;
        $posts_data = (object) (new PostWithPaginationCollection($tag->posts()->with('author')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage)))->resolve();

        $posts = $posts_data->data;
        unset($posts_data->data);

        return view('pages.blog.posts.index', ['data' => $data, 'posts_data' => $posts_data, 'posts' => $posts]);
    }

    public function getTags(Request $request)
    {
        $data = new \stdClass();

        $data->tags_data = (new TagWithPaginationCollection(Tag::withCount('posts')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage)))->resolve();

        $tags = $data->tags_data['data'];
        unset($data->tags_data['data']);


        $data->title = 'Blog | Tags';

        return view('pages.blog.tags.index', ['data' => $data, 'tags' => $tags]);
    }
}