<?php

namespace App\Services;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostWithPaginationCollection;
use App\Models\Post;

class MediaService
{

    public function processPostsAssets($post_assets, $post_assets_path, $append_to_post_assets = true)
    {
        if ($post_assets && is_array($post_assets)) {
            if ($append_to_post_assets) {
                $key = count($this->fetchPostContentAssets("storage/$post_assets_path", onlyCompressed: true, onlyOriginals: false));
            } else {
                $key = 0;
                \File::cleanDirectory("storage/$post_assets_path");
            }
            foreach ($post_assets as $post_asset) {
                $file_name = "post_asset_$key";
//                $path = "blog/posts/$slug/assets";
                $this->storePostAsset($post_assets_path, $file_name, $post_asset);
                $key++;
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

    public function fetchPostContentAssets($assets_path, $onlyCompressed = true, $onlyOriginals = false)
    {
        $content_assets = [];
        if (!$onlyCompressed && !$onlyOriginals) {
            return $content_assets;
        }
        if (\File::isDirectory($assets_path)) {
            $files = \File::files($assets_path);
            if ($files && count($files)) {
                foreach ($files as $file) {
                    $filename = $file->getRelativePathname();
                    $isCompressedFile = str_contains($filename, 'compressed');
                    if (($onlyCompressed && $isCompressedFile)
                        || ($onlyOriginals && !$isCompressedFile)) {
                        $content_assets[] = (object)["link" => "/$assets_path/$filename", "filename" => $filename];
                    }
                }
            }
        }
        return $content_assets;
    }
}
