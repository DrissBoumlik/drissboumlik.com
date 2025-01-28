<?php

namespace Tests\Feature\Admin;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiTagTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);

        Storage::fake('local');
    }

    public function test_index_tags_datatables()
    {
        Tag::factory()->count(5)->create();

        $response = $this->postJson('/api/tags/list', [ 'first_time' => true ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'slug', 'posts_count']
                ]
            ]);
    }

    public function test_store_creates_new_tag_with_valid_data()
    {
        $coverFile = UploadedFile::fake()->image('cover.jpg');

        $tagData = [
            'name' => 'Test Tag',
            'slug' => 'test-tag',
            'description' => 'Test description',
            'color' => '#FF0000',
            'active' => true,
            'cover' => $coverFile
        ];

        $response =$this->postJson('api/tags', $tagData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message', 'tag'
            ]);

        $this->assertDatabaseHas('tags', [
            'name' => 'Test Tag',
            'slug' => 'test-tag'
        ]);
    }

    public function test_store_tag_validation_fails()
    {
        $invalidData = [
            'slug' => null,
        ];

        $response = $this->postJson("/api/tags", $invalidData);

        $response->assertStatus(422)
            ->assertJsonStructure(['message']);
    }

    public function test_update_modifies_existing_tag()
    {
        $tag = Tag::factory()->create([
            'name' => 'Original Name',
            'slug' => 'original-slug'
        ]);
        $coverFile = UploadedFile::fake()->image('updated-cover.jpg');


        $updateData = [
            'name' => 'Updated Name',
            'slug' => 'updated-slug',
            'description' => 'Updated description',
            'cover' => $coverFile,
            'active' => true
        ];

        $response = $this->putJson("api/tags/{$tag->slug}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Tag updated successfully',
                'tag' => [
                    'name' => 'Updated Name',
                    'slug' => 'updated-slug'
                ]
            ]);

        $this->assertDatabaseHas('tags', [
            'name' => 'Updated Name',
            'slug' => 'updated-slug'
        ]);
    }

    public function test_update_tag_validation_fails()
    {
        $existingTag = Tag::factory()->create();

        $invalidData = [
            'slug' => null,
        ];

        $response = $this->putJson("/api/tags/$existingTag->slug", $invalidData);

        $response->assertStatus(422)
            ->assertJsonStructure(['message']);
    }

    public function test_tag_not_found()
    {
        $response = $this->putJson("/api/tags/non-existing-slug");

        $response->assertStatus(404)
            ->assertJson(['message' => 'Tag not found']);
    }


    public function test_soft_delete_post()
    {
        $tag = Tag::factory()->create();

        $response = $this->putJson("/api/tags/{$tag->slug}", ['delete' => true]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'tag', 'message', 'class', 'icon'
            ]);

        $this->assertSoftDeleted('tags', ['id' => $tag->id]);
    }

    public function test_force_delete_post()
    {
        $tag = Tag::factory()->create();

        $response = $this->putJson("/api/tags/{$tag->slug}", ['destroy' => true]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'tag', 'message', 'class', 'icon'
            ]);

        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }

    public function test_restore_post()
    {
        $tag = Tag::factory()->create();
        $tag->delete();

        $response = $this->putJson("/api/tags/{$tag->slug}", ['restore' => true]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'tag', 'message', 'class', 'icon'
            ]);

        $this->assertNull($tag->fresh()->deleted_at);
    }

}
