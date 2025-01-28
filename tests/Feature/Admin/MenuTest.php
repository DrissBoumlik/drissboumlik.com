<?php

namespace Tests\Feature\Admin;

use App\Models\Menu;
use App\Models\MenuType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }

    public function test_store_menu_successfully()
    {
        $menuType = MenuType::factory()->create();

        $menuData = [
            'menu_type_id' => $menuType->id,
            'slug' => 'test-menu',
            'title' => 'Test Menu',
            'text' => 'Menu Text',
            'target' => '_self',
            'link' => '/test-link',
            'icon' => 'test-icon',
            'order' => 1,
            'active' => 'on'
        ];

        $response = $this->postJson("/api/menus", $menuData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Stored Successfully !']);

        $this->assertDatabaseHas('menus', [
            'slug' => 'test-menu',
            'title' => 'Test Menu',
            'active' => true
        ]);
    }

    public function test_store_menu_validation_fails()
    {
        $invalidMenuData = [
            'menu_type_id' => 999,
            'slug' => '',
        ];

        $response = $this->postJson("/api/menus", $invalidMenuData);

        $response->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_store_menu_order_conflict()
    {
        $menuType = MenuType::factory()->create();
        $menu = Menu::factory(['menu_type_id' => $menuType->id, 'order' => 1])->create();

        $menuData = [
            'menu_type_id' => $menuType->id,
            'slug' => 'test-menu',
            'title' => 'Test Menu',
            'text' => 'Menu Text',
            'target' => '_self',
            'link' => '/test-link',
            'icon' => 'test-icon',
            'order' => 1,
            'active' => 'on'
        ];

        $response = $this->postJson("/api/menus", $menuData);

        $response->assertStatus(404)
            ->assertJson(['message' => 'The order must be unique for the specified menu type.']);
    }

    public function test_update_menu_successfully()
    {
        $menuType = MenuType::factory()->create();
        $existingMenu = Menu::factory()->create([
            'menu_type_id' => $menuType->id,
            'order' => 1
        ]);

        $updateData = [
            'menu_type_id' => $menuType->id,
            'slug' => 'updated-menu',
            'title' => 'Updated Menu',
            'text' => 'Updated Text',
            'target' => '_blank',
            'link' => '/updated-link',
            'icon' => 'updated-icon',
            'order' => 2,
            'active' => 'on'
        ];

        $response = $this->putJson("api/menus/$existingMenu->id", $updateData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Updated Successfully !']);

        $this->assertDatabaseHas('menus', [
            'id' => $existingMenu->id,
            'slug' => 'updated-menu',
            'title' => 'Updated Menu',
            'active' => true
        ]);
    }

    public function test_menu_not_found()
    {
        $response = $this->putJson("/api/menus/99999", [
            'title' => 'Non-existent Menu'
        ]);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Menu not found']);
    }

    public function test_update_menu_order_conflict()
    {
        $menuType = MenuType::factory()->create();
        $menu1 = Menu::factory()->create([
            'menu_type_id' => $menuType->id,
            'order' => 1
        ]);
        $menu2 = Menu::factory()->create([
            'menu_type_id' => $menuType->id,
            'order' => 2
        ]);

        $updateData = $menu1->toArray();
        $updateData['order'] = 2;

        $response = $this->putJson("/api/menus/$menu1->id", $updateData);

        $response->assertStatus(200);

        $menu1 = $menu1->fresh();
        $menu2 = $menu2->fresh();

        $this->assertEquals(2, $menu1->order);
        $this->assertEquals(1, $menu2->order);
    }

    public function test_update_menu_validation_fails()
    {
        $menuType = MenuType::factory()->create();
        $existingMenu = Menu::factory()->create([
            'menu_type_id' => $menuType->id,
        ]);

        $invalidMenuData = [
            'menu_type_id' => 999,
            'slug' => '',
        ];

        $response = $this->putJson("/api/menus/$existingMenu->id", $invalidMenuData);

        $response->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function test_delete_menu_soft_delete()
    {
        $menuType = MenuType::factory()->create();
        $menu = Menu::factory([
            'menu_type_id' => $menuType->id,
        ])->create();

        $response = $this->putJson("/api/menus/$menu->id", ['delete' => true]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item deleted successfully']);

        $this->assertSoftDeleted('menus', ['id' => $menu->id]);
        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'active' => false
        ]);
    }

    public function test_force_delete_menu()
    {
        $menuType = MenuType::factory()->create();
        $menu = Menu::factory(['menu_type_id' => $menuType->id])->create();

        $response = $this->putJson("/api/menus/$menu->id", ['destroy' => true]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item deleted for good successfully']);

        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
    }

    public function test_restore_menu()
    {
        $menuType = MenuType::factory()->create();
        $menu = Menu::factory(['menu_type_id' => $menuType->id])->create();
        $menu->delete();

        $response = $this->putJson("/api/menus/$menu->id", ['restore' => true]);

        $response->assertStatus(200);
        $this->assertNull($menu->fresh()->deleted_at);
    }


}
