<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TagCollection;
use App\Http\Resources\Admin\TagResource;
use App\Models\Tag;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    private MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index(Request $request)
    {
        $data = adminPageSetup('Tags | Admin Panel');
        return view('admin.blog.tags.index', ['data' => $data]);
    }

    public function create(Request $request)
    {
        $data = adminPageSetup('New Tag | Admin Panel');
        return view('admin.blog.tags.create', ['data' => $data]);
    }

    public function edit(Request $request, $slug)
    {
        $tag = Tag::withTrashed()->withCount('posts')->whereSlug($slug)->first();
        if ($tag === null) {
            return redirect("/admin/tags")->with(['response' => ['message' => 'Tag not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
        $data = adminPageSetup("Edit | $tag->name | Admin Panel");
        $tag = (object) (new TagResource($tag))->resolve();
        return view('admin.blog.tags.edit', ['data' => $data, 'tag' => $tag]);
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                "name" => "required|string",
                "slug" => "required|unique:tags,slug",
                "description" => "nullable|string",
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
            return redirect("/admin/tags/edit/$tag->slug")->with(['response' => ['message' => 'Tag store successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
        } catch (\Throwable $e) {
            return redirect("/admin/tags/create")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
    }

    public function update(Request $request, $slug)
    {
        try {
            $tag = Tag::withTrashed()->where('slug', $slug)->first();
            if ($tag === null) {
                return redirect("/admin/tags")->with(['response' => ['message' => 'Tag not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
            }

            $request->validate([
                "name" => "nullable|string",
                "slug" => ["nullable" ,"string", Rule::unique('tags')->ignore($tag->id)],
                "description" => "nullable|string",
            ]);

            if ($request->has('destroy') || $request->has('delete')) {
                return $this->destroy($tag, $request);
            } elseif ($request->has('restore')) {
                $tag->restore();
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
            return redirect("/admin/tags/edit/$tag->slug")->with(['response' => ['message' => 'Tag updated successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
        } catch (\Throwable $e) {
            return redirect("/admin/tags/edit/$tag->slug")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
    }

    private function destroy($tag, $request)
    {
        try {
            if ($tag === null) {
                return redirect("/admin/tags")->with(['response' => ['message' => 'Tag not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
            }
            if ($request->has('delete')) {
                $tag->delete();
                return redirect("/admin/tags/edit/$tag->slug")->with(['response' => ['message' => 'Tag deleted successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
            }
            \DB::table('post_tag')->where('tag_id', $tag->id)->delete();
            $tag->forceDelete();
            return redirect("/admin/tags")->with(['response' => ['message' => 'Tag deleted successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
        } catch (\Throwable $e) {
            return redirect("/admin/tags")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
    }
}
