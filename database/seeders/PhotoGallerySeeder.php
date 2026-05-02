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

        PhotoGallery::factory()
            ->count(5)
            ->create()
            ->each(function ($gallery) {
                $images = Image::factory()->count(fake()->numberBetween(3, 8))->create();

                $gallery->images()->attach(
                    $images->pluck('id')->mapWithKeys(function ($id, $index) {
                        return [$id => ['sort_order' => $index]];
                    })->all()
                );
            });

        $mainSlider = PhotoGallery::factory()->create([
            'title' => 'Головний слайдер',
            'key' => 'main_slider',
        ]);

        $mainImages = Image::factory()->count(3)->create();
        $mainSlider->images()->attach($mainImages->pluck('id')->toArray());
    }
}
