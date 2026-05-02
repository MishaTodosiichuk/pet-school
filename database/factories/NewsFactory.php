<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->realText(50);

        return [
            'title'       => $title,
            'description' => $this->faker->realText(500),
            'slug'        => Str::slug($title),
            'views_count' => rand(0, 100),
            'publish'     => $this->faker->boolean(80),
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
