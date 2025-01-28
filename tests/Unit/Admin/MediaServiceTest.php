<?php

namespace Tests\Unit\Admin;

use App\Services\MediaService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\SplFileInfo;
use Tests\TestCase;

class MediaServiceTest extends TestCase
{
    protected MediaService $mediaService;

    public function setUp(): void
    {
        parent::setUp();

        $this->mediaService = new MediaService();
    }

    public function test_processes_multiple_assets_and_stores_them()
    {
        // Arrange
        $assets = [
            UploadedFile::fake()->image('asset1.jpg'),
            UploadedFile::fake()->image('asset2.png'),
        ];
        $assetsPath = 'test_assets';
        $assetNamePattern = 'test_asset';

        // Act
        $this->mediaService->processAssets($assets, $assetsPath, $assetNamePattern);

        // Assert
        Storage::disk('public')->assertExists("$assetsPath/test_asset_0.webp");
        Storage::disk('public')->assertExists("$assetsPath/test_asset_1.webp");
    }

    public function test_processes_a_single_asset_and_returns_paths()
    {
        // Arrange
        $asset = UploadedFile::fake()->image('test.jpg');
        $path = 'test_assets';
        $filename = 'test_file';

        // Act
        $result = $this->mediaService->processAsset($path, $filename, $asset);

        // Assert
        $this->assertArrayHasKey('original', $result);
        $this->assertArrayHasKey('compressed', $result);
        Storage::disk('public')->assertExists("$path/$filename.webp");
    }

    public function test_process_assets_without_append_mode()
    {
        // Create existing assets to test append mode
        Storage::disk('public')->put('test-assets/asset_0.webp', 'fake content');
        Storage::disk('public')->put('test-assets/compressed/asset_0.webp', 'fake compressed');

        $testFiles = [
            UploadedFile::fake()->image('test0.jpg'),
            UploadedFile::fake()->image('test1.webp')
        ];

        $this->mediaService->processAssets($testFiles, 'test-assets', 'asset',false);

        // Verify files were appended, starting from index 1
        Storage::disk('public')->assertExists('test-assets/asset_0.webp');
        Storage::disk('public')->assertExists('test-assets/asset_1.webp');
        Storage::disk('public')->assertExists('test-assets/compressed/asset_0.webp');
        Storage::disk('public')->assertExists('test-assets/compressed/asset_1.webp');
    }

    public function test_fetch_assets_with_valid_directory()
    {
        // Mock the SplFileInfo objects
        $file1 = new SplFileInfo('path/to/assets/file1.jpg', 'assets', 'file1.jpg');
        $file2 = new SplFileInfo('path/to/assets/file2.png', 'assets', 'file2.png');

        // Mock the File facade
        File::shouldReceive('isDirectory')->once()->with('path/to/assets')->andReturn(true);
        File::shouldReceive('files')->once()->with('path/to/assets')->andReturn([$file1, $file2]);

        $result = $this->mediaService->fetchAssets('path/to/assets');

        $this->assertCount(2, $result);
        $this->assertEquals('/path/to/assets/file1.jpg', $result[0]->link);
        $this->assertEquals('file1.jpg', $result[0]->filename);
        $this->assertEquals('/path/to/assets/file2.png', $result[1]->link);
        $this->assertEquals('file2.png', $result[1]->filename);
    }

    public function test_fetch_all_assets_with_both_compressed_and_originals()
    {
        // Mock the SplFileInfo objects
        $originalFile = new SplFileInfo('path/to/assets/original1.jpg', 'assets', 'original1.jpg');
        $compressedFile = new SplFileInfo('path/to/assets/compressed/compressed1.jpg', 'compressed', 'compressed1.jpg');

        // Mock the File facade
        File::shouldReceive('isDirectory')->once()->with('path/to/assets')->andReturn(true);
        File::shouldReceive('files')->once()->with('path/to/assets')->andReturn([$originalFile]);
        File::shouldReceive('isDirectory')->once()->with('path/to/assets/compressed')->andReturn(true);
        File::shouldReceive('files')->once()->with('path/to/assets/compressed')->andReturn([$compressedFile]);

        $result = $this->mediaService->fetchAllAssets('path/to/assets', true, true);

        $this->assertArrayHasKey('original', $result);
        $this->assertArrayHasKey('compressed', $result);
        $this->assertCount(1, $result['original']);
        $this->assertCount(1, $result['compressed']);
        $this->assertEquals('/path/to/assets/original1.jpg', $result['original'][0]->link);
        $this->assertEquals('original1.jpg', $result['original'][0]->filename);
        $this->assertEquals('/path/to/assets/compressed/compressed1.jpg', $result['compressed'][0]->link);
        $this->assertEquals('compressed1.jpg', $result['compressed'][0]->filename);
    }


}
