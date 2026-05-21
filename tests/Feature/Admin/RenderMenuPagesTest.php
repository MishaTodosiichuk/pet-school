<?php

namespace Tests\Feature\Admin;

use App\Models\Menu;
use App\Models\User;
use Tests\TestCase;

class RenderMenuPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
    }

    public function testRenderIndex(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.menus.index'));

        $response->assertStatus(200);
    }

    public function testRenderCreate(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.menus.create'));

        $response->assertStatus(200);
    }

    public function testRenderEdit(): void
    {
        $menu = Menu::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.menus.edit', $menu->id));

        $response->assertStatus(200);
    }
}
