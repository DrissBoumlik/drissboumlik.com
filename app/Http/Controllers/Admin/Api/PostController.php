<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    private MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }
    public function index(Request $request)
    {
        $posts = Post::withTrashed()->withCount('tags');
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $posts = $posts->orderBy('id', 'desc');
        }
        return DataTables::eloquent($posts)->make(true);
    }

    public function getPostAssets(Request $request, $slug)
    {
        $assets_path = "storage/blog/posts/$slug/assets";
        $post_assets = $this->mediaService->fetchAllAssets($assets_path);
        return ['post_assets' => $post_assets];
    }
}
