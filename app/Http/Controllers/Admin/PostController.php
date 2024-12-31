<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Tag;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $data = adminPageSetup('Posts | Admin Panel');

        return view('admin.blog.posts.index', ['data' => $data]);
    }

    public function create(Request $request)
    {
        $data = adminPageSetup('New Post | Admin Panel');
        $data->tags = Tag::select("name", "id")->get();

        return view('admin.blog.posts.create', ['data' => $data]);
    }

    public function edit(Request $request, $slug)
    {
        $post = Post::withTrashed()->with(['tags', 'author'])->whereSlug($slug)->first();
        if ($post === null) {
            return redirect("/admin/posts")->with(['response' => ['message' => 'Post not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
        $post = (object) (new PostResource($post))->resolve();
        $data = adminPageSetup("Edit | $post->title | Admin Panel");
        $data->tags = Tag::select("name", "id")->get();
        $post_tag_ids = $post->tags->pluck('id');

        if ($post->cover) {
            $assets_path = "storage/blog/posts/$post->slug/assets";
        }

        $data->tags = $data->tags->map(function ($tag) use ($post_tag_ids) {
            $tag->linked = $post_tag_ids->contains($tag->id);
            return $tag;
        });

        return view('admin.blog.posts.edit', ['data' => $data, 'post' => $post]);
    }


}
