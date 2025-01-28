<?php

namespace Tests\Feature\Admin;

use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);

        Storage::fake('local');
    }

    //region service

    public function test_store_service_successfully()
    {
        $imageFile = UploadedFile::fake()->image('service.jpg');

        $serviceData = [
            'slug' => 'test-service',
            'title' => 'Test Service',
            'link' => 'https://example.com',
            'icon' => 'test-icon',
            'order' => 1,
            'description' => 'Test service description',
            'active' => 'on',
            'service-image' => $imageFile
        ];

        $response = $this->postJson('/api/services', $serviceData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Stored Successfully !']);

        $this->assertDatabaseHas('services', [
            'slug' => 'test-service',
            'title' => 'Test Service',
            'active' => true
        ]);
    }

    public function test_store_service_validation_fails()
    {
        $invalidServiceData = [
            'order' => 'NotANumber',
            'slug' => '',
        ];

        $response = $this->postJson("/api/services", $invalidServiceData);

        $response->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_update_service_successfully()
    {
        $service = Service::factory()->create();
        $imageFile = UploadedFile::fake()->image('updated-service.jpg');

        $updateData = [
            'slug' => 'updated-service',
            'title' => 'Updated Service',
            'link' => 'https://updated.com',
            'icon' => 'updated-icon',
            'order' => 2,
            'description' => 'Updated service description',
            'active' => 'on',
            'service-image' => $imageFile
        ];

        $response = $this->putJson("/api/services/{$service->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Updated Successfully !']);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'slug' => 'updated-service',
            'title' => 'Updated Service',
            'active' => true
        ]);
    }

    public function test_service_not_found()
    {
        $response = $this->putJson("/api/services/99999");

        $response->assertStatus(404)
            ->assertJson(['message' => 'Service not found']);
    }

    public function test_delete_service_soft_delete()
    {
        $service = Service::factory()->create();

        $response = $this->putJson("/api/services/$service->id", ['delete' => true]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item deleted successfully']);

        $this->assertSoftDeleted('services', ['id' => $service->id]);
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'active' => false
        ]);
    }

    public function test_update_service_order_conflict()
    {
        $service1 = Service::factory()->create(['order' => 1]);
        $service2 = Service::factory()->create(['order' => 2]);

        $updateData = $service1->toArray();
        $updateData['order'] = 2;

        $response = $this->putJson("/api/services/$service1->id", $updateData);

        $response->assertStatus(200);

        $service1 = $service1->fresh();
        $service2 = $service2->fresh();

        $this->assertEquals(2, $service1->order);
        $this->assertEquals(1, $service2->order);
    }

    public function test_update_service_validation_fails()
    {
        $existingService = Service::factory()->create();

        $invalidServiceData = [
            'order' => 'AAA',
            'slug' => '',
        ];

        $response = $this->putJson("/api/services/$existingService->id", $invalidServiceData);

        $response->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_force_delete_service()
    {
        $service = Service::factory()->create();

        $response = $this->putJson("/api/services/$service->id", ['destroy' => true]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item deleted for good successfully']);

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    //endregion

    //region testimonial

    public function test_store_testimonial_successfully()
    {
        $imageFile = UploadedFile::fake()->image('testimonial.jpg');

        $testimonialData = [
            'author' => 'John Doe',
            'content' => 'Amazing service!',
            'position' => 'CEO',
            'order' => 1,
            'active' => 'on',
            'testimonial-image' => $imageFile
        ];

        $response = $this->postJson('/api/testimonials', $testimonialData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Stored Successfully !']);

        $this->assertDatabaseHas('testimonials', [
            'author' => 'John Doe',
            'position' => 'CEO',
            'active' => true
        ]);
    }

    public function test_store_testimonial_validation_fails()
    {
        $invalidTestimonialData = [
            'order' => 'NotANumber',
            'slug' => '',
        ];

        $response = $this->postJson("/api/testimonials", $invalidTestimonialData);

        $response->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_update_testimonial_successfully()
    {
        $testimonial = Testimonial::factory()->create();
        $imageFile = UploadedFile::fake()->image('updated-testimonial.jpg');

        $updateData = [
            'author' => 'Jane Doe',
            'content' => 'Updated testimonial',
            'position' => 'CTO',
            'order' => 2,
            'active' => 'on',
            'testimonial-image' => $imageFile
        ];

        $response = $this->putJson("/api/testimonials/{$testimonial->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Updated Successfully !']);

        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'author' => 'Jane Doe',
            'position' => 'CTO',
            'active' => true
        ]);
    }

    public function test_testimonial_not_found()
    {
        $response = $this->putJson("/api/testimonials/99999");

        $response->assertStatus(404)
            ->assertJson(['message' => 'Testimonial not found']);
    }

    public function test_delete_testimonial_soft_delete()
    {
        $testimonial = Testimonial::factory()->create();

        $response = $this->putJson("/api/testimonials/$testimonial->id", ['delete' => true]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item deleted successfully']);

        $this->assertSoftDeleted('testimonials', ['id' => $testimonial->id]);
        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'active' => false
        ]);
    }

    public function test_update_testimonial_order_conflict()
    {
        $testimonial1 = Testimonial::factory()->create(['order' => 1]);
        $testimonial2 = Testimonial::factory()->create(['order' => 2]);

        $updateData = $testimonial1->toArray();
        $updateData['order'] = 2;

        $response = $this->putJson("/api/testimonials/$testimonial1->id", $updateData);

        $response->assertStatus(200);

        $testimonial1 = $testimonial1->fresh();
        $testimonial2 = $testimonial2->fresh();

        $this->assertEquals(2, $testimonial1->order);
        $this->assertEquals(1, $testimonial2->order);
    }

    public function test_update_testimonial_validation_fails()
    {
        $existingTestimonial = Testimonial::factory()->create();

        $invalidTestimonialData = [
            'order' => 'AAA',
        ];

        $response = $this->putJson("/api/testimonials/$existingTestimonial->id", $invalidTestimonialData);

        $response->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_force_delete_testimonial()
    {
        $testimonial = Testimonial::factory()->create();

        $response = $this->putJson("/api/testimonials/$testimonial->id", ['destroy' => true]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item deleted for good successfully']);

        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }

    //endregion

    //region projects

    public function test_store_project_successfully()
    {
        $imageFile = UploadedFile::fake()->image('project.jpg');

        $projectData = [
            'title' => 'Test Project',
            'role' => 'Developer',
            'description' => 'Project description',
            'links' => [
                'repository' => 'https://github.com/test',
                'website' => 'https://example.com'
            ],
            'order' => 1,
            'active' => 'on',
            'featured' => 'on',
            'project-image' => $imageFile
        ];

        $response = $this->postJson('/api/projects', $projectData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Stored Successfully !']);

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
            'role' => 'Developer',
            'featured' => true,
            'active' => true
        ]);
    }

    public function test_store_project_successfully_with_missing_links()
    {
        $imageFile = UploadedFile::fake()->image('project.jpg');

        $projectData = [
            'title' => 'Test Project',
            'role' => 'Developer',
            'description' => 'Project description',
            'links' => [
                'repository' => null,
                'website' => null,
            ],
            'order' => 1,
            'active' => 'on',
            'featured' => 'on',
            'project-image' => $imageFile
        ];

        $response = $this->postJson('/api/projects', $projectData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Stored Successfully !']);

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
            'role' => 'Developer',
            'featured' => true,
            'active' => true
        ]);
    }

    public function test_store_project_validation_fails()
    {
        $invalidData = [
            'order' => 'NotANumber',
        ];

        $response = $this->postJson("/api/projects", $invalidData);

        $response->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_update_project_successfully()
    {
        $project = Project::factory()->create();
        $imageFile = UploadedFile::fake()->image('updated-testimonial.jpg');

        $updateData = [
            'title' => 'Updated Project',
            'role' => 'Senior Developer',
            'description' => 'Updated project description',
            'links' => [
                'repository' => 'https://github.com/updated',
                'website' => 'https://updated.com'
            ],
            'order' => 2,
            'active' => 'on',
            'featured' => 'on',
            'project-image' => $imageFile
        ];

        $response = $this->putJson("/api/projects/{$project->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Updated Successfully !']);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Updated Project',
            'role' => 'Senior Developer',
            'featured' => true,
            'active' => true
        ]);
    }

    public function test_update_project_successfully_with_missing_links()
    {
        $project = Project::factory()->create();
        $imageFile = UploadedFile::fake()->image('project.jpg');

        $projectData = [
            'title' => 'Test Project',
            'role' => 'Developer',
            'description' => 'Project description',
            'links' => [
                'repository' => null,
                'website' => null,
            ],
            'order' => 1,
            'active' => 'on',
            'featured' => 'on',
            'project-image' => $imageFile
        ];

        $response = $this->putJson("/api/projects/$project->id", $projectData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Updated Successfully !']);

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
            'role' => 'Developer',
            'featured' => true,
            'active' => true
        ]);
    }

    public function test_project_not_found()
    {
        $response = $this->putJson("/api/projects/99999");

        $response->assertStatus(404)
            ->assertJson(['message' => 'Project not found']);
    }

    public function test_delete_project_soft_delete()
    {
        $project = Project::factory()->create();

        $response = $this->putJson("/api/projects/$project->id", ['delete' => true]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item deleted successfully']);

        $this->assertSoftDeleted('projects', ['id' => $project->id]);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'active' => false
        ]);
    }

    public function test_update_project_order_conflict()
    {
        $project1 = Project::factory()->create(['order' => 1]);
        $project2 = Project::factory()->create(['order' => 2]);

        $updateData = $project1->toArray();
        $updateData['links'] = (array) json_decode($updateData['links']);
        $updateData['order'] = 2;

        $response = $this->putJson("/api/projects/$project1->id", $updateData);

        $response->assertStatus(200);

        $project1 = $project1->fresh();
        $project2 = $project2->fresh();

        $this->assertEquals(2, $project1->order);
        $this->assertEquals(1, $project2->order);
    }

    public function test_update_project_validation_fails()
    {
        $existingProject = Project::factory()->create();

        $invalidData = [
            'order' => 'AAA',
        ];

        $response = $this->putJson("/api/projects/$existingProject->id", $invalidData);

        $response->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_force_delete_project()
    {
        $project = Project::factory()->create();

        $response = $this->putJson("/api/projects/$project->id", ['destroy' => true]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item deleted for good successfully']);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    //endregion

    public function test_restore_items()
    {
        $service = Service::factory()->create();
        $testimonial = Testimonial::factory()->create();
        $project = Project::factory()->create();

        $service->delete();
        $testimonial->delete();
        $project->delete();

        $this->putJson("/api/services/{$service->id}", ['restore' => true])
            ->assertStatus(200)
            ->assertJson(['message' => 'Item restored successfully']);

        $this->putJson("/api/testimonials/{$testimonial->id}", ['restore' => true])
            ->assertStatus(200)
            ->assertJson(['message' => 'Item restored successfully']);

        $this->putJson("/api/projects/{$project->id}", ['restore' => true])
            ->assertStatus(200)
            ->assertJson(['message' => 'Item restored successfully']);

        $this->assertNull($service->fresh()->deleted_at);
        $this->assertNull($testimonial->fresh()->deleted_at);
        $this->assertNull($project->fresh()->deleted_at);
    }
}
