<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Spatie\DbDumper\Databases\MySql;
use Tests\TestCase;

class ToolTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);

        Storage::fake('public');
    }

    public function test_generate_sitemap_creates_sitemap_file()
    {
        $response = $this->get('/admin/generate-sitemap');

        $response->assertRedirect('/sitemap');
        Storage::disk('public')->assertExists('sitemap.xml');
        Storage::disk('public')->assertExists('sitemap-archive/sitemap_' . date("Y-m-d_h-i") . '.xml');
    }

    public function test_export_db_config_page_loads_successfully()
    {
        $response = $this->get('/admin/export-db/config');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.export-db-config')
            ->assertViewHas('data');
    }

    public function test_export_db_successfully()
    {
        // Mock the Storage facade
        Storage::fake('dumps'); // Use a fake disk for testing

        // Mock the MySql class
        $mockDumper = Mockery::mock(MySql::class);
        $mockDumper->shouldReceive('setDbName')->once()->andReturnSelf();
        $mockDumper->shouldReceive('setUserName')->once()->andReturnSelf();
        $mockDumper->shouldReceive('setPassword')->once()->andReturnSelf();
        $mockDumper->shouldReceive('doNotCreateTables')->once()->andReturnSelf();
        $mockDumper->shouldReceive('doNotDumpData')->once()->andReturnSelf();
        $mockDumper->shouldReceive('includeTables')->once()->andReturnSelf();
        $mockDumper->shouldReceive('dumpToFile')->once();

        // Bind the mock to the service container
        $this->app->instance(MySql::class, $mockDumper);

        // Create the dumps directory if it doesn't exist
        $dumpsDirectory = database_path('dumps');
        File::ensureDirectoryExists($dumpsDirectory);

        // Create a fake file to simulate the dump
        $now = date("Y-m-d_h-i");
        $filename = "db_com_testing_exported_at_$now.sql";
        $filePath = database_path("dumps/$filename");
        File::put($filePath, 'fake SQL content');


        $query = http_build_query([
            'tables' => 'users posts',
            'dont-create-tables' => true,
            'dont-export-data' => true,
        ]);

        // Call the API endpoint
        $response = $this->get("/admin/export-db?$query");

        // Assert the response
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/sql');

    }

    public function test_export_db_failure()
    {
        // Mock the MySql class to throw an exception
        $mockDumper = Mockery::mock(MySql::class);
        $mockDumper->shouldReceive('setDbName')->once()->andReturnSelf();
        $mockDumper->shouldReceive('setUserName')->once()->andReturnSelf();
        $mockDumper->shouldReceive('setPassword')->once()->andReturnSelf();
        $mockDumper->shouldReceive('doNotCreateTables')->once()->andThrow(new \Exception('Dump failed'));

        // Bind the mock to the service container
        $this->app->instance(MySql::class, $mockDumper);

        $query = http_build_query([
            'tables' => 'users posts',
            'dont-create-tables' => true,
        ]);
        // Call the API endpoint with a GET request
        $response = $this->get("/admin/export-db?$query");

        // Assert the response
        $response->assertStatus(302); // Assuming you're redirecting back on failure
        $response->assertSessionHas('response', [
            'message' => 'Dump failed',
            'class' => 'alert-danger',
            'icon' => '<i class="fa fa-fw fa-times-circle"></i>'
        ]);
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
