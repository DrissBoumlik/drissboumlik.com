<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TagCollection;
use App\Http\Resources\Admin\TagResource;
use App\Models\Tag;
use App\Services\MediaService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Tags | Admin Panel';
        return view('admin.blog.tags.index', ['data' => $data]);
    }

    public function create(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'New Tag | Admin Panel';
        return view('admin.blog.tags.create', ['data' => $data]);
    }

    public function edit(Request $request, $slug)
    {
        $data = new \stdClass();
        $tag = Tag::withTrashed()->withCount('posts')->whereSlug($slug)->first();
        if ($tag === null) {
            return redirect("/admin/tags")->with(['response' => ['message' => 'Tag not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
        $data->title = "Edit | $tag->name | Admin Panel";
        $tag = (object) (new TagResource($tag))->resolve();
        return view('admin.blog.tags.edit', ['data' => $data, 'tag' => $tag]);
    }

    public function store(Request $request)
    {
        try {
            $data = [
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description,
                "color" => $request->color,
                "active" => $request->has('active'),
            ];
            $image_file = $request->file('cover');
            $this->mediaService->processPostCover($data, $image_file, $request->slug, "blog/tags/$request->slug");
            $tag = Tag::create($data);
            return redirect("/admin/tags/edit/$tag->slug")->with(['response' => ['message' => 'Tag store successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
        } catch (\Throwable $e) {
            return redirect("/admin/tags")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
    }

    public function update(Request $request, $slug)
    {
        try {
            $tag = Tag::withTrashed()->where('slug', $slug)->first();
            if ($tag === null) {
                return redirect("/admin/tags")->with(['response' => ['message' => 'Tag not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
            }

            if ($request->has('destroy')) {
                return $this->destroy($tag);
            }

            $data = [
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description,
                "color" => $request->color,
                "active" => $request->has('active'),
            ];
            $image_file = $request->file('cover');
            $this->mediaService->processPostCover($data, $image_file, $request->slug ?? $tag->slug, "blog/tags/$request->slug");
            $tag->update($data);
            if ($request->has('active')) {
                $tag->restore();
            } else {
                $tag->delete();
            }
            return redirect("/admin/tags/edit/$tag->slug")->with(['response' => ['message' => 'Tag updated successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
        } catch (\Throwable $e) {
            return redirect("/admin/tags/edit/$tag->slug")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
    }

    private function destroy($tag)
    {
        try {
            if ($tag === null) {
                return redirect("/admin/tags")->with(['response' => ['message' => 'Tag not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
            }
            \DB::table('post_tag')->where('tag_id', $tag->id)->delete();
            $deleted = $tag->forceDelete();
            return redirect("/admin/tags")->with(['response' => ['message' => 'Tag deleted successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
        } catch (\Throwable $e) {
            return redirect("/admin/tags")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
    }
}
