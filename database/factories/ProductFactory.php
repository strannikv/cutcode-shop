<?php

namespace Database\Factories;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'thumbnail' => $this->faker->fixturesImage('products', 'images/products'),
            'price' => $this->faker->numberBetween(1000, 100000),
            'on_home_page' => $this->faker->boolean(40),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}
