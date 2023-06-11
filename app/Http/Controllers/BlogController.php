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


        $data->posts = $data->posts_data['data'];
        unset($data->posts_data['data']);

        // dd($data->posts_data);


//        $data->socialLinks = getSocialLinks();
//        $data->headerMenu = getHeaderMenu();

        $data->title = 'Driss Boumlik | Blog';

        return view('pages.blog.posts.index', ['data' => $data]);
    }

    public function show(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->first();
        $data = new \stdClass();
        $data->post = (object)(new PostResource($post))->resolve();
//        $data->socialLinks = getSocialLinks();
//        $data->headerMenu = getHeaderMenu();

        $data->title = 'Blog | ' . $post->title;

        return view('pages.blog.posts.show', ['data' => $data]);
    }
}
