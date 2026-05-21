<?php

namespace Tests\Feature\Admin;

use App\Models\Menu;
use App\Models\Page;
use App\Traits\Managers\HasRelationFieldsTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HasRelationFieldsTraitTest extends TestCase
{
    use RefreshDatabase;

    private object $traitDummy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->traitDummy = new class {
            use HasRelationFieldsTrait {
                getOptionsFromRelation as public;
                getRelationField as public;
            }
        };
    }

    public function test_it_returns_empty_collection_if_relation_method_does_not_exist(): void
    {
        $page = Page::factory()->create();

        $options = $this->traitDummy->getOptionsFromRelation($page, 'nonExistentRelation');

        $this->assertTrue($options->isEmpty());
    }

    public function test_it_generates_options_for_relation_with_parent_id_prefix(): void
    {
        $parentMenu = Menu::factory()->create([
            'title' => 'Головна',
            'parent_id' => null
        ]);

        $childMenu = Menu::factory()->create([
            'title' => 'Про нас',
            'parent_id' => $parentMenu->id
        ]);

        $newMenu = new Menu();

        $options = $this->traitDummy->getOptionsFromRelation($newMenu, 'children');

        $this->assertCount(2, $options);

        $parentOption = $options->firstWhere('id', $parentMenu->id);
        $childOption = $options->firstWhere('id', $childMenu->id);

        $this->assertEquals("{$parentMenu->id} | Головна", $parentOption->display_name);
        $this->assertEquals("_ {$childMenu->id} | Про нас", $childOption->display_name);
    }

    public function test_it_excludes_self_from_options_when_editing_existing_model_of_same_type(): void
    {
        $menu1 = Menu::factory()->create(['title' => 'Меню 1']);
        $menu2 = Menu::factory()->create(['title' => 'Меню 2']);

        $options = $this->traitDummy->getOptionsFromRelation($menu1, 'children');

        $this->assertCount(1, $options);
        $this->assertFalse($options->contains('id', $menu1->id));
        $this->assertTrue($options->contains('id', $menu2->id));
    }

    public function test_it_builds_single_relation_field_config_correctly(): void
    {
        $page = Page::factory()->create(['title' => 'Контакти']);

        $menu = Menu::factory()->create([
            'page_id' => $page->id,
            'title' => 'Контакти в меню'
        ]);

        $field = $this->traitDummy->getRelationField($menu, 'page', 'Оберіть сторінку');

        $this->assertEquals('select', $field['type']);
        $this->assertEquals('Оберіть сторінку', $field['label']);
        $this->assertEquals('page_id', $field['name']);
        $this->assertFalse($field['multiple']);
        $this->assertEquals('side', $field['column']);
        $this->assertEquals($page->id, $field['value']);
        $this->assertArrayHasKey('options', $field);
    }

    public function test_it_builds_multiple_relation_field_config_for_has_many(): void
    {
        $page = Page::factory()->create();

        $menu1 = Menu::factory()->create(['page_id' => $page->id]);
        $menu2 = Menu::factory()->create(['page_id' => $page->id]);

        $field = $this->traitDummy->getRelationField($page, 'menus', 'Пункти меню', 'title', 'select', 'main');

        $this->assertEquals('select', $field['type']);
        $this->assertEquals('Пункти меню', $field['label']);
        $this->assertEquals('menus[]', $field['name']);
        $this->assertTrue($field['multiple']);
        $this->assertEquals('main', $field['column']);
        $this->assertEquals([$menu1->id, $menu2->id], $field['value']);
    }

    public function test_it_appends_images_data_if_type_is_images_and_model_exists(): void
    {
        $newsClass = 'App\Models\News';
        $imageClass = 'App\Models\Image';

        if (!class_exists($newsClass) || !class_exists($imageClass)) {
            $this->markTestSkipped('Моделі News або Image відсутні для тестування картиночного типу.');
        }

        $news = $newsClass::factory()->create(['title' => 'Новина дня']);
        $image = $imageClass::factory()->create([
            'url' => '/storage/uploads/test.jpg',
            'alt' => 'Альтернативний текст'
        ]);

        $news->images()->attach($image->id);

        $field = $this->traitDummy->getRelationField($news, 'images', 'Галерея новин', 'title', 'images');

        $this->assertEquals('images', $field['type']);
        $this->assertArrayHasKey('images', $field);
        $this->assertCount(1, $field['images']);
        $this->assertEquals($image->id, $field['images'][0]['id']);
        $this->assertEquals('/storage/uploads/test.jpg', $field['images'][0]['url']);
        $this->assertEquals('Альтернативний текст', $field['images'][0]['alt']);
    }
}
