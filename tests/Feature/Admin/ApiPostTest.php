<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiPostTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);

        Storage::fake('local');
    }

    public function test_index_posts_datatable()
    {
        Post::factory()->count(5)->create();

        $response = $this->postJson('/api/posts/list', [ 'first_time' => true ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'slug', 'tags_count']
                ]
            ])
            ->assertJsonCount(5, 'data');
    }

    public function test_store_post_successfully()
    {
        $coverFile = UploadedFile::fake()->image('cover.jpg');
        $assetFiles = [
            UploadedFile::fake()->image('asset1.jpg'),
            UploadedFile::fake()->image('asset2.jpg')
        ];

        $tags = Tag::factory()->count(3)->create();

        $postData = [
            'title' => 'Test Post',
            'slug' => 'test-post',
            'excerpt' => 'Test excerpt',
            'description' => 'Test description',
            'content' => 'Test content',
            'tags' => $tags->pluck('id')->toArray(),
            'published' => 'on',
            'featured' => 'on',
            'cover' => $coverFile,
            'assets' => $assetFiles
        ];

        $response = $this->postJson('/api/posts', $postData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'post', 'message', 'class', 'icon'
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'slug' => 'test-post',
            'published' => true,
            'featured' => true
        ]);

        $this->assertDatabaseCount('post_tag', count($tags));
    }

    public function test_store_post_validation_fails()
    {
        $invalidData = [
            'slug' => null,
        ];

        $response = $this->postJson("/api/posts", $invalidData);

        $response->assertStatus(422)
            ->assertJsonStructure(['message']);
    }

    public function test_update_post_successfully()
    {
        $post = Post::factory()->create();
        $coverFile = UploadedFile::fake()->image('updated-cover.jpg');
        $assetFiles = [
            UploadedFile::fake()->image('updated-asset1.jpg')
        ];

        $tags = Tag::factory()->count(3)->create();

        $updateData = [
            'title' => 'Updated Post',
            'slug' => 'updated-post',
            'excerpt' => 'Updated excerpt',
            'description' => 'Updated description',
            'content' => 'Updated content',
            'tags' => $tags->pluck('id')->toArray(),
            'published' => 'on',
            'featured' => 'on',
            'cover' => $coverFile,
            'assets' => $assetFiles,
            'append-to-assets' => true
        ];

        $response = $this->putJson("/api/posts/{$post->slug}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'post', 'message', 'class', 'icon'
            ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post',
            'slug' => 'updated-post',
            'published' => true,
            'featured' => true
        ]);

        $this->assertDatabaseCount('post_tag', count($tags));
    }

    public function test_update_post_validation_fails()
    {
        $existingPost = Post::factory()->create();

        $invalidData = [
            'slug' => null,
        ];

        $response = $this->putJson("/api/posts/$existingPost->slug", $invalidData);

        $response->assertStatus(422)
            ->assertJsonStructure(['message']);
    }

    public function test_post_not_found()
    {
        $response = $this->putJson("/api/posts/non-existing-slug");

        $response->assertStatus(404)
            ->assertJson(['message' => 'Post not found']);
    }

    public function test_soft_delete_post()
    {
        $post = Post::factory()->create();

        $response = $this->putJson("/api/posts/{$post->slug}", ['delete' => true]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'post', 'message', 'class', 'icon'
            ]);

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_force_delete_post()
    {
        $post = Post::factory()->create();

        $response = $this->putJson("/api/posts/{$post->slug}", ['destroy' => true]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'post', 'message', 'class', 'icon'
            ]);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_restore_post()
    {
        $post = Post::factory()->create();
        $post->delete();

        $response = $this->putJson("/api/posts/{$post->slug}", ['restore' => true]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'post', 'message', 'class', 'icon'
            ]);

        $this->assertNull($post->fresh()->deleted_at);
    }

    public function test_get_post_assets()
    {
        $post = Post::factory()->create();
        $slug = $post->slug;

        // Simulate asset files
        Storage::fake('local');
        Storage::put("blog/posts/{$slug}/assets/test-asset.jpg", 'dummy content');

        $response = $this->getJson("/api/posts/{$slug}/assets");

        $response->assertStatus(200)
            ->assertJsonStructure(['post_assets']);
    }
}
