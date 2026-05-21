<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            ['title' => 'Головна сторінка'],
            ['title' => 'Про нас'],
            ['title' => 'Контакти закладу'],
            ['title' => 'Послуги та тарифи'],
            ['title' => 'Політика конфіденційності'],
        ];

        foreach ($pages as $pageData) {
            Page::query()->updateOrCreate(
                ['title' => $pageData['title']],
                $pageData
            );
        }

        if (app()->environment('local', 'testing')) {
            Page::factory()->count(10)->create();
        }
    }
}
