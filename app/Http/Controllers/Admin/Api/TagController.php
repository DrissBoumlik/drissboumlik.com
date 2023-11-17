<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TagCollection;
use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::withTrashed()->withCount('posts');
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $tags = $tags->orderBy('id', 'desc');
        }
        return DataTables::eloquent($tags)->make(true);
    }
}
