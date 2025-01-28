<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);

    }
    public function test_profile_page_loads_successfully()
    {
        $user = User::factory()->create();

        $response = $this->get('/admin/profile');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.profile')
            ->assertViewHas('user');
    }

    public function test_user_can_update_profile_with_valid_data()
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com'
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->actingAs($user)->post('/admin/profile', $updateData);

        $response->assertRedirect()
            ->assertSessionHas('response', function ($response) {
                return $response['message'] === 'Profile updated successfully'
                    && $response['class'] === 'alert-info';
            });

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com'
        ]);
    }

    public function test_update_profile_fails_with_invalid_email()
    {
        $user = User::factory()->create();

        $invalidData = [
            'name' => 'Test User',
            'email' => 'invalid-email',
        ];

        $response = $this->actingAs($user)->post('/admin/profile', $invalidData);

        $response->assertSessionHas('response');
    }
}
