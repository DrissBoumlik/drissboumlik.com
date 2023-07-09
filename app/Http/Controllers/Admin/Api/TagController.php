<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TagCollection;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::withTrashed()->withCount('posts')->orderBy('created_at', 'desc')->get();
        $tags = (new TagCollection($tags))->resolve();
        $tags = \DataTables::of($tags)->toJson();
        return $tags;
    }
}
