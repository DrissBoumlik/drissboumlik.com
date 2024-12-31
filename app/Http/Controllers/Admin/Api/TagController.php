<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    private MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }
    public function index(Request $request)
    {
        $tags = Tag::withTrashed()->withCount('posts');
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $tags = $tags->orderBy('id', 'desc');
        }
        return DataTables::eloquent($tags)->make(true);
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                "name"          => "required|string",
                "slug"          => "required|unique:tags,slug",
                "description"   => "required|string",
            ]);

            $data = [
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description,
                "color" => $request->color,
                "active" => $request->has('active'),
            ];
            $image_file = $request->file('cover');
            if ($image_file) {
                $data['cover'] = $this->mediaService->processAsset("blog/tags/$request->slug", $request->slug, $image_file);
            }
            $tag = Tag::create($data);
            return response()->json([
                'tag' => $tag,
                'message' => 'Tag store successfully !',
                'class' => 'alert-info',
                'icon' => '<i class="fa fa-fw fa-circle-check"></i>'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'class' => 'alert-danger',
                'icon' => '<i class="fa fa-fw fa-times-circle"></i>'
            ], 422);
        }
    }

    public function update(Request $request, $slug)
    {
        try {
            $tag = Tag::withTrashed()->where('slug', $slug)->first();
            if (! $tag) {
                return response()->json(['message' => 'Tag not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']);
            }

            $request->validate([
                "name"          => "required|string",
                "slug"          => ["required" ,"string", Rule::unique('tags')->ignore($tag->id)],
                "description"   => "nullable|string",
            ]);

            if ($request->has('destroy') || $request->has('delete')) {
                return $this->destroy($tag, $request);
            }
            if ($request->has('restore')) {
                $tag->restore();
                return response()->json([
                    'tag' => $tag,
                    'message' => 'Tag restored successfully',
                    'class' => 'alert-info',
                    'icon' => '<i class="fa fa-fw fa-circle-check"></i>'
                ]);
            }

            $data = [
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description,
                "color" => $request->color,
                "active" => $request->has('active'),
            ];
            $image_file = $request->file('cover');
            if ($image_file) {
                $data['cover'] = $this->mediaService->processAsset("blog/tags/$request->slug", $request->slug ?? $tag->slug, $image_file);
            }
            $tag->update($data);
            return response()->json([
                'tag' => $tag,
                'message' => 'Tag updated successfully',
                'class' => 'alert-info',
                'icon' => '<i class="fa fa-fw fa-circle-check"></i>'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'class' => 'alert-danger',
                'icon' => '<i class="fa fa-fw fa-times-circle"></i>'
            ], 422);
        }
    }

    private function destroy($tag, $request)
    {
        try {
            if ($request->has('delete')) {
                $tag->delete();
                return response()->json([
                    'tag' => $tag,
                    'message' => 'Tag deleted successfully',
                    'class' => 'alert-info',
                    'icon' => '<i class="fa fa-fw fa-circle-check"></i>'
                ]);
            }
            \DB::table('post_tag')->where('tag_id', $tag->id)->delete();
            $tag->forceDelete();
            return response()->json([
                'tag' => $tag,
                'message' => 'Tag deleted for good successfully | <a href="/admin/tags">Go back</a>',
                'class' => 'alert-info',
                'icon' => '<i class="fa fa-fw fa-circle-check"></i>'
            ]);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']);
        }
    }
}
