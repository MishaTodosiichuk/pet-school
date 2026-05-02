<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Image::class;

    public function definition(): array
    {
        $width = $this->faker->numberBetween(640, 1920);
        $height = $this->faker->numberBetween(480, 1080);

        $mimes = ['image/jpeg', 'image/png', 'image/webp'];

        return [
            'url' => "https://picsum.photos/seed/" . $this->faker->uuid . "/{$width}/{$height}",
            'alt' => $this->faker->sentence(3),
            'disk' => $this->faker->randomElement(['public', 's3', 'local']),
            'mime_type' => $this->faker->randomElement($mimes),
            'size' => $this->faker->numberBetween(50000, 2000000),
            'width' => $width,
            'height' => $height,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
