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
        $data->posts = Post::orderBy('updated_at', 'desc')->paginate($this->perPage);

        $data->socialLinks = getSocialLinks();
        $data->menuFooter = getFooterMenu();

        return view('pages.blog.posts.index', ['data' => $data]);
    }

    public function show(Request $request, Post $post)
    {
        $data = new \stdClass();
        $data->post = $post;

        $data->socialLinks = getSocialLinks();
        $data->menuFooter = getFooterMenu();

        return view('pages.blog.posts.show', ['data' => $data]);
    }
}
