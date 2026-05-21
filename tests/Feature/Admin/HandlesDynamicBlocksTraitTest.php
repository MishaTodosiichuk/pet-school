<?php

namespace Tests\Feature\Admin;

use App\Models\Page;
use App\Models\PageBlock;
use App\Traits\HandlesDynamicBlocksTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HandlesDynamicBlocksTraitTest extends TestCase
{
    use RefreshDatabase;

    private object $traitDummy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->traitDummy = new class {
            use HandlesDynamicBlocksTrait {
                syncBlocksWithDelete as public;
            }
        };
    }

    public function test_it_creates_new_blocks_with_uploaded_files_and_sort_order(): void
    {
        Storage::fake('public');

        $page = Page::factory()->create();
        $file = UploadedFile::fake()->image('block_image.jpg');

        $data = [
            'blocks' => [
                [
                    'title' => 'Перший блок',
                    'text' => 'Текст першого блоку',
                    'file' => $file,
                    'publish' => true,
                    'sort_order' => 10,
                ],
                [
                    'title' => 'Другий блок',
                    'text' => 'Текст другого блоку',
                    'publish' => false,
                ]
            ]
        ];

        $this->traitDummy->syncBlocksWithDelete($page, $data);

        $this->assertDatabaseCount('page_blocks', 2);

        $firstBlock = PageBlock::where('title', 'Перший блок')->first();
        $this->assertNotNull($firstBlock);
        $this->assertEquals($page->id, $firstBlock->page_id);
        $this->assertEquals('Текст першого блоку', $firstBlock->text);
        $this->assertTrue($firstBlock->publish);
        $this->assertEquals(10, $firstBlock->sort_order);
        $this->assertNotNull($firstBlock->file);

        Storage::disk('public')->assertExists($firstBlock->file);

        $secondBlock = PageBlock::query()->where('title', 'Другий блок')->first();
        $this->assertNotNull($secondBlock);
        $this->assertNull($secondBlock->file);
        $this->assertFalse($secondBlock->publish);
        $this->assertEquals(1, $secondBlock->sort_order);
    }

    public function test_it_deletes_old_file_from_storage_if_block_is_removed(): void
    {
        Storage::fake('public');

        $page = Page::factory()->create();

        $oldFilePath = 'page-blocks/old_image.jpg';
        Storage::disk('public')->put($oldFilePath, 'fake content');

        PageBlock::query()->create([
            'page_id' => $page->id,
            'title' => 'Старий блок',
            'file' => $oldFilePath,
            'publish' => true,
            'sort_order' => 0,
        ]);

        Storage::disk('public')->assertExists($oldFilePath);

        $data = ['blocks' => []];

        $this->traitDummy->syncBlocksWithDelete($page, $data);

        $this->assertDatabaseCount('page_blocks', 0);

        Storage::disk('public')->assertMissing($oldFilePath);
    }

    public function test_it_keeps_old_file_if_block_remains_unchanged(): void
    {
        Storage::fake('public');

        $page = Page::factory()->create();
        $filePath = 'page-blocks/keep_me.jpg';
        Storage::disk('public')->put($filePath, 'fake content');

        PageBlock::query()->create([
            'page_id' => $page->id,
            'title' => 'Незмінний блок',
            'file' => $filePath,
            'publish' => true,
            'sort_order' => 0,
        ]);

        $data = [
            'blocks' => [
                [
                    'title' => 'Оновлена назва блоку',
                    'old_file' => $filePath,
                    'publish' => true,
                    'sort_order' => 0,
                ]
            ]
        ];

        $this->traitDummy->syncBlocksWithDelete($page, $data);
        $this->assertDatabaseCount('page_blocks', 1);

        $currentBlock = PageBlock::first();
        $this->assertEquals('Оновлена назва блоку', $currentBlock->title);
        $this->assertEquals($filePath, $currentBlock->file);

        Storage::disk('public')->assertExists($filePath);
    }

    public function test_it_deletes_old_file_and_stores_new_one_on_file_replacement(): void
    {
        Storage::fake('public');

        $page = Page::factory()->create();

        $oldFilePath = 'page-blocks/to_be_replaced.jpg';
        Storage::disk('public')->put($oldFilePath, 'old content');

        PageBlock::query()->create([
            'page_id' => $page->id,
            'title' => 'Блок із заміною фото',
            'file' => $oldFilePath,
            'publish' => true,
            'sort_order' => 0,
        ]);

        $newFile = UploadedFile::fake()->image('fresh_load.png');
        $data = [
            'blocks' => [
                [
                    'title' => 'Блок із заміною фото',
                    'old_file' => $oldFilePath,
                    'file' => $newFile,
                    'publish' => true,
                    'sort_order' => 0,
                ]
            ]
        ];

        $this->traitDummy->syncBlocksWithDelete($page, $data);

        $currentBlock = PageBlock::query()->first();

        Storage::disk('public')->assertMissing($oldFilePath);

        $this->assertNotNull($currentBlock->file);
        $this->assertNotEquals($oldFilePath, $currentBlock->file);
        Storage::disk('public')->assertExists($currentBlock->file);
    }
}
