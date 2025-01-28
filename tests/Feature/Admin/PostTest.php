<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);

    }

    public function test_index_page_loads_successfully()
    {
        $response = $this->get('/admin/posts');

        $response->assertStatus(200)
            ->assertViewIs('admin.blog.posts.index')
            ->assertViewHas('data');
    }

    public function test_create_page_loads_with_tags()
    {
        // Create some tags to be fetched
        Tag::factory()->count(3)->create();

        $response = $this->get('/admin/posts/create');

        $response->assertStatus(200)
            ->assertViewIs('admin.blog.posts.create')
            ->assertViewHas('data');
    }

    public function test_edit_page_loads_existing_post()
    {
        // Create a post with tags
        $post = Post::factory()->create();
        $tags = Tag::factory()->count(3)->create();
        $post->tags()->attach($tags->pluck('id'));

        $response = $this->get("/admin/posts/edit/{$post->slug}");

        $response->assertStatus(200)
            ->assertViewIs('admin.blog.posts.edit')
            ->assertViewHas('data')
            ->assertViewHas('post');
    }

    public function test_edit_page_redirects_for_nonexistent_post()
    {
        $nonExistentSlug = 'non-existent-post-slug';

        $response = $this->get("/admin/posts/edit/{$nonExistentSlug}");

        $response->assertRedirect('/admin/posts')
            ->assertSessionHas('response', function ($response) {
                return $response['message'] === 'Post not found'
                    && $response['class'] === 'alert-danger';
            });
    }
}
