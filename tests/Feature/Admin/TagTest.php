<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
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
        $response = $this->get('/admin/tags');

        $response->assertStatus(200)
            ->assertViewIs('admin.blog.tags.index')
            ->assertViewHas('data');
    }
}
