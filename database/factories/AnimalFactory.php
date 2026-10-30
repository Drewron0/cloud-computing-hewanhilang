<?php

namespace Database\Factories;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $speciesList = ['kucing', 'anjing', 'burung', 'reptil', 'mamalia'];

        return [
            'type' => 'lost',
            'title' => fake()->words(2, true),
            'species' => fake()->randomElement($speciesList),
            'city' => 'Surabaya',
            'address_detail' => fake()->streetName(),
            'identification_code' => fake()->optional()->bothify('REG-####-????'),
            'reward_or_fee' => 'Rp '.number_format(fake()->numberBetween(100, 2000) * 1000, 0, ',', '.'),
            'district' => fake()->randomElement(['gubeng', 'wonokromo', 'sukolilo', 'rungkut']),
            'district_label' => fake()->randomElement(['Gubeng, Surabaya', 'Wonokromo, Surabaya', 'Sukolilo, Surabaya']),
            'radius_km' => fake()->optional()->numberBetween(1, 10),
            'contact_phone' => fake()->numerify('08##########'),
            'email' => fake()->safeEmail(),
            'description' => fake()->paragraph(),
            'photo_path' => null,
            'map_x' => fake()->numberBetween(20, 80),
            'map_y' => fake()->numberBetween(20, 80),
        ];
    }
}
