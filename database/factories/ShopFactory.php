<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{

    protected $model = Shop::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'image' => 'https://picsum.photos/200/300',
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail(),

        ];
    }
}
