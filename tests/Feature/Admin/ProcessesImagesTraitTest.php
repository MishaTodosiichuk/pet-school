<?php

namespace Tests\Feature\Admin;

use App\Models\Image;
use App\Models\PhotoGallery;
use App\Traits\ProcessesImagesTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProcessesImagesTraitTest extends TestCase
{
    use RefreshDatabase;

    private object $traitDummy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->traitDummy = new class {
            use ProcessesImagesTrait {
                processImages as public;
            }
        };
    }

    public function test_it_processes_and_stores_uploaded_images_correctly(): void
    {
        Storage::fake('public');

        $gallery = PhotoGallery::factory()->create([
            'title' => 'Тестова Галерея',
        ]);

        $file1 = UploadedFile::fake()->image('avatar.jpg');
        $file2 = UploadedFile::fake()->image('banner.png');

        $this->traitDummy->processImages($gallery, [
            'images_uploads' => [$file1, $file2],
            'images' => []
        ]);

        $this->assertDatabaseCount('images', 2);

        $images = Image::all();
        foreach ($images as $image) {
            $relativeStoragePath = str_replace('/storage/', '', $image->url);
            Storage::disk('public')->assertExists($relativeStoragePath);

            $this->assertEquals('Тестова Галерея', $image->alt);
        }

        $this->assertCount(2, $gallery->fresh()->images);
    }

    public function test_it_syncs_existing_images_and_drops_unprovided_ones(): void
    {
        Storage::fake('public');

        $gallery = PhotoGallery::factory()->create();

        $image1 = Image::factory()->create();
        $image2 = Image::factory()->create();
        $image3 = Image::factory()->create();

        $gallery->images()->attach([$image1->id, $image2->id, $image3->id]);
        $this->assertCount(3, $gallery->fresh()->images);

        $this->traitDummy->processImages($gallery, [
            'images_uploads' => [],
            'images' => [$image1->id, $image2->id]
        ]);

        $gallery->refresh();
        $this->assertCount(2, $gallery->images);
        $this->assertTrue($gallery->images->contains($image1));
        $this->assertTrue($gallery->images->contains($image2));
        $this->assertFalse($gallery->images->contains($image3));
    }

    public function test_it_combines_existing_and_newly_uploaded_images(): void
    {
        Storage::fake('public');

        $gallery = PhotoGallery::factory()->create();
        $existingImage = Image::factory()->create();
        $gallery->images()->attach($existingImage->id);

        $newFile = UploadedFile::fake()->image('new_photo.jpg');

        $this->traitDummy->processImages($gallery, [
            'images_uploads' => [$newFile],
            'images' => [$existingImage->id]
        ]);

        $gallery->refresh();
        $this->assertCount(2, $gallery->images);
        $this->assertTrue($gallery->images->contains($existingImage));
    }

    public function test_it_uses_custom_directory_name_if_provided(): void
    {
        Storage::fake('public');

        $gallery = PhotoGallery::factory()->create();
        $file = UploadedFile::fake()->image('custom.jpg');

        $this->traitDummy->processImages($gallery, [
            'images_uploads' => [$file]
        ], 'custom_gallery_folder');

        $image = Image::query()->first();

        $this->assertStringContainsString('uploads/custom_gallery_folder/', $image->url);
    }
}
