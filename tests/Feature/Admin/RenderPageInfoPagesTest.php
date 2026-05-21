<?php

namespace Tests\Feature\Admin;

use App\Models\Page;
use App\Models\User;
use Tests\TestCase;

class RenderPageInfoPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
    }

    public function testRenderIndex(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.page.index'));

        $response->assertStatus(200);
    }

    public function testRenderCreate(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.page.create'));

        $response->assertStatus(200);
    }

    public function testRenderEdit(): void
    {
        $page = Page::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.page.edit', $page->id));

        $response->assertStatus(200);
    }
}
