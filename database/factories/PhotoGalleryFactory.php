<?php

namespace Database\Factories;

use App\Models\PhotoGallery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PhotoGallery>
 */
class PhotoGalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->words(3, true);

        return [
            'title' => ucfirst($title),
            'key' => Str::slug($title, '_'),
            'publish'     => $this->faker->boolean(80),
        ];
    }
}
