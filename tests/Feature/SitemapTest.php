<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SitemapTest extends TestCase
{

    public function test_sitemap_route_returns_xml_file(): void
    {
        Storage::fake('public');
        $mockContent = '<urlset><url><loc>https://example.com</loc></url></urlset>';
        Storage::disk('public')->put('sitemap.xml', $mockContent);

        $response = $this->get('/sitemap');

        // Assert: Check the response status, headers, and content
        $response->assertStatus(Response::HTTP_OK);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertHeader('Content-Disposition', 'inline; filename="sitemap.xml"');
        $this->assertEquals($mockContent, $response->getContent());
    }
}
