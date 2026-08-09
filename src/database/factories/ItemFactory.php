<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Item;

class ItemFactory extends Factory
{
    protected $model = Item::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),

            'name' => $this->faker->word(),

            'description' => $this->faker->sentence(),

            'price' => $this->faker->numberBetween(100, 10000),

            // itemsテーブルがbrandカラムの場合
            'brand' => $this->faker->word(),

            'condition_id' => $this->faker->numberBetween(1, 4),

            'image_path' => 'upload_items/test.jpg',

        ];
    }
}
