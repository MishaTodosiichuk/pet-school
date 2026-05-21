<?php

namespace Tests\Feature\Admin;

use App\Models\News;
use App\Models\PhotoGallery;
use App\Models\User;
use Tests\TestCase;

class RenderPhotoGalleryPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
    }

    public function testRenderIndex(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.gallery.index'));

        $response->assertStatus(200);
    }

    public function testRenderCreate(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.gallery.create'));

        $response->assertStatus(200);
    }

    public function testRenderEdit(): void
    {
        $gallery = PhotoGallery::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.gallery.edit', $gallery->id));

        $response->assertStatus(200);
    }
}
