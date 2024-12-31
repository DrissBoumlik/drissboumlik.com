<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

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

}
