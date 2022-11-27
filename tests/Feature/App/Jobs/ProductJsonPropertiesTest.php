<?php

namespace App\Jobs;

use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Domain\Catalog\Facades\Sorter;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Throwable;

class ProductJsonPropertiesTest extends TestCase
{
    public function test_it_created_json_properties(): void
    {
        $queue = Queue::getFacadeRoot();

        Queue::fake([ProductJsonProperties::class]);

        $properties = PropertyFactory::new()
            ->count(10)
            ->create();

        $product = ProductFactory::new()
            ->hasAttached($properties, function (){
                return ['value' => fake()->word()];
            })
            ->create();

        $this->assertEmpty($product->json_properties);

        Queue::swap($queue);

        ProductJsonProperties::dispatchSync($product);

        $product->refresh();

        $this->assertNotEmpty($product->json_properties);
    }

}
