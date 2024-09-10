<?php

namespace App\Services;


class MediaService
{

    public function processAssets($assets, $assets_path, $asset_name_pattern = "asset", $append_to_assets = true)
    {
        if ($assets && is_array($assets)) {
            if ($append_to_assets) {
                $fetchedAssets = $this->fetchAllAssets("storage/$assets_path");
                $key = count($fetchedAssets["compressed"] ?? []);
            } else {
                $key = 0;
                \File::cleanDirectory("storage/$assets_path");
            }
            foreach ($assets as $asset) {
                $filename = $asset_name_pattern . "_" . $key;
                $this->storeAsset($assets_path, $filename, $asset);
                $this->compresseAsset($assets_path, $filename);
                $key++;
            }
        }
    }

    public function processAsset($path, $filename, $image_file, $compressed_filename = null)
    {
        $originalAssetPath = $this->storeAsset($path, $filename, $image_file);
        $compressedAssetPath = $this->compresseAsset($path, $filename, $compressed_filename);
        return array_merge($originalAssetPath, $compressedAssetPath);
    }

    private function storeAsset($path, $filename, $image_file)
    {
        $image_file_ext = $image_file->getClientOriginalExtension();
        $image_file_path = "$path/$filename.webp";
        $mimeType = \File::mimeType($image_file);
        if (str_contains($mimeType, 'webp')) {
            \Storage::disk('public')->putFileAs($path, $image_file, "$filename.$image_file_ext");
        } else {
            $image_file_webp = \Image::make($image_file)->encode('webp', 100);
            $base_path_assets = base_path("storage/app/public/$path");
            makeDirectory($base_path_assets);
            $image_file_webp->save(base_path("storage/app/public/") . $image_file_path);
        }
        return [ "original" => "storage/$path/$filename.webp" ];
    }

    private function compresseAsset($path, $filename, $compressed_filename = null, $image_file_ext = 'webp')
    {
        if (! $compressed_filename) {
            $compressed_filename = $filename;
        }
        $base_path = base_path("storage/app/public");
        $pathToImage = "$path/$filename.$image_file_ext";
        $base_path_image_optimized = base_path("storage/app/public/$path/compressed");
        makeDirectory($base_path_image_optimized);
        $pathToImageOptimized = "$path/compressed/$compressed_filename.$image_file_ext";
        $image = \Spatie\Image\Image::load("$base_path/$pathToImage");
        $newWidth = $image->getWidth() * 0.2;
        $newHeight = $image->getHeight() * 0.2;
        $image->optimize()
            ->quality(20)
            ->width($newWidth)->height($newHeight)
            ->save("$base_path/$pathToImageOptimized");
        return [ "original" => "storage/$pathToImage", "compressed" => "storage/$pathToImageOptimized" ];
    }

    public function fetchAllAssets($assets_path, $onlyCompressed = true, $onlyOriginals = false)
    {
        $content_assets = [];
        if (!$onlyCompressed && !$onlyOriginals) {
            return $content_assets;
        }
        if ($onlyOriginals) {
            $content_assets["original"] = $this->fetchAssets($assets_path);
        }
        if ($onlyCompressed) {
            $content_assets["compressed"] = $this->fetchAssets("$assets_path/compressed");
        }
        return $content_assets;
    }

    public function fetchAssets($path)
    {
        $assets = [];
        if (\File::isDirectory($path)) {
            $files = \File::files($path);
            if ($files && count($files)) {
                foreach ($files as $file) {
                    $filename = $file->getRelativePathname();
                    $assets[] = (object)[ "link" => "/$path/$filename", "filename" => $filename ];
                }
            }
        }
        return $assets;
    }
}
