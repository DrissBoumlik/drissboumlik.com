<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AdminPageFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }

    //region portfolio

    public function test_testimonials_page_loads(): void
    {
        $response = $this->get('/admin/testimonials');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.testimonials');
    }

    public function test_projects_page_loads(): void
    {
        $response = $this->get('/admin/projects');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.projects');
    }

    public function test_services_page_loads(): void
    {
        $response = $this->get('/admin/services');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.services');
    }

    //endregion

    //region menus

    public function test_shortened_urls_page_loads(): void
    {
        $response = $this->get('/admin/shortened-urls');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.shortened-urls');
    }

    public function test_menus_page_loads(): void
    {
        $response = $this->get('/admin/menus');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.menus');
    }

    public function test_menu_types_page_loads(): void
    {
        $response = $this->get('/admin/menu-types');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.menu-types');
    }

    //endregion

    //region interactions

    public function test_messages_page_loads(): void
    {
        $response = $this->get('/admin/messages');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.messages');
    }

    public function test_subscriptions_page_loads(): void
    {
        $response = $this->get('/admin/subscriptions');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.subscriptions');
    }

    public function test_visitors_page_loads(): void
    {
        $response = $this->get('/admin/visitors');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.visitors');
    }

    public function test_visitors_charts_page_loads(): void
    {
        $response = $this->get('/admin/visitors/charts');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.charts');
    }

    //endregion

    public function test_sitemap_page_loads(): void
    {
        $response = $this->get('/admin/sitemap');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.sitemaps');
    }
}
