<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\PostCollection;
use App\Http\Resources\Admin\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use \App\Models\Tag;

class PostController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Blog | Posts';
        $posts = Post::orderBy('created_at', 'desc')->get();
        $posts = (new PostCollection($posts))->resolve();

        return view('pages.admin.blog.posts.index', ['data' => $data, 'posts' => $posts]);
    }

    public function getPostsByTag(Request $request, $tag = null)
    {
        if ($tag) {
            $data = new \stdClass();
            $data->posts = Post::where('meta_keywords', 'like', '%' . $tag . '%')->paginate(5);

//            $data->socialLinks = getSocialLinks();
//            $data->headerMenu = getHeaderMenu();

            $data->title = 'Blog | Tags - ' . $tag;

            return view('pages.blog.posts.index', ['data' => $data]);
        } else {
            return redirect('/blog');
        }
    }

    public function create(Request $request)
    {
        $data = new \stdClass();

//        $data->socialLinks = getSocialLinks();
//        $data->headerMenu = getHeaderMenu();

        $data->tags = Tag::select("name", "id")->get();

        $data->title = 'Blog | Create Post';
        return view('pages.admin.blog.posts.create', ['data' => $data]);
    }

    public function store(Request $request)
    {
//         dd($request->all());
        $data = [
            "title" => $request->title,
            "slug" => $request->slug,
            "content" => $request->post_body,
            "excerpt" => $request->excerpt,
            "description" => $request->description,
            "status" => $request->status,
            "featured" => $request->featured,
            'author_id' => \Auth::user()->id,
            'published_at' => $request->status == 1 ? now() : null,
//            'image',
        ];
        $post = Post::create($data);

        if ($request->has('tags')) {
            $post_tag = [];
            foreach ($request->tags as $tag_id) {
                $post_tag[] = [
                    'tag_id' => $tag_id,
                    'post_id' => $post->id,
                    "created_at" => now(), "updated_at" => now()
                ];
            }
            \DB::table('post_tag')->insert($post_tag);
        }
        return back();
    }

    public function edit(Request $request, $slug)
    {
        $data = new \stdClass();
        $data->post = Post::with(['tags', 'author'])->whereSlug($slug)->first();

//        dd($data->post);

//        $data->socialLinks = getSocialLinks();
//        $data->headerMenu = getHeaderMenu();

        $data->tags = Tag::select("name", "id")->get();
        $post_tag_ids = $data->post->tags->pluck('id');

        $data->post->status = $data->post->getDomClass();

        $data->tags = $data->tags->map(function ($tag) use ($post_tag_ids) {
            $tag->linked = $post_tag_ids->contains($tag->id);
            return $tag;
        });

        $data->title = 'Blog | Update Post';
        return view('pages.admin.blog.posts.edit', ['data' => $data]);
    }

    public function update(Request $request, $slug)
    {
//         dd($request->all());
        $data = [
            "title" => $request->title,
            "slug" => $request->slug,
            "content" => $request->post_body,
            "excerpt" => $request->excerpt,
            "description" => $request->description,
            "status" => $request->status,
            "featured" => $request->has('featured'),
            'author_id' => \Auth::user()->id,
            'published_at' => $request->status == 1 ? now() : null,
//            'image',
        ];
        $post = Post::whereSlug($slug)->first();
        $post->update($data);

        if ($request->has('tags')) {
            $post_tag = [];
            foreach ($request->tags as $tag_id) {
                $post_tag[] = [
                    'tag_id' => $tag_id,
                    'post_id' => $post->id,
                    "created_at" => now(), "updated_at" => now()
                ];
            }
            \DB::table('post_tag')->where('post_id', $post->id)->delete();
            \DB::table('post_tag')->insert($post_tag);
        }
        return redirect("/admin/posts/edit/$post->slug");
    }
}
