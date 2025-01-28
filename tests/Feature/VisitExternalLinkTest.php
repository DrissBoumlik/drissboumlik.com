<?php

namespace Tests\Feature;

use App\Models\ShortenedUrl;
use Database\Seeders\TestingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class VisitExternalLinkTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(TestingsSeeder::class);
    }

    public function test_redirects_to_the_correct_url_when_slug_is_valid(): void
    {
        $shortenedUrl = ShortenedUrl::factory()->create([
            'slug' => 'example',
            'redirects_to' => 'https://example.com',
            'active' => true,
        ]);

        $response = $this->get('/goto/example');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect($shortenedUrl->redirects_to);
    }

    public function test_redirects_to_not_found_when_slug_is_invalid(): void
    {
        $response = $this->get('/goto/invalid-slug');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/not-found');
    }

    public function test_displays_the_not_found_page(): void
    {
        $response = $this->get('/not-found');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('errors.404');
        $response->assertViewHas('data');
        $response->assertSee('Page Not Found');
    }
}
