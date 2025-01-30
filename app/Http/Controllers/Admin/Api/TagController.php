<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\DataService;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{

    public function __construct(private MediaService $mediaService, private DataService $dataService)
    {

    }
    public function index(Request $request)
    {
        $userSorting = $request->get('user-sorting');
        $tags = Tag::withTrashed()->withCount('posts');
        $tags = $this->dataService->userOrderBy($tags, $userSorting);
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
                'message' => 'Tag stored successfully !',
                'class' => 'alert-info',
                'icon' => '<i class="fa fa-fw fa-circle-check"></i>'
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'class' => 'alert-danger',
                'icon' => '<i class="fa fa-fw fa-times-circle"></i>'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(Request $request, $slug)
    {
        try {
            $tag = Tag::withTrashed()->where('slug', $slug)->first();
            if (! $tag) {
                return response()->json(['message' => 'Tag not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>'], Response::HTTP_NOT_FOUND);
            }

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
                ], Response::HTTP_OK);
            }

            $request->validate([
                "name"          => "required|string",
                "slug"          => ["required" ,"string", Rule::unique('tags')->ignore($tag->id)],
                "description"   => "nullable|string",
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
                $data['cover'] = $this->mediaService->processAsset("blog/tags/$request->slug", $request->slug ?? $tag->slug, $image_file);
            }
            $tag->update($data);
            return response()->json([
                'tag' => $tag,
                'message' => 'Tag updated successfully',
                'class' => 'alert-info',
                'icon' => '<i class="fa fa-fw fa-circle-check"></i>'
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'class' => 'alert-danger',
                'icon' => '<i class="fa fa-fw fa-times-circle"></i>'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    private function destroy($tag, $request)
    {
        if ($request->has('delete')) {
            $tag->delete();
            return response()->json([
                'tag' => $tag,
                'message' => 'Tag deleted successfully',
                'class' => 'alert-info',
                'icon' => '<i class="fa fa-fw fa-circle-check"></i>'
            ], Response::HTTP_OK);
        }
        \DB::table('post_tag')->where('tag_id', $tag->id)->delete();
        $tag->forceDelete();
        return response()->json([
                'tag' => $tag,
                'message' => 'Tag deleted permanently',
                'class' => 'alert-info',
                'icon' => '<i class="fa fa-fw fa-circle-check"></i>'
            ], Response::HTTP_OK);
    }
}
