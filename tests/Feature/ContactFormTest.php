<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);

    }

    public function test_validation_rules()
    {
        // Missing required fields
        $response = $this->postJson('/api/get-in-touch', []);

        $response->assertStatus(422)
            ->assertJson(['message' => 'The name field is required. (and 3 more errors)']);

        // Invalid email
        $response = $this->postJson('/api/get-in-touch', [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'body' => 'Hello, this is a test message.',
            'g-recaptcha-response' => 'valid-captcha',
        ]);
        $response->assertStatus(422)
            ->assertJson(['message' => 'The email must be a valid email address.']);

        // Body exceeds 200 characters
        $response = $this->postJson('/api/get-in-touch', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'body' => str_repeat('a', 201),
            'g-recaptcha-response' => 'valid-captcha',
        ]);
        $response->assertStatus(422)
            ->assertJson(['message' => 'The message must not be greater than 200 characters.']);
    }

    public function test_captcha_validation_failure()
    {
        $response = $this->postJson('/api/get-in-touch', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'body' => 'Hello, this is a test message.',
            'g-recaptcha-response' => 'invalid-captcha',
        ]);

        $response->assertStatus(422)
            ->assertJson(['message' => 'Issue with captcha, Try again !']);
    }

    public function test_submission_fails_with_valid_data()
    {
        $this->withoutExceptionHandling();

        $validData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'body' => 'Test message content',
            'g-recaptcha-response' => 'invalid-captcha-response'
        ];

        // Mock captcha validation to throw an exception
        $this->partialMock(\App\Http\Controllers\Api\ContactController::class, function ($mock) {
            $mock->shouldReceive('checkCaptcha')->once()->andReturnNull();
        });

        $response = $this->postJson('/api/get-in-touch', $validData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Message sent successfully',
            ]);
    }
}
