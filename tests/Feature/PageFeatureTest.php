<?php

namespace Tests\Feature;

use Database\Seeders\TestingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PageFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(TestingsSeeder::class);
    }

    public function test_redirects_to_not_found_if_var_is_provided(): void
    {
        $response = $this->get('/some-var');

        $response->assertViewIs('errors.404');
        $response->assertSee('page not found');
    }

    public function test_returns_home_page_for_valid_requests(): void
    {
        $response = $this->get('/');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('pages.home');
        $response->assertSee('Home | Driss Boumlik');
        $response->assertViewHas('data');
    }

    public function test_about_page_is_accessible(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('pages.about');
        $response->assertViewHas('data');
    }

    public function test_testimonials_page_is_accessible(): void
    {
        $response = $this->get('/testimonials');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('pages.testimonials');
        $response->assertViewHas('data');
    }

    public function test_projects_page_is_accessible(): void
    {
        $response = $this->get('/work');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('pages.projects');
        $response->assertViewHas('data');
    }

    public function test_privacy_policy_page_is_accessible(): void
    {
        $response = $this->get('/privacy-policy');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('pages.privacy-policy');
        $response->assertViewHas('data');
    }

    public function test_contact_page_is_accessible(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('pages.contact');
        $response->assertViewHas('data');
    }

    public function test_services_page_is_accessible(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('pages.services');
        $response->assertViewHas('data');
    }

    public function test_resume_page_is_accessible(): void
    {
        $response = $this->get('/resume');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('pages.resume');
        $response->assertViewHas('data');
    }

}
