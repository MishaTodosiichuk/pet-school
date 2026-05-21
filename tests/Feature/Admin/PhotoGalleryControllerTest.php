<?php

namespace Tests\Feature\Admin;

use App\Models\Image;
use App\Models\PhotoGallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoGalleryControllerTest extends TestCase
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
        PhotoGallery::factory()->create([
            'title' => 'Головне меню',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.gallery.index'));

        $response->assertOk();
        $response->assertViewIs('admin.pages.gallery.index');
        $response->assertViewHas(['gallery', 'tableConfig', 'breadcrumbs']);
    }

    public function testCreatePageIsDisplayed(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.gallery.create'));

        $response->assertOk();
        $response->assertViewIs('admin.pages.gallery.create');
        $response->assertViewHas(['breadcrumbs', 'formConfig']);
    }

    public function testEditPageIsDisplayed(): void
    {
        $gallery = PhotoGallery::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.gallery.edit', $gallery->id));

        $response->assertOk();
        $response->assertViewIs('admin.pages.gallery.edit');
        $response->assertViewHas(['gallery', 'breadcrumbs', 'formConfig']);
    }

    public function testGalleryCanBeCreated(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.gallery.store'), [
            'title' => 'Home Slider',
            'key' => 'home_slider',
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.gallery.index'));

        $this->assertDatabaseHas('photo_galleries', [
            'title' => 'Home Slider',
            'key' => 'home_slider',
        ]);
    }

    public function testGalleryCanBeUpdated(): void
    {
        $gallery = PhotoGallery::factory()->create([
            'title' => 'Old Gallery',
            'key' => 'old_key',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.gallery.update', $gallery->id), [
            'title' => 'New Gallery',
            'key' => 'new_key',
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.gallery.index'));

        $this->assertDatabaseHas('photo_galleries', [
            'id' => $gallery->id,
            'title' => 'New Gallery',
            'key' => 'new_key',
        ]);
    }

    public function testGalleryCanBeDeleted(): void
    {
        $gallery = PhotoGallery::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.gallery.destroy', $gallery));

        $response->assertRedirect(route('admin.gallery.index'));

        $this->assertSoftDeleted('photo_galleries', [
            'id' => $gallery->id,
        ]);
    }

    public function testGalleryCanBeCreatedWithImages(): void
    {
        Storage::fake('public');

        $files = [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.jpg'),
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.gallery.store'), [
            'title' => 'Gallery with images',
            'key' => 'event_gallery',
            'images_uploads' => $files,
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.gallery.index'));

        $gallery = PhotoGallery::query()->where('key', 'event_gallery')->first();
        $this->assertNotNull($gallery);
        $this->assertCount(2, $gallery->images()->get());

        $image = Image::query()->first();
        $this->assertDatabaseHas('photo_galleries_image', [
            'photo_gallery_id' => $gallery->id,
            'image_id' => $image->id,
        ]);

        Storage::disk('public')->assertExists(str_replace('/storage/', '', $image->url));
    }

    public function testExistingImagesCanBeAttachedAndSortedInGallery(): void
    {
        $image1 = Image::factory()->create();
        $image2 = Image::factory()->create();

        $response = $this->actingAs($this->admin)->post(route('admin.gallery.store'), [
            'title' => 'Sorted Gallery',
            'key' => 'sorted_gallery',
            'images' => [$image2->id, $image1->id],
            'redirect_after' => 'save_and_close',
        ]);

        $gallery = PhotoGallery::query()->where('key', 'sorted_gallery')->first();

        $this->assertDatabaseHas('photo_galleries_image', [
            'photo_gallery_id' => $gallery->id,
            'image_id' => $image2->id,
        ]);

        $images = $gallery->fresh()->images()->get();
        $this->assertEquals($image2->id, $images->first()->id);
    }

    public function testImagesCanBeReorderedAndDetachedOnUpdate(): void
    {
        Storage::fake('public');

        $gallery = PhotoGallery::factory()->create([
            'title' => 'Галерея'
        ]);

        $image1 = Image::factory()->create();
        $image2 = Image::factory()->create();

        $gallery->images()->attach([$image1->id, $image2->id]);

        $newFile = UploadedFile::fake()->image('new_photo.jpg');

        $response = $this->actingAs($this->admin)->patch(route('admin.gallery.update', $gallery->id), [
            'title' => 'Updated Gallery',
            'key' => $gallery->key,
            'images' => [$image2->id],
            'images_uploads' => [$newFile],
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.gallery.index'));

        $this->assertDatabaseHas('photo_galleries_image', [
            'photo_gallery_id' => $gallery->id,
            'image_id' => $image2->id
        ]);

        $this->assertDatabaseMissing('photo_galleries_image', [
            'photo_gallery_id' => $gallery->id,
            'image_id' => $image1->id
        ]);

        $newImageInDb = Image::query()->where('alt', 'Updated Gallery')->first();
        $this->assertNotNull($newImageInDb);

        $this->assertDatabaseHas('photo_galleries_image', [
            'photo_gallery_id' => $gallery->id,
            'image_id' => $newImageInDb->id
        ]);

        $this->assertCount(2, $gallery->fresh()->images);
    }

    public function testIndexCanSearchGalleries(): void
    {
        PhotoGallery::factory()->create(['title' => 'Summer Party']);
        PhotoGallery::factory()->create(['title' => 'Winter Meetup']);

        $response = $this->actingAs($this->admin)->get(route('admin.gallery.index', [
            'query' => 'Summer',
        ]));

        $response->assertOk();
        $galleries = $response->viewData('gallery');
        $this->assertCount(1, $galleries);
        $this->assertSame('Summer Party', $galleries->first()->title);
    }

    public function testScopesFilterGalleriesCorrectly(): void
    {
        $published = PhotoGallery::factory()->create(['key' => 'first_key', 'publish' => true]);
        $draft = PhotoGallery::factory()->create(['key' => 'second_key', 'publish' => false]);

        $publishedGalleries = PhotoGallery::published()->get();
        $this->assertCount(1, $publishedGalleries);
        $this->assertTrue($publishedGalleries->contains($published));
        $this->assertFalse($publishedGalleries->contains($draft));

        $foundByKey = PhotoGallery::byKey('second_key')->first();
        $this->assertNotNull($foundByKey);
        $this->assertEquals($draft->id, $foundByKey->id);
    }

    public function testGalleryStoreValidationFailsWithoutRequiredFields(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.gallery.store'), [
            'title' => '',
            'key' => '',
        ]);

        $response->assertSessionHasErrors(['title', 'key']);
        $this->assertDatabaseCount('photo_galleries', 0);
    }

    public function testGalleryKeyMustBeUnique(): void
    {
        PhotoGallery::factory()->create(['key' => 'unique_key']);

        $response = $this->actingAs($this->admin)->post(route('admin.gallery.store'), [
            'title' => 'Duplicate Gallery',
            'key' => 'unique_key',
        ]);

        $response->assertSessionHasErrors(['key']);
        $this->assertDatabaseCount('photo_galleries', 1);
    }

    public function testGuestCannotAccessGalleryAdminRoutes(): void
    {
        $gallery = PhotoGallery::factory()->create();

        $this->get(route('admin.gallery.index'))->assertRedirect('/login');
        $this->get(route('admin.gallery.edit', $gallery->id))->assertRedirect('/login');
        $this->post(route('admin.gallery.store'), [])->assertRedirect('/login');
        $this->delete(route('admin.gallery.destroy', $gallery->id))->assertRedirect('/login');
    }
}
