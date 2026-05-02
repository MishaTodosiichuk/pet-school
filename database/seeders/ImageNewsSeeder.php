<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = News::all();
        $images = Image::all();

        if ($images->isEmpty()) {
            $this->command->warn('Таблиця зображень порожня. Спочатку запустіть ImageSeeder.');
            return;
        }

        foreach ($news as $item) {
            $randomImages = $images->random(rand(1, 5))->pluck('id');

            $item->images()->attach($randomImages);
        }
    }
}
