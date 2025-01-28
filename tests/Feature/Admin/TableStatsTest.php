<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class TableStatsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);

    }

    public function test_get_table_columns_returns_columns()
    {
        $table = 'users';

        $response = $this->get("/api/{$table}/columns");

        $response->assertStatus(200)
            ->assertJsonStructure([]);
    }

    public function test_get_table_column_stats_without_year()
    {
        $response = $this->post('/api/stats', [
            'table' => 'users',
            'column' => 'id'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [],
                'current_page',
                'last_page'
            ]);
    }

    public function test_get_table_column_stats_with_year()
    {
        $response = $this->post('/api/stats', [
            'table' => 'users',
            'column' => 'id',
            'year' => date('Y')
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [],
                'current_page',
                'last_page'
            ]);
    }
}
