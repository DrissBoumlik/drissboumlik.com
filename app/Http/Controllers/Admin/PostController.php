<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostCollection;
use App\Http\Resources\Admin\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Tag;

class PostController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Posts | Admin Panel';

        return view('admin.blog.posts.index', ['data' => $data]);
    }

    public function create(Request $request)
    {
        $data = new \stdClass();
        $data->tags = Tag::select("name", "id")->get();

        $data->title = 'New Post | Admin Panel';
        $data->postsStatus = getPostStatus();
        return view('admin.blog.posts.create', ['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            $data = [
                "title" => $request->title,
                "slug" => $request->slug,
                "content" => $request->post_content,
                "excerpt" => $request->excerpt,
                "description" => $request->description,
                "status" => $request->status,
                "featured" => $request->featured,
                'author_id' => \Auth::user()->id,
                'published_at' => ($request->status === "2" ? ($request->published_at ?? now()) : null),
            ];
            $image_file = $request->file('cover');
            $this->processPostCover($data, $image_file, $request->slug);
            $this->processPostsAssets($request->file('post-assets'), $request->slug);
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
            return redirect("/admin/posts/edit/$post->slug")->with(['response' => ['message' => 'Post store successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
        } catch (\Throwable $e) {
            return redirect("/admin/posts")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
    }

    public function edit(Request $request, $slug)
    {
        $data = new \stdClass();
        $post = Post::withTrashed()->with(['tags', 'author'])->whereSlug($slug)->first();
        $post = (object) (new PostResource($post))->resolve();

        $data->tags = Tag::select("name", "id")->get();
        $post_tag_ids = $post->tags->pluck('id');

//        $post->status = $post->getDomClass();
        if ($post->cover) {
            $cover_path = explode("/$post->slug.webp", $post->cover)[0] . "/assets";
            if (\File::isDirectory($cover_path)) {
                $files = \File::files($cover_path);
                if ($files && count($files)) {
                    $post->content_assets = [];
                    foreach ($files as $file) {
                        $filename = $file->getRelativePathname();
                        if (str_contains($filename, 'compressed')) {
                            $post->content_assets[] = (object)["link" => "/$cover_path/$filename", "filename" => $filename];
                        }
                    }
                }
            }
        }

        $data->tags = $data->tags->map(function ($tag) use ($post_tag_ids) {
            $tag->linked = $post_tag_ids->contains($tag->id);
            return $tag;
        });

        $data->title = "Edit | $post->title | Admin Panel";
        $data->postsStatus = getPostStatus();
        return view('admin.blog.posts.edit', ['data' => $data, 'post' => $post]);
    }

    public function update(Request $request, $slug)
    {
        try {
            $post = Post::withTrashed()->where('slug', $slug)->first();

            if ($request->has('destroy')) {
                return $this->destroy($post);
            }

            $data = [
                "title" => $request->title,
                "slug" => $request->slug,
                "content" => $request->post_content,
                "excerpt" => $request->post_excerpt,
                "description" => $request->description,
                "status" => $request->status,
                "featured" => $request->has('featured'),
                'author_id' => \Auth::user()->id,
                'published_at' => ($request->status === "2" ? ($request->published_at ?? now()) : null),
                'views' => $request->views ?? $post->views
            ];
            $image_file = $request->file('cover');
            $this->processPostCover($data, $image_file, $request->slug, $post->slug);
            $this->processPostsAssets($request->file('post-assets'), $request->slug);
            $post->update($data);

            if ($request->has('active')) {
                $post->restore();
            } else {
                $post->delete();
            }
            \DB::table('post_tag')->where('post_id', $post->id)->delete();
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
            return redirect("/admin/posts/edit/$post->slug")->with(['response' => ['message' => 'Post updated successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
        } catch (\Throwable $e) {
            return redirect("/admin/posts/edit/$post->slug")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
        }
    }

    private function destroy($post)
    {
        try {
            if ($post) {
                \DB::table('post_tag')->where('post_id', $post->id)->delete();
                $deleted = $post->forceDelete();
                return redirect("/admin/posts")->with(['response' => ['message' => 'Post deleted successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']]);
            } else {
                return redirect("/admin/posts")->with(['response' => ['message' => 'Post not found', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
            }
        } catch (\Throwable $e) {
            return redirect("/admin/posts")->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']]);
       }
    }

    private function processPostsAssets($post_assets, $slug)
    {
        if ($post_assets && is_array($post_assets)) {
            foreach ($post_assets as $key => $post_asset) {
                $file_name = "post_asset_$key";
                $path = "blog/posts/$slug/assets";
                $this->storePostAsset($path, $file_name, $post_asset);
            }
        }
    }

    private function processPostCover(&$data, $image_file, $slug, $post_slug = null)
    {
        if ($image_file) {
            $file_name = $slug ?? $post_slug;
            $path = "blog/posts/$slug";
            $data['cover'] = $this->storePostAsset($path, $file_name, $image_file);
        }
    }
    private function storePostAsset($path, $file_name, $image_file)
    {
        $image_file_ext = $image_file->getClientOriginalExtension();
        $image_file_path = "$path/$file_name.webp";
        $mimeType = \File::mimeType($image_file);
        if (str_contains($mimeType, 'webp')) {
            \Storage::disk('public')->putFileAs($path, $image_file, "$file_name.$image_file_ext");
        } else {
            $image_file_webp = \Image::make($image_file)->encode('webp', 100);
            $base_path = base_path();
            $base_path_assets = base_path("storage/app/public/$path");
            if (!\File::isDirectory($base_path_assets)) {
                \File::makeDirectory($base_path_assets);
            }
            $image_file_webp->save(base_path("storage/app/public/") . $image_file_path);
        }
        $this->compressPostAsset($path, $file_name, 'webp');
        return "storage/$image_file_path";
    }

    private function compressPostAsset($path, $file_name, $image_file_ext = 'webp')
    {
        $base_path = base_path() . '/public/storage';
        $pathToImage = "$base_path/$path/$file_name.$image_file_ext";
        $pathToOptimizedImage = "$base_path/$path/$file_name--compressed.$image_file_ext";
        $image = \Spatie\Image\Image::load($pathToImage);
        $newWidth = $image->getWidth() * 0.2;
        $newHeight = $image->getHeight() * 0.2;
        $image->optimize()
            ->quality(20)
            ->width($newWidth)->height($newHeight)
            ->save($pathToOptimizedImage);
    }

    public function api_store(Request $request)
    {
        return ['data' => $request->all()];
    }
}
