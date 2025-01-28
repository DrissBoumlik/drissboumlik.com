<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Admin\Api\CRUDController;
use App\Models\MenuType;
use App\Models\ShortenedUrl;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AdminGeneralCrudFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }

    //region visitors

    public function test_update_visitor(): void
    {
        $visitor = Visitor::factory()->create();
        $data = [
            "countryName" => "Morocco",
            "countryCode" => "MA",
            "regionName" => "Casablanca",
            "cityName" => "Casablanca",
        ];

        $response = $this->putJson("/api/visitors/$visitor->id", $data);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals($data, $visitor->refresh()->only(array_keys($data)));
    }

    public function test_update_visitor_catch_block(): void
    {
        $visitor = Visitor::factory()->create();

        $invalidData = [
            'countryName' => str_repeat('a', 300),
            'countryCode' => null,
            'regionName' => '',
            'cityName' => null
        ];

        $response = $this->putJson("/api/visitors/$visitor->id", $invalidData);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
                ->assertJsonStructure(['message']);
    }

    //endregion

    //region menu types

    public function test_successful_menu_type_update(): void
    {
        $menuType = MenuType::factory()->create();

        $updateData = [
            'name' => 'Updated Menu Type',
            'slug' => 'updated-menu-type',
            'description' => 'New description',
            'active' => 'on'
        ];

        $response = $this->putJson("/api/menu-types/$menuType->id", $updateData);

        $response->assertOk()
            ->assertJson(['message' => "Updated Successfully !"]);

        $this->assertDatabaseHas('menu_types', [
            'id' => $menuType->id,
            'name' => 'Updated Menu Type',
            'slug' => 'updated-menu-type',
            'description' => 'New description',
            'active' => true
        ]);
    }

    public function test_menu_type_update_with_active_off(): void
    {
        $menuType = MenuType::factory()->create();

        $updateData = [
            'name' => 'Updated Menu Type',
            'slug' => 'updated-menu-type',
            'description' => 'New description',
            // No active checkbox
        ];

        $response = $this->putJson("/api/menu-types/$menuType->id", $updateData);

        $response->assertOk();

        $this->assertDatabaseHas('menu_types', [
            'id' => $menuType->id,
            'active' => false
        ]);
    }

    public function test_menu_type_update_fails_with_invalid_data(): void
    {
        $menuType = MenuType::factory()->create();

        $invalidData = [
            'name' => '',
            'slug' => str_repeat('a', 300),
        ];

        $response = $this->putJson("/api/menu-types/$menuType->id", $invalidData);

        $response->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    //endregion

    //region shortened url

    public function test_successful_shortened_url_creation(): void
    {
        $data = [
            'slug' => 'test-slug',
            'title' => 'Test URL',
            'shortened' => 'http://short.url',
            'redirects_to' => 'https://example.com',
            'active' => 'on',
            'note' => 'Test note'
        ];

        $response = $this->postJson("/api/shortened-urls", $data);

        $response->assertOk()
            ->assertJson(['message' => "Stored Successfully !"]);

        $this->assertDatabaseHas('shortened_urls', [
            'slug' => 'test-slug',
            'title' => 'Test URL',
            'shortened' => 'http://short.url',
            'redirects_to' => 'https://example.com',
            'active' => true,
            'note' => 'Test note'
        ]);
    }

    public function test_shortened_url_creation_without_active_checkbox(): void
    {
        $data = [
            'slug' => 'test-slug',
            'title' => 'Test URL',
            'shortened' => 'http://short.url',
            'redirects_to' => 'https://example.com',
            'note' => 'Test note'
        ];

        $response = $this->postJson("/api/shortened-urls", $data);

        $response->assertOk();

        $this->assertDatabaseHas('shortened_urls', [
            'slug' => 'test-slug',
            'active' => false
        ]);
    }

    public function test_shortened_url_creation_with_mailto_redirects(): void
    {
        $data = [
            'slug' => 'test-mailto',
            'title' => 'Test Mailto',
            'shortened' => 'http://short.url',
            'redirects_to' => 'mailtotestexample',
            'active' => 'on'
        ];

        $response = $this->postJson("/api/shortened-urls", $data);

        $response->assertStatus(404)
            ->assertJson(['message' => 'The redirects_to must be a valid URL or a mailto email address.']);
    }

    public function test_store_fails_with_duplicate_slug(): void
    {
        ShortenedUrl::factory()->create(['slug' => 'existing-slug']);

        $data = [
            'slug' => 'existing-slug',
            'title' => 'Test URL',
            'shortened' => 'http://short.url',
            'redirects_to' => 'https://example.com'
        ];

        $response = $this->postJson("/api/shortened-urls", $data);

        $response->assertStatus(404)
            ->assertJson(['message' => 'The slug has already been taken.']);
    }

    public function test_update_shortened_url_successfully(): void
    {
        $shortenedUrl = ShortenedUrl::factory()->create();

        $updateData = [
            'slug' => 'new-slug',
            'title' => 'Updated Title',
            'shortened' => 'http://new-short.url',
            'redirects_to' => 'https://example.com',
            'active' => 'on',
            'note' => 'Updated note'
        ];

        $response = $this->putJson("/api/shortened-urls/$shortenedUrl->id", $updateData);

        $response->assertOk()
            ->assertJson(['message' => "Updated Successfully !"]);

        $this->assertDatabaseHas('shortened_urls', [
            'id' => $shortenedUrl->id,
            'slug' => 'new-slug',
            'title' => 'Updated Title',
            'shortened' => 'http://new-short.url',
            'redirects_to' => 'https://example.com',
            'active' => true,
            'note' => 'Updated note'
        ]);
    }

    public function test_update_shortened_url_creation_with_mailto_redirects(): void
    {
        $shortenedUrl = ShortenedUrl::factory()->create();

        $data = [
            'slug' => 'test-mailto',
            'title' => 'Test Mailto',
            'shortened' => 'http://short.url',
            'redirects_to' => 'mailtotestexample',
            'active' => 'on'
        ];

        $response = $this->putJson("/api/shortened-urls/$shortenedUrl->id", $data);

        $response->assertStatus(404)
            ->assertJson(['message' => 'The redirects_to must be a valid URL or a mailto email address.']);
    }

    public function test_update_fails_with_duplicate_slug(): void
    {
        $existingUrl = ShortenedUrl::factory()->create(['slug' => 'existing-slug']);
        $shortenedUrl = ShortenedUrl::factory()->create();

        $updateData = [
            'slug' => 'existing-slug',
            'title' => 'Updated Title',
            'shortened' => 'http://new-short.url',
            'redirects_to' => 'https://example.com'
        ];

        $response = $this->putJson("/api/shortened-urls/$shortenedUrl->id", $updateData);

        $response->assertStatus(404)
            ->assertJson(['message' => 'The slug has already been taken.']);
    }

    public function test_update_non_existent_shortened_url(): void
    {
        $updateData = [
            'slug' => 'new-slug',
            'title' => 'Updated Title',
            'shortened' => 'http://new-short.url',
            'redirects_to' => 'https://example.com'
        ];

        $nonExistentId = 9999;
        $response = $this->putJson("/api/shortened-urls/$nonExistentId", $updateData);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Shortened url not found']);
    }

    public function test_restore_soft_deleted_shortened_url(): void
    {
        $shortenedUrl = ShortenedUrl::factory()->create();
        $shortenedUrl->delete();

        $restoreData = ['restore' => true];

        $response = $this->putJson("/api/shortened-urls/$shortenedUrl->id", $restoreData);

        $response->assertOk();

        $this->assertNotSoftDeleted($shortenedUrl);
    }

    public function test_destroy_shortened_url(): void
    {
        $shortenedUrl = ShortenedUrl::factory()->create();

        $destroyData = ['destroy' => true];

        $response = $this->putJson("/api/shortened-urls/$shortenedUrl->id", $destroyData);

        $response->assertOk();

        $this->assertDatabaseMissing('shortened_urls', [
            'id' => $shortenedUrl->id,
        ]);
    }

    public function test_delete_shortened_url(): void
    {
        $shortenedUrl = ShortenedUrl::factory()->create();

        $destroyData = ['delete' => true];

        $response = $this->putJson("/api/shortened-urls/$shortenedUrl->id", $destroyData);

        $response->assertOk();

        $this->assertSoftDeleted($shortenedUrl);
    }

    //endregion

}
