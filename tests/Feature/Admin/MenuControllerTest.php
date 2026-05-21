<?php

namespace Tests\Feature\Admin;

use App\Models\Menu;
use App\Models\Page;
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

    public function testEditPageIsDisplayed(): void
    {
        $page = Page::create(['title' => 'Якась сторінка']);
        $menu = Menu::factory()->create([
            'title' => 'Пункт меню',
            'page_id' => $page->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.menus.edit', $menu->id));

        $response->assertOk();
        $response->assertViewIs('admin.pages.menu.edit');
        $response->assertViewHas(['menu', 'breadcrumbs', 'formConfig']);
    }

    public function testMenuCanBeCreatedWithExistingPage(): void
    {
        $page = Page::create(['title' => 'Офіційні документи закладу']);

        $response = $this->actingAs($this->admin)->post(route('admin.menus.store'), [
            'title' => 'Статут та ліцензії',
            'slug' => '',
            'parent_id' => null,
            'page_id' => $page->id,
            'publish' => true,
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.menus.index'));

        $this->assertDatabaseHas('menus', [
            'title' => 'Статут та ліцензії',
            'slug' => 'statut-ta-licenziyi',
            'page_id' => $page->id,
            'publish' => true,
        ]);

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'title' => 'Офіційні документи закладу',
        ]);
    }

    public function testMenuCanBeCreatedAsChild(): void
    {
        $parentMenu = Menu::factory()->create([
            'title' => 'Освітній процес',
            'slug' => 'osvitniy-proces',
        ]);

        $page = Page::create(['title' => 'Розклад занять']);

        $response = $this->actingAs($this->admin)->post(route('admin.menus.store'), [
            'title' => 'Розклад',
            'slug' => '',
            'parent_id' => $parentMenu->id,
            'page_id' => $page->id,
            'publish' => true,
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.menus.index'));

        $this->assertDatabaseHas('menus', [
            'title' => 'Розклад',
            'parent_id' => $parentMenu->id,
            'page_id' => $page->id,
        ]);
    }

    public function testMenuCanBeCreatedWithoutPage(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.menus.store'), [
            'title' => 'Тільки Категорія',
            'slug' => '',
            'parent_id' => null,
            'page_id' => null,
            'publish' => true,
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.menus.index'));

        $this->assertDatabaseHas('menus', [
            'title' => 'Тільки Категорія',
            'page_id' => null,
        ]);
    }

    public function testMenuCanBeUpdatedWithoutChangingPage(): void
    {
        $page = Page::create(['title' => 'Контентна сторінка']);
        $menu = Menu::factory()->create([
            'title' => 'Стара назва меню',
            'slug' => 'stara-nazva-menyu',
            'publish' => true,
            'page_id' => $page->id,
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.menus.update', $menu->id), [
            'title' => 'Нова назва меню',
            'slug' => 'nova-nazva-menyu',
            'parent_id' => null,
            'page_id' => $page->id,
            'publish' => false,
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.menus.index'));

        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'title' => 'Нова назва меню',
            'slug' => 'nova-nazva-menyu',
            'publish' => false,
        ]);

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'title' => 'Контентна сторінка',
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

    public function testMenuStoreValidationFailsWithoutTitle(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.menus.store'), [
            'title' => '',
            'slug' => '',
            'parent_id' => null,
            'publish' => true,
        ]);

        $response->assertSessionHasErrors(['title']);
        $this->assertDatabaseCount('menus', 0);
    }

    public function testMenuUpdateValidationFailsWithoutTitle(): void
    {
        $menu = Menu::factory()->create(['title' => 'Існуюче меню']);

        $response = $this->actingAs($this->admin)->patch(route('admin.menus.update', $menu->id), [
            'title' => '',
            'slug' => 'isnyuche-menyu',
            'parent_id' => null,
            'publish' => true,
        ]);

        $response->assertSessionHasErrors(['title']);

        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'title' => 'Існуюче меню',
        ]);
    }

    public function testGuestCannotAccessAdminRoutes(): void
    {
        $response = $this->get(route('admin.menus.index'));

        $response->assertRedirect('/login');
    }
}
