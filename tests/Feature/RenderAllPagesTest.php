<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\News;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RenderAllPagesTest extends TestCase
{
    use RefreshDatabase;

    public function testRenderHome(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testRenderNews(): void
    {
        if (class_exists(News::class)) {
            News::factory()->create(['publish' => true]);
        }

        $response = $this->get('/news');

        $response->assertStatus(200);
    }

    public function testRenderNewsShow(): void
    {
        $slug = 'test-news-slug';

        if (class_exists(News::class)) {
            News::factory()->create([
                'slug' => $slug,
                'publish' => true,
            ]);
        }

        $response = $this->get("/news/{$slug}");

        $response->assertStatus(200);
    }

    public function testRenderGallery(): void
    {
        $response = $this->get('/gallery');

        $response->assertStatus(200);
    }

    public function testRenderContacts(): void
    {
        $response = $this->get('/contacts');

        $response->assertStatus(200);
    }

    public function testRenderPageInfo(): void
    {
        $menuSlug = 'about-us';

        if (class_exists(Page::class) && class_exists(Menu::class)) {
            $page = Page::factory()->create();
            Menu::factory()->create([
                'slug' => $menuSlug,
                'page_id' => $page->id,
                'publish' => true
            ]);
        }

        $response = $this->get("/page/{$menuSlug}");

        $response->assertStatus(200);
    }
}
