<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\PhotoGallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotoGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PhotoGallery::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $mainSlider = PhotoGallery::factory()->create([
            'title' => 'Головний слайдер',
            'key' => 'main_slider',
        ]);

        $pageSlider = PhotoGallery::factory()->create([
            'title' => 'Слайдер на сторінці галерея',
            'key' => 'page_gallery',
        ]);

        $mainImages = Image::factory()->count(5)->create();
        $mainSlider->images()->attach($mainImages->pluck('id')->toArray());

        $pageImages = Image::factory()->count(12)->create();
        $pageSlider->images()->attach($pageImages->pluck('id')->toArray());
    }
}
