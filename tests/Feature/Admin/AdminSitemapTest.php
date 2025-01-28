<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSitemapTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);

        Storage::fake('public');
    }

    public function test_generate_sitemap_creates_sitemap_file()
    {
        $response = $this->get('/admin/generate-sitemap');

        $response->assertRedirect('/sitemap');
        Storage::disk('public')->assertExists('sitemap.xml');
        Storage::disk('public')->assertExists('sitemap-archive/sitemap_' . date("Y-m-d_h-i") . '.xml');
    }

}
