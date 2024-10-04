<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostResource;
use App\Models\Post;
use App\Services\MediaService;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    private $perPage = 10;
    private PostService $postService;
    private MediaService $mediaService;

    public function __construct(PostService $postService, MediaService $mediaService)
    {
        $this->postService = $postService;
        $this->mediaService = $mediaService;
    }

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

    public function store(Request $request)
    {
        try {
            $request->validate([
                "title"         => "required|string",
                "slug"          => "required|unique:posts,slug",
                "post_excerpt"  => "required|string",
                "description"   => "required|string",
                "tags.*"        => [
                    'integer',
                    'exists:tags,id',
                ],
                "views" => "required|integer|min:0",
                "published_at"  => "required|date",
                "post_content"  => "required|string",
            ]);

            $data = [
                "title" => $request->get('title'),
                "slug" => $request->get('slug'),
                "content" => $request->get('post_content'),
                "excerpt" => $request->get('excerpt'),
                "description" => $request->get('description'),
                "published" => $request->has('published'),
                "featured" => $request->has('featured'),
                "active" => $request->has('active'),
                'author_id' => \Auth::user()->id,
                'published_at' => ($request->has('published') ? ($request->get('published_at') ?? now()) : null),
            ];
            $image_file = $request->file('cover');
            if ($image_file) {
                $data['cover'] = $this->mediaService->processAsset("blog/posts/$request->slug", $request->slug, $image_file);
            }
            $postAssets = $request->file('post-assets');
            if ($postAssets) {
                $this->mediaService->processAssets($postAssets, "blog/posts/$request->slug/assets", "post_asset", false);
            }
            $post = Post::create($data);
            $tags = $request->get('tags');
            if ($tags && is_array($tags)) {
                $post_tag = [];
                foreach ($tags as $tag_id) {
                    $post_tag[] = [
                        'tag_id' => $tag_id,
                        'post_id' => $post->id,
                        "created_at" => now(), "updated_at" => now()
                    ];
                }
                \DB::table('post_tag')->insert($post_tag);
            }
            return redirect("/admin/posts/edit/$post->slug")->with(['response' => ['message' => 'Post stored successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
        } catch (\Throwable $e) {
            return redirect("/admin/posts/create")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
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

    public function update(Request $request, $slug)
    {
        try {
            $post = Post::withTrashed()->where('slug', $slug)->first();
            if (! $post) {
                return redirect("/admin/posts")->with(['response' => ['message' => 'Post not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
            }

            if ($request->has('destroy') || $request->has('delete')) {
                return $this->destroy($post, $request);
            }
            if ($request->has('restore')) {
                $post->restore();
            }

            $request->validate([
                "title"         => "required|string",
                "slug"          => ["required", "string", Rule::unique('posts')->ignore($post->id)],
                "post_excerpt"  => "required|string",
                "description"   => "required|string",
                "tags.*"        => [
                    'integer',
                    'exists:tags,id',
                ],
                "views"         => "required|integer|min:0",
                "published_at"  => "required|date",
                "post_content"  => "required|string",
            ]);

            $data = [
                "title" => $request->get('title'),
                "slug" => $request->get('slug'),
                "content" => $request->get('post_content'),
                "excerpt" => $request->get('post_excerpt'),
                "description" => $request->get('description'),
                "published" => $request->has('published'),
                "featured" => $request->has('featured'),
                'active' => $request->has('active'),
                'author_id' => \Auth::user()->id,
                'published_at' => ($request->has('published') ? ($request->get('published_at') ?? now()) : null),
                'views' => $request->views ?? $post->views
            ];
            $image_file = $request->file('cover');
            if ($image_file) {
                $data['cover'] = $this->mediaService->processAsset("blog/posts/$request->slug",
                                                        $request->slug ?? $post->slug, $image_file);
            }
            $postAssets = $request->file('post-assets');
            if ($postAssets) {
                $this->mediaService->processAssets($postAssets, "blog/posts/$request->slug/assets",
                                "post_asset", $request->has('append-to-post-assets'));
            }
            $post->update($data);

            \DB::table('post_tag')->where('post_id', $post->id)->delete();
            $tags = $request->get('tags');
            if ($tags && is_array($tags)) {
                $post_tag = [];
                foreach ($tags as $tag_id) {
                    $post_tag[] = [
                        'tag_id' => $tag_id,
                        'post_id' => $post->id,
                        "created_at" => now(), "updated_at" => now()
                    ];
                }
                \DB::table('post_tag')->insert($post_tag);
            }
            return redirect("/admin/posts/edit/$post->slug")->with(['response' => ['message' => 'Post updated successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
        } catch (\Throwable $e) {
            return redirect("/admin/posts/edit/$post->slug")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
    }

    private function destroy($post, $request)
    {
        try {
            if ($request->has('delete')) {
                $post->delete();
                return redirect("/admin/posts/edit/$post->slug")->with(['response' => ['message' => 'Post deleted successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
            }
            \DB::table('post_tag')->where('post_id', $post->id)->delete();
            $post->forceDelete();
            return redirect("/admin/posts")->with(['response' => ['message' => 'Post deleted for good successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
        } catch (\Throwable $e) {
            return redirect("/admin/posts")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
       }
    }


    public function api_store(Request $request)
    {
        return ['data' => $request->all()];
    }
}
