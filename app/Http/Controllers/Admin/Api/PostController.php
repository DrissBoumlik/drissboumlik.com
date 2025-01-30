<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\DataService;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{

    public function __construct(private MediaService $mediaService, private DataService $dataService)
    {

    }

    public function index(Request $request)
    {
        $posts = Post::withTrashed()->withCount('tags');
        $userSorting = $request->get('user-sorting');
        $posts = $this->dataService->userOrderBy($posts, $userSorting);
        return DataTables::eloquent($posts)->make(true);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                "title"         => "required|string",
                "slug"          => "required|unique:posts,slug",
                "excerpt"       => "required|string",
                "description"   => "required|string",
                "tags.*"        => [
                    'integer',
                    'exists:tags,id',
                ],
                "views"         => "nullable|integer|min:0",
                "published_at"  => "nullable|date",
                "content"       => "required|string",
            ]);

            $data = [
                "title"         => $request->get('title'),
                "slug"          => $request->get('slug'),
                "content"       => $request->get('content'),
                "excerpt"       => $request->get('excerpt'),
                "description"   => $request->get('description'),
                "published"     => $request->has('published'),
                "featured"      => $request->has('featured'),
                "active"        => $request->has('active'),
                "author_id"     => \Auth::user()->id,
                "published_at"  => ($request->has('published') ? ($request->get('published_at') ?? now()) : null),
            ];
            $image_file = $request->file('cover');
            if ($image_file) {
                $data['cover'] = $this->mediaService->processAsset("blog/posts/$request->slug", $request->slug, $image_file);
            }
            $postAssets = $request->file('assets');
            if ($postAssets) {
                $this->mediaService->processAssets($postAssets, "blog/posts/$request->slug/assets", "post_asset", false);
            }
            $post = Post::create($data);
            $tags = $request->get('tags');
            if ($tags && is_array($tags)) {
                $post_tag = [];
                foreach ($tags as $tag_id) {
                    $post_tag[] = [
                        'tag_id'        => $tag_id,
                        'post_id'       => $post->id,
                        "created_at"    => now(), "updated_at" => now()
                    ];
                }
                \DB::table('post_tag')->insert($post_tag);
            }

            $redirect_link = "/admin/posts/edit/$post->slug";

            return response()->json([
                'post'      => $post,
                'message'   => "Post stored successfully | <a href='$redirect_link'><i class='fa fa-fw fa-external-link'></i> Edit</a>",
                'class'     => 'alert-info',
                'icon'      => '<i class="fa fa-fw fa-circle-check"></i>'], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'message'   => $e->getMessage(),
                'class'     => 'alert-danger',
                'icon'      => '<i class="fa fa-fw fa-times-circle"></i>'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    public function update(Request $request, $slug)
    {
        try {
            $post = Post::withTrashed()->where('slug', $slug)->first();
            if (! $post) {
                return response()->json(['message' => 'Post not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>'], Response::HTTP_NOT_FOUND);
            }

            if ($request->has('destroy') || $request->has('delete')) {
                return $this->destroy($post, $request);
            }
            if ($request->has('restore')) {
                $post->restore();
                return response()->json([
                    'post'      => $post,
                    'message'   => 'Post restored successfully',
                    'class'     => 'alert-info',
                    'icon'      => '<i class="fa fa-fw fa-circle-check"></i>'
                ], Response::HTTP_OK);
            }

            $request->validate([
                "title"         => "required|string",
                "slug"          => ["required", "string", Rule::unique('posts')->ignore($post->id)],
                "excerpt"       => "nullable|string",
                "description"   => "nullable|string",
                "tags.*"        => [
                    'integer',
                    'exists:tags,id',
                ],
                "views"         => "nullable|integer|min:0",
                "published_at"  => "nullable|date",
                "content"       => "required|string",
            ]);

            $data = [
                "title"         => $request->get('title'),
                "slug"          => $request->get('slug'),
                "content"       => $request->get('content'),
                "excerpt"       => $request->get('excerpt'),
                "description"   => $request->get('description'),
                "published"     => $request->has('published'),
                "featured"      => $request->has('featured'),
                'active'        => $request->has('active'),
                'author_id'     => \Auth::user()->id,
                'published_at'  => ($request->has('published') ? ($request->get('published_at') ?? now()) : null),
                'views'         => $request->views ?? $post->views
            ];
            $image_file = $request->file('cover');
            if ($image_file) {
                $data['cover'] = $this->mediaService->processAsset("blog/posts/$request->slug",
                    $request->slug ?? $post->slug, $image_file);
            }
            $postAssets = $request->file('assets');
            if ($postAssets) {
                $this->mediaService->processAssets($postAssets, "blog/posts/$request->slug/assets",
                    "post_asset", $request->has('append-to-assets'));
            }
            $post->update($data);

            \DB::table('post_tag')->where('post_id', $post->id)->delete();
            $tags = $request->get('tags');
            if ($tags && is_array($tags)) {
                $post_tag = [];
                foreach ($tags as $tag_id) {
                    $post_tag[] = [
                        'tag_id'        => $tag_id,
                        'post_id'       => $post->id,
                        "created_at"    => now(), "updated_at" => now()
                    ];
                }
                \DB::table('post_tag')->insert($post_tag);
            }
            return response()->json([
                'post'      => $post,
                'message'   => 'Post updated successfully',
                'class'     => 'alert-info',
                'icon'      => '<i class="fa fa-fw fa-circle-check"></i>'
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'message'   => $e->getMessage(),
                'class'     => 'alert-danger',
                'icon'      => '<i class="fa fa-fw fa-times-circle"></i>'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    private function destroy($post, $request)
    {
        if ($request->has('delete')) {
            $post->delete();
            return response()->json([
                'post'      => $post,
                'message'   => 'Post deleted successfully',
                'class'     => 'alert-info',
                'icon'      => '<i class="fa fa-fw fa-circle-check"></i>'
            ], Response::HTTP_OK);
        }
        \DB::table('post_tag')->where('post_id', $post->id)->delete();
        $post->forceDelete();
        return response()->json([
                'post'      => $post,
                'message'   => 'Post deleted permanently | <a href="/admin/posts">Go back</a>',
                'class'     => 'alert-info',
                'icon'      => '<i class="fa fa-fw fa-circle-check"></i>'
            ], Response::HTTP_OK);
    }

    public function getPostAssets(Request $request, $slug)
    {
        $assets_path = "storage/blog/posts/$slug/assets";
        $post_assets = $this->mediaService->fetchAllAssets($assets_path);
        return ['post_assets' => $post_assets];
    }
}
