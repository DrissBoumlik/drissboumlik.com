<?php

namespace App\Http\Controllers;

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
        $data = [
            "name" => $request->name,
            "slug" => $request->slug,
            "description" => $request->description,
            "color" => $request->color,
        ];
        $tag = Tag::create($data);

        return back();
    }

    public function update(Request $request, $slug)
    {
        $data = [
            "name" => $request->name,
            "slug" => $request->slug,
            "description" => $request->description,
            "color" => $request->color,
        ];
        $tag = Tag::whereSlug($slug)->first();
        $tag->update($data);

        return redirect("/admin/tags/edit/$tag->slug");
    }
}
