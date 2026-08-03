<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),

            'name' => fake()->word(),

            'description' => fake()->sentence(),

            'price' => fake()->numberBetween(100, 10000),

            // itemsテーブルがbrandカラムの場合
            'brand' => fake()->word(),

            'condition_id' => Condition::factory(),

            'image_path' => 'upload_items/test.jpg',

        ];
    }
}
