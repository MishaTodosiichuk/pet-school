<?php

namespace Tests\Feature\Admin;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
    }

    public function testIndexPageIsDisplayed(): void
    {
        Menu::factory()->create([
            'title' => 'Головне меню',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.menus.index'));

        $response->assertOk();
        $response->assertViewIs('admin.pages.menu.index');
        $response->assertViewHas(['menus', 'tableConfig', 'breadcrumbs']);
    }

    public function testCreatePageIsDisplayed(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.menus.create'));

        $response->assertOk();
        $response->assertViewIs('admin.pages.menu.create');
        $response->assertViewHas(['breadcrumbs', 'formConfig']);
    }

    public function testMenuCanBeCreated(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.menus.store'), [
            'title' => 'Footer menu',
            'slug' => '',
            'parent_id' => null,
            'publish' => true,
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.menus.index'));

        $this->assertDatabaseHas('menus', [
            'title' => 'Footer menu',
            'slug' => 'footer-menu',
            'publish' => true,
        ]);
    }

    public function testMenuCanBeUpdated(): void
    {
        $menu = Menu::factory()->create([
            'title' => 'Old title',
            'slug' => 'old-title',
            'publish' => true,
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.menus.update', $menu->id), [
            'title' => 'New title',
            'slug' => 'new-title',
            'parent_id' => null,
            'publish' => false,
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.menus.index'));

        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'title' => 'New title',
            'slug' => 'new-title',
            'publish' => false,
        ]);
    }

    public function testMenuCanBeDeleted(): void
    {
        $menu = Menu::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.menus.destroy', $menu));

        $response->assertRedirect(route('admin.menus.index'));

        $this->assertSoftDeleted('menus', [
            'id' => $menu->id,
        ]);
    }

    public function testPublishCanBeUpdated(): void
    {
        $menu = Menu::factory()->create([
            'publish' => false,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.menus.publish', $menu), [
            'publish' => true,
        ]);

        $response->assertRedirect(route('admin.menus.index'));

        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'publish' => true,
        ]);
    }

    public function testIndexCanSearchMenus(): void
    {
        Menu::factory()->create([
            'title' => 'Header menu',
        ]);

        Menu::factory()->create([
            'title' => 'Footer menu',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.menus.index', [
            'query' => 'Header',
        ]));

        $response->assertOk();

        $menus = $response->viewData('menus');

        $this->assertCount(1, $menus);
        $this->assertSame('Header menu', $menus->first()->title);
    }
}
