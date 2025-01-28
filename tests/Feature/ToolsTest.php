<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ToolsTest extends TestCase
{
    public function test_get_pixel_route_redirects_to_correct_image(): void
    {
        $response = $this->get('/pixel');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/assets/img/mixte/pixel.png');
    }
}
