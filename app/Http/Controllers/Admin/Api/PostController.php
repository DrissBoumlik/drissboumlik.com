<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Resources\Admin\PostCollection;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::withTrashed()->withCount('tags');
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $posts = $posts->orderBy('id', 'desc');
        }
        return DataTables::eloquent($posts)->make(true);
    }
}
