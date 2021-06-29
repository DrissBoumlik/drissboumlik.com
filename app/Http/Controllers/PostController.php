<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $perPage = 5;

    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->posts = Post::orderBy('created_at', 'desc')->paginate($this->perPage);

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();

        $data->title = 'Driss Boumlik | Blog';

        return view('pages.blog.posts.index', ['data' => $data]);
    }

    public function show(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->first();
        $data = new \stdClass();
        $data->post = $post;

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();

        $data->title = 'Blog | ' . $post->title;

        return view('pages.blog.posts.show', ['data' => $data]);
    }

    public function getPostsByTag(Request $request, $tag = null)
    {
        if ($tag) {
            $data = new \stdClass();
            $data->posts = Post::where('meta_keywords', 'like', '%' . $tag . '%')->paginate(5);

            $data->socialLinks = getSocialLinks();
            $data->headerMenu = getHeaderMenu();

            $data->title = 'Blog | Tags - ' . $tag;

            return view('pages.blog.posts.index', ['data' => $data]);
        } else {
            return redirect('/blog');
        }
    }
}
