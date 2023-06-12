<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Blog | Tags';
        $tags = Tag::withCount('posts')->orderBy('created_at', 'desc')->get();
        return view('pages.admin.blog.tags.index', ['data' => $data, 'tags' => $tags]);
    }

    public function create(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Blog | Create Tag';
        return view('pages.admin.blog.tags.create', ['data' => $data]);
    }

    public function edit(Request $request, $slug)
    {
        $data = new \stdClass();
        $data->tag = Tag::whereSlug($slug)->first();
        $data->title = 'Blog | Edit Tag';
        return view('pages.admin.blog.tags.edit', ['data' => $data]);
    }

    public function store(Request $request)
    {

        try {
            $data = [
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description,
                "color" => $request->color,
            ];
            $tag = Tag::create($data);
            return redirect("/admin/posts")->with(['response' => ['message' => 'Tag store successfully', 'class' => 'alert-info']]);
        } catch (\Throwable $e) {
            return redirect("/admin/posts")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger']]);
        }
    }

    public function update(Request $request, $slug)
    {
        try {
            if ($request->has('delete')) {
                return $this->destroy($slug);
            }
            $data = [
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description,
                "color" => $request->color,
            ];
            $tag = Tag::whereSlug($slug)->first();
            $tag->update($data);
            return redirect("/admin/tags/edit/$tag->slug")->with(['response' => ['message' => 'Tag updated successfully', 'class' => 'alert-info']]);
        } catch (\Throwable $e) {
            return redirect("/admin/tags/edit/$tag->slug")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger']]);
        }
    }

    public function destroy($slug)
    {
        try {
            $tag = Tag::whereSlug($slug)->first();
            if ($tag) {
                //            \DB::table('post_tag')->where('tag_id', $tag->id)->delete();
                //            $tag->delete();
                return redirect("/admin/tags")->with(['message' => 'Tag deleted successfully']);
            }
            return redirect("/admin/tags")->with(['response' => ['message' => 'Tag not found', 'class' => 'alert-warning']]);

        } catch (\Throwable $e) {
            return redirect("/admin/tags")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger']]);
        }
    }
}
