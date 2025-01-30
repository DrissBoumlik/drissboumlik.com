<?php

namespace Tests\Feature\Admin;

use App\Models\Menu;
use App\Models\MenuType;
use App\Models\Message;
use App\Models\Project;
use App\Models\Service;
use App\Models\ShortenedUrl;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatatableTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }

    //region interactions

    public function test_messages_datatable(): void
    {
        Message::factory()->count(5)->create();

        $response = $this->postJson("api/messages");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'body', 'created_at']
                ]
            ])
            ->assertJsonCount(5, 'data');
    }

    public function test_subscriptions_datatable(): void
    {
        Subscriber::factory()->count(5)->create();

        $response = $this->postJson("api/subscriptions");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'subscription_id', 'email', 'first_name', 'last_name', 'subscribed_at']
                ]
            ])
            ->assertJsonCount(5, 'data');
    }

    public function test_visitors_datatable(): void
    {
        Visitor::factory()->count(4)->create();

        $response = $this->postJson("/api/visitors");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'ip', 'created_at']
                ]
            ])
            ->assertJsonCount(4, 'data');
    }

    //endregion

    //region portfolio

    public function test_testimonials_datatable(): void
    {
        Testimonial::factory()->count(3)->create();

        $response = $this->postJson("/api/testimonials/list");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'content', 'author', 'position']
                ]
            ])
            ->assertJsonCount(3, 'data');
    }

    public function test_projects_datatable(): void
    {
        Project::factory()->count(3)->create();

        $response = $this->postJson("/api/projects/list");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'image', 'role', 'title', 'description']
                ]
            ])
            ->assertJsonCount(3, 'data');
    }

    public function test_services_datatable(): void
    {
        Service::factory()->count(3)->create();

        $response = $this->postJson("/api/services/list");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'slug', 'title', 'icon', 'image']
                ]
            ])
            ->assertJsonCount(3, 'data');
    }

    //endregion

    //region menus

    public function test_menus_datatable(): void
    {
        $menuType = MenuType::factory()->create();
        Menu::factory()->count(3)->create(['menu_type_id' => $menuType->id]);

        $response = $this->postJson("/api/menus/list", [ 'menu_type' => $menuType->id ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'link', 'active', 'type_name']
                ]
            ])
            ->assertJsonCount(3, 'data');
    }

    public function test_menu_types_datatable(): void
    {
        MenuType::factory()->count(3)->create();

        $response = $this->postJson("/api/menu-types");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'active', 'menus_count']
                ]
            ])
            ->assertJsonCount(3, 'data');
    }

    public function test_menu_types_api_endpoint(): void
    {
        MenuType::factory()->count(3)->create();

        $response = $this->postJson("/api/menu-types", ['api' => true]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'active']
                ]
            ])
            ->assertJsonCount(3, 'data');
    }

    public function test_shortened_urls_datatable(): void
    {
        ShortenedUrl::factory()->count(4)->create();

        $response = $this->postJson("/api/shortened-urls/list");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'slug', 'title', 'shortened', 'redirects_to']
                ]
            ])
            ->assertJsonCount(4, 'data');
    }

    //endregion

}
