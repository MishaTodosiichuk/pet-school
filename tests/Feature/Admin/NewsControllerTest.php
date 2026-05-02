<?php

namespace Tests\Feature\Admin;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class NewsControllerTest extends TestCase
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
        News::factory()->create([
            'title' => 'Головне меню',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.news.index'));

        $response->assertOk();
        $response->assertViewIs('admin.pages.news.index');
        $response->assertViewHas(['news', 'tableConfig', 'breadcrumbs']);
    }

    public function testCreatePageIsDisplayed(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.news.create'));

        $response->assertOk();
        $response->assertViewIs('admin.pages.news.create');
        $response->assertViewHas(['breadcrumbs', 'formConfig']);
    }

    public function testNewsCanBeCreated(): void
    {

        $response = $this->actingAs($this->admin)->post(route('admin.news.store'), [
            'title' => 'Footer news',
            'slug' => '',
            'description' => 'Test description',
            'publish' => true,
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseHas('news', [
            'title' => 'Footer news',
            'slug' => 'footer-news',
            'description' => 'Test description',
            'publish' => true,
        ]);
    }

    public function testNewsCanBeUpdated(): void
    {
        $news = News::factory()->create([
            'title' => 'Old title',
            'slug' => 'old-title',
            'publish' => true,
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.news.update', $news->id), [
            'title' => 'New title',
            'slug' => 'new-title',
            'description' => 'Test news description',
            'publish' => false,
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'New title',
            'slug' => 'new-title',
            'description' => 'Test news description',
            'publish' => false,
        ]);
    }

    public function testNewsCanBeDeleted(): void
    {
        $news = News::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.news.destroy', $news));

        $response->assertRedirect(route('admin.news.index'));

        $this->assertSoftDeleted('news', [
            'id' => $news->id,
        ]);
    }

    public function testPublishCanBeUpdated(): void
    {
        $news = News::factory()->create([
            'publish' => false,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.news.publish', $news), [
            'publish' => true,
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'publish' => true,
        ]);
    }

    public function testIndexCanSearchNews(): void
    {
        News::factory()->create([
            'title' => 'Header news',
        ]);

        News::factory()->create([
            'title' => 'Footer news',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.news.index', [
            'query' => 'Header',
        ]));

        $response->assertOk();

        $news = $response->viewData('news');

        $this->assertCount(1, $news);
        $this->assertSame('Header news', $news->first()->title);
    }
    public function testNewsCanBeCreatedWithImage(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('news.jpg');

        $response = $this->actingAs($this->admin)->post(route('admin.news.store'), [
            'title' => 'News with image',
            'slug' => '',
            'description' => 'Test description',
            'publish' => true,
            'images_uploads' => [$file],
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $news = News::query()->where('slug', 'news-with-image')->first();

        $this->assertNotNull($news);

        $this->assertDatabaseCount('images', 1);

        $image = Image::query()->first();

        $this->assertNotNull($image);

        $this->assertDatabaseHas('image_news', [
            'news_id' => $news->id,
            'image_id' => $image->id,
        ]);

        $this->assertCount(1, $news->fresh()->images);

        Storage::disk('public')->assertExists(
            str_replace('/storage/', '', $image->url)
        );
    }

    public function testNewsCanBeUpdatedWithImage(): void
    {
        Storage::fake('public');

        $news = News::factory()->create([
            'title' => 'Old title',
            'slug' => 'old-title',
            'description' => 'Old description',
            'publish' => true,
        ]);

        $file = UploadedFile::fake()->image('updated.jpg');

        $response = $this->actingAs($this->admin)->patch(route('admin.news.update', $news->id), [
            'title' => 'Updated news',
            'slug' => 'updated-news',
            'description' => 'Updated description',
            'publish' => true,
            'images_uploads' => [$file],
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $news->refresh();

        $this->assertDatabaseCount('images', 1);
        $this->assertCount(1, $news->images);

        $image = $news->images()->first();

        $this->assertDatabaseHas('image_news', [
            'news_id' => $news->id,
            'image_id' => $image->id,
        ]);

        Storage::disk('public')->assertExists(
            str_replace('/storage/', '', $image->url)
        );
    }
    public function testExistingImageCanBeAttachedToNews(): void
    {
        Storage::fake('public');

        $image = Image::factory()->create([
            'url' => '/storage/uploads/news/test.jpg',
            'disk' => 'public',
            'mime_type' => 'image/jpeg',
            'size' => 100,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.news.store'), [
            'title' => 'News with existing image',
            'slug' => '',
            'description' => 'Test description',
            'publish' => true,
            'images' => [$image->id],
            'redirect_after' => 'save_and_close',
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $news = News::query()->where('slug', 'news-with-existing-image')->first();

        $this->assertNotNull($news);

        $this->assertDatabaseHas('image_news', [
            'news_id' => $news->id,
            'image_id' => $image->id,
        ]);

        $this->assertCount(1, $news->images);
    }
}
