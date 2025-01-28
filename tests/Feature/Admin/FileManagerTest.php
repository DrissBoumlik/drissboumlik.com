<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class FileManagerTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }

    public function test_file_manager_index_is_accessible(): void
    {
        $response = $this->get('/admin/file-manager');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.file-manager');
        $response->assertViewHas('data');
    }

    //region fetching file

    public function test_get_files_returns_files_and_directories(): void
    {
        File::shouldReceive('directories')->with('storage')->andReturn(['/storage/dir1', '/storage/dir2']);
        File::shouldReceive('files')->with('storage')->andReturn([]);

        $path = "storage";
        $response = $this->getJson("/api/files/$path");

        $response->assertJsonStructure(['data' => ['path', 'current_path', 'content' => ['directories', 'files']]]);
    }

    public function test_get_files_calculates_previous_path_correctly(): void
    {
        File::shouldReceive('directories')->with('storage/test-path')->andReturn([]);
        File::shouldReceive('files')->with('storage/test-path')->andReturn([]);

        $response = $this->getJson('/api/files/storage/test-path');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'previous_path' => 'storage',
        ]);
    }

    public function test_get_files_processes_files_correctly()
    {
        File::shouldReceive('directories')->with('storage/test-path')->andReturn(['/storage/test-path/dir1', '/storage/test-path/dir2']);

        $mockFile1 = \Mockery::mock();
        $mockFile1->allows('getPathname')->andReturns('storage/test-path/file1.txt');
        $mockFile1->allows('getFilename')->andReturns('file1.txt');

        $mockFile2 = \Mockery::mock();
        $mockFile2->allows('getPathname')->andReturns('storage/test-path/file2.jpg');
        $mockFile2->allows('getFilename')->andReturns('file2.jpg');
        File::shouldReceive('files')->with('storage/test-path')->andReturn([$mockFile1, $mockFile2]);

        File::shouldReceive('mimeType')->with($mockFile1)->andReturn('text/plain');
        File::shouldReceive('mimeType')->with($mockFile2)->andReturn('image/jpeg');

        $response = $this->getJson('/api/files/storage/test-path');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'content' => [
                    'directories' => [
                        ['path' => '/storage/test-path/dir1', 'name' => '/storage/test-path/dir1'],
                        ['path' => '/storage/test-path/dir2', 'name' => '/storage/test-path/dir2'],
                    ],
                    'files' => [
                        ['_pathname' => 'storage/test-path/file1.txt', '_filename' => 'file1.txt', '_mimeType' => 'text/plain'],
                        ['_pathname' => 'storage/test-path/file2.jpg', '_filename' => 'file2.jpg', '_mimeType' => 'image/jpeg'],
                    ],
                ]
            ]
        ]);
    }

    public function test_get_files_handles_no_slash_in_path()
    {
        File::shouldReceive('directories')->with('storage')->andReturn([]);
        File::shouldReceive('files')->with('storage')->andReturn([]);

        $response = $this->getJson('/api/files/storage');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'previous_path' => null,
        ]);
    }

    //endregion

    //region rename file/directory

    public function test_rename_file_successfully(): void
    {
        File::shouldReceive('move')->with('storage/old_name', 'storage/new_name')->once();

        $response = $this->postJson('/api/file/rename', [
            'old_name' => 'old_name',
            'new_name' => 'new_name',
            'path' => 'storage',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Renamed successfully !']);
    }

    public function test_rename_file_throws_exception_for_invalid_names(): void
    {
        $response = $this->postJson('/api/file/rename', [
            'old_name' => '',
            'new_name' => '',
            'path' => 'storage',
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => 'Names should not be empty!!']);
    }

    public function test_rename_file_throws_exception_for_trash_directory(): void
    {
        $response = $this->postJson('/api/file/rename', [
            'old_name' => 'trash',
            'new_name' => 'new_trash',
            'path' => 'storage',
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => 'You cannot rename the Trash !']);
    }

    //endregion

    //region upload file

    public function test_upload_file_successfully(): void
    {
        $file = UploadedFile::fake()->image('test.jpg');
        $response = $this->postJson('/api/file', [
            'path' => 'storage/uploads',
            'files' => [$file],
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Uploaded successfully']);
    }

    public function test_upload_file_throws_exception_for_trash_path(): void
    {
        $file = UploadedFile::fake()->image('test.jpg');
        $response = $this->postJson('/api/file', [
            'path' => 'storage/trash',
            'files' => [$file],
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => "You're uploading to the Trash !"]);
    }

    public function test_delete_file_moves_to_trash(): void
    {
        File::shouldReceive('ensureDirectoryExists')->with('storage/trash/')->once();
        File::shouldReceive('isDirectory')->with('storage/file.txt')->andReturn(false);
        File::shouldReceive('isFile')->with('storage/file.txt')->andReturn(true);
        File::shouldReceive('copy')->with('storage/file.txt', 'storage/trash/file.txt')->once();
        File::shouldReceive('delete')->with('storage/file.txt')->once();

        $path = "storage/file.txt";
        $file = "file.txt";
        $response = $this->deleteJson("/api/path/$path/name/$file");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'File deleted successfully']);
    }

    //endregion

    //region delete file/directory

    public function test_delete_directory_moves_to_trash(): void
    {
        File::shouldReceive('ensureDirectoryExists')->with('storage/trash/')->once();
        File::shouldReceive('isDirectory')->with('storage/directoryToDelete')->andReturn(true);
        File::shouldReceive('copyDirectory')->with('storage/directoryToDelete', 'storage/trash/directoryToDelete')->once();
        File::shouldReceive('deleteDirectory')->with('storage/directoryToDelete')->once();
        File::shouldReceive('isFile')->with('storage/directoryToDelete')->andReturn(false);

        $path = "storage/directoryToDelete";
        $directory = "directoryToDelete";
        $response = $this->deleteJson("/api/path/$path/name/$directory");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Directory deleted successfully']);
    }

    public function test_delete_file_throws_exception_for_trash_path(): void
    {
        $path = "storage/trash";
        $directory = "trash";
        $response = $this->deleteJson("/api/path/$path/name/$directory");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => "You can't delete the Trash !"]);
    }

    //endregion

    //region empty directory

    public function test_empty_directory_successfully(): void
    {
        File::shouldReceive('cleanDirectory')->with('storage/test-dir')->andReturn(true);

        $path = 'storage/test-dir';
        $response = $this->deleteJson("/api/directories/$path");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Trash Emptied successfully']);
    }

    public function test_empty_directory_not_processed_successfully(): void
    {
        File::shouldReceive('cleanDirectory')->with('storage/test-dir')->andReturn(false);

        $path = 'storage/test-dir';
        $response = $this->deleteJson("/api/directories/$path");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => 'Issue with the process or Directory not found']);
    }

    public function test_empty_directory_throws_exception(): void
    {
        File::shouldReceive('cleanDirectory')->with('storage/test-dir')->andThrow(new \Exception('Directory not found'));

        $path = 'storage/test-dir';
        $response = $this->deleteJson("/api/directories/$path");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => 'Directory not found']);
    }

    //endregion

    //region copy/move file/directory

    public function test_copy_file_successfully(): void
    {
        File::shouldReceive('ensureDirectoryExists')->with('storage/destination')->once();
        File::shouldReceive('isDirectory')->with('storage/source')->andReturn(false);
        File::shouldReceive('isFile')->with('storage/source')->andReturn(true);
        File::shouldReceive('copy')->with('storage/source', 'storage/destination/file.txt')->once();

        $response = $this->postJson('/api/file/copy', [
            'src-path' => 'storage/source',
            'dest-path' => 'destination',
            'file_name' => 'file.txt',
            'operation' => 'copy',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'File copied successfully']);
    }

    public function test_move_file_successfully(): void
    {
        File::shouldReceive('ensureDirectoryExists')->with('storage/destination')->once();
        File::shouldReceive('isDirectory')->with('storage/source')->andReturn(false);
        File::shouldReceive('isFile')->with('storage/source')->andReturn(true);
        File::shouldReceive('copy')->with('storage/source', 'storage/destination/file.txt')->once();
        File::shouldReceive('delete')->with('storage/source')->once();

        $response = $this->postJson('/api/file/copy', [
            'src-path' => 'storage/source',
            'dest-path' => 'destination',
            'file_name' => 'file.txt',
            'operation' => 'move',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'File moved successfully']);
    }

    public function test_copy_directory_successfully(): void
    {
        File::shouldReceive('ensureDirectoryExists')->with('storage/destination')->once();
        File::shouldReceive('isDirectory')->with('storage/source')->andReturn(true);
        File::shouldReceive('copyDirectory')->with('storage/source', 'storage/destination/source')->once();

        $response = $this->postJson('/api/file/copy', [
            'src-path' => 'storage/source',
            'dest-path' => 'destination',
            'file_name' => 'source',
            'operation' => 'copy',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Directory copied successfully']);
    }

    public function test_move_directory_successfully(): void
    {
        File::shouldReceive('ensureDirectoryExists')->with('storage/destination')->once();
        File::shouldReceive('isDirectory')->with('storage/source')->andReturn(true);
        File::shouldReceive('copyDirectory')->with('storage/source', 'storage/destination/source')->once();
        File::shouldReceive('deleteDirectory')->with('storage/source')->once();

        $response = $this->postJson('/api/file/copy', [
            'src-path' => 'storage/source',
            'dest-path' => 'destination',
            'file_name' => 'source',
            'operation' => 'move',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Directory moved successfully']);
    }

    public function test_copy_to_same_path_throws_exception(): void
    {
        $response = $this->postJson('/api/file/copy', [
            'src-path' => 'storage/file.txt',
            'dest-path' => '',
            'file_name' => 'file.txt',
            'operation' => 'copy',
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => 'You copy/move to the same path !']);
    }

    public function test_copy_or_move_trash_throws_exception(): void
    {
        $response = $this->postJson('/api/file/copy', [
            'src-path' => 'storage/trash',
            'dest-path' => '',
            'file_name' => 'trash',
            'operation' => 'copy',
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => 'You cannot copy/move the Trash !']);
    }

    //endregion

    //region create directories

    public function test_create_directories_successfully(): void
    {
        File::shouldReceive('makeDirectory')->with('storage/test-dir1')->once();
        File::shouldReceive('makeDirectory')->with('storage/test-dir2')->once();

        $response = $this->postJson('/api/directories', [
            'directoriesNames' => ['test-dir1', 'test-dir2'],
            'currentPath' => '',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Directories created : 2']);
    }

    public function test_create_directories_with_no_names(): void
    {
        $response = $this->postJson('/api/directories', [
            'directoriesNames' => [],
            'currentPath' => 'storage',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Directories created : 0']);
    }

    public function test_create_directories_with_invalid_path(): void
    {
        File::shouldReceive('makeDirectory')->with('invalid-path/test-dir')->andThrow(new \Exception('Invalid path'));

        $response = $this->postJson('/api/directories', [
            'directoriesNames' => ['test-dir'],
            'currentPath' => 'invalid-path',
        ]);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Invalid path']);
    }

    //endregion
}
