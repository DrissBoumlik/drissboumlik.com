<?php

namespace App\Services;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostWithPaginationCollection;
use App\Models\Post;

class PostService
{
    private const LATEST_FEATURED_POSTS_COUNT = 4;
    private const POSTS_PER_PAGE = 10;


    public function getLatestFeaturedPosts()
    {
        $posts = Post::where('featured', true)->where('status', 2); // Published Posts
        return (new PostCollection($posts->orderBy('updated_at', 'desc')->take(self::LATEST_FEATURED_POSTS_COUNT)->get()))->resolve();
    }


    public function preparePosts($posts)
    {
        if (!\Auth::check()) {
            $posts = $posts->where('status', 2); // Published Posts
        }
        $posts_data = (object) (new PostWithPaginationCollection($posts
            ->orderBy('created_at', 'desc')
            ->paginate(self::POSTS_PER_PAGE)));

        $posts = $posts_data->resolve();

        return [
            'posts_data' => $posts_data,
            'posts' => $posts
        ];

    }

    public function processPostsAssets($post_assets, $post_assets_path)
    {
        if ($post_assets && is_array($post_assets)) {
            foreach ($post_assets as $key => $post_asset) {
                $file_name = "post_asset_$key";
//                $path = "blog/posts/$slug/assets";
                $this->storePostAsset($post_assets_path, $file_name, $post_asset);
            }
        }
    }

    public function processPostCover(&$data, $image_file, $filename, $path)
    {
        if ($image_file) {
//            $file_name = $slug ?? $post_slug;
//            $path = "blog/posts/$slug";
            $data['cover'] = $this->storePostAsset($path, $filename, $image_file);
        }
    }
    public function storePostAsset($path, $file_name, $image_file)
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

    public function compressPostAsset($path, $file_name, $image_file_ext = 'webp')
    {
        $base_path = base_path("storage/app/public");
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
}
