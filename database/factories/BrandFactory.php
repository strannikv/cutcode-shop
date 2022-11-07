<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{

    public function definition()
    {
        return [
            'title' => $this->faker->company(),
            'thumbnail' => $this->faker->fixturesImage('products', 'images/brands'),
            'on_home_page' => $this->faker->boolean(40),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}
