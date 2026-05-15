<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code_edrpou'      => $this->faker->numerify('########'),
            'zip_code'         => $this->faker->postcode(),
            'address'          => $this->faker->address(),
            'schedule'         => 'Пн-Пт: 08:00 - 17:00',
            'email'            => $this->faker->unique()->safeEmail(),
            'phone_number'     => $this->faker->phoneNumber(),
            'head_institution' => $this->faker->name('male'),
        ];
    }
}
