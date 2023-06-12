<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $perPage = 6;


    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->posts_data = (new PostCollection(Post::with('tags', 'author')
                                                ->orderBy('created_at', 'desc')
                                                ->paginate($this->perPage)))->resolve();

        $posts = $data->posts_data['data'];
        unset($data->posts_data['data']);

        $data->title = 'Driss Boumlik | Blog';

        return view('pages.blog.posts.index', ['data' => $data, 'posts' => $posts]);
    }

    public function show(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->first();
//        $post->increment('views', 1);
        $data = new \stdClass();

        $post = (object)(new PostResource($post))->resolve();
        $data->title = 'Blog | ' . $post->title;
        return view('pages.blog.posts.show', ['data' => $data, 'post' => $post]);
    }

    public function likePost(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->first();
        $post->increment('likes', 1);
        return ['post' => $post];
    }

    public function getPostsByTag(Request $request, $tag = null)
    {
        if ($tag) {
            $data = new \stdClass();
            $data->posts = Post::where('meta_keywords', 'like', '%' . $tag . '%')->paginate(5);

            $data->title = 'Blog | Tags - ' . $tag;

            return view('pages.blog.posts.index', ['data' => $data]);
        } else {
            return redirect('/blog');
        }
    }
}
