<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::create([
            'name' => 'Rolax'
        ]);

        Brand::create([
            'name' => '西芝'
        ]);

        Brand::create([
            'name' => 'Starbacks'
        ]);

        Brand::create([
            'name' => 'なし'
        ]);

        Brand::create([
            'name' => '未設定'
        ]);
    }
}
