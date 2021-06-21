<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function getPostsByTag(Request $request, $tag = null)
    {
        $data = new \stdClass();
        $data->posts = Post::where('tags', 'like', '%' . $tag . '%')->get();

        $data->socialLinks = getSocialLinks();
        $data->menuFooter = getFooterMenu();

        return view('pages.blog.posts.index', ['data' => $data]);
    }
}
