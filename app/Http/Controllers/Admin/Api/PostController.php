<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Resources\Admin\PostCollection;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::withTrashed()->orderBy('created_at', 'desc')->get();
        $posts = (new PostCollection($posts))->resolve();
        $posts = \DataTables::of($posts)->toJson();
        return $posts;
    }
}
