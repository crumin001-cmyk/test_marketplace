<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Condition;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Condition::create([
            'name' => '良好',
            'sort_order' => 1,
        ]);

        Condition::create([
            'name' => '目立った傷や汚れなし',
            'sort_order' => 2,
        ]);

        Condition::create([
            'name' =>'やや傷や汚れあり',
            'sort_order' => 3,
        ]);

        Condition::create([
            'name' =>'状態が悪い',
            'sort_order' => 4,
        ]);
    }
}
