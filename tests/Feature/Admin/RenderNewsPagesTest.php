<?php

namespace Tests\Feature\Admin;

use App\Models\News;
use App\Models\User;
use Tests\TestCase;

class RenderNewsPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
    }

    public function testRenderIndex(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.news.index'));

        $response->assertStatus(200);
    }

    public function testRenderCreate(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.news.create'));

        $response->assertStatus(200);
    }

    public function testRenderEdit(): void
    {
        $news = News::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.news.edit', $news->id));

        $response->assertStatus(200);
    }
}
