<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Image::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Image::factory()->count(50)->create();
    }
}
