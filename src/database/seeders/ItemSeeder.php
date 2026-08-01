<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $item = Item::create([
            'user_id' => 1,
            'name' => '腕時計',
            'price' => 15000,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image_path' => 'items/Armani+Mens+Clock.jpg',
            'condition_id' => 1,
        ]);

        $item->categories()->attach([5, 12]);

        $item = Item::create([
            'user_id' => 1,
            'name' => 'HDD',
            'price' => 5000,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image_path' => 'items/HDD+Hard+Disk.jpg',
            'condition_id' => 2,
        ]);

        $item->categories()->attach([2, 8]);

        $item = Item::create([
            'user_id' => 1,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'image_path' => 'items/iLoveIMG+d.jpg',
            'condition_id' => 3,
        ]);

        $item->categories()->attach([10]);

        $item = Item::create([
            'user_id' => 1,
            'name' => '革靴',
            'price' => 4000,
            'brand' => null,
            'description' => 'クラシックなデザインの革靴',
            'image_path' => 'items/Leather+Shoes+Product+Photo.jpg',
            'condition_id' => 4,
        ]);

        $item->categories()->attach([1, 5]);

        $item = Item::create([
            'user_id' => 1,
            'name' => 'ノートPC',
            'price' => 45000,
            'brand' => null,
            'description' => '高性能なノートパソコン',
            'image_path' => 'items/Living+Room+Laptop.jpg',
            'condition_id' => 1,
        ]);

        $item->categories()->attach([2]);

        $item = Item::create([
            'user_id' => 1,
            'name' => 'マイク',
            'price' => 8000,
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'image_path' => 'items/Music+Mic+4632231.jpg',
            'condition_id' => 2,
        ]);

        $item->categories()->attach([2, 8]);

        $item = Item::create([
            'user_id' => 1,
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'brand' => null,
            'description' => 'おしゃれなショルダーバッグ',
            'image_path' => 'items/Purse+fashion+pocket.jpg',
            'condition_id' => 3,
        ]);

        $item->categories()->attach([4, 1]);

        $item = Item::create([
            'user_id' => 1,
            'name' => 'タンブラー',
            'price' => 500,
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'image_path' => 'items/Tumbler+souvenir.jpg',
            'condition_id' => 4,
        ]);

        $item->categories()->attach([10, 3]);

        $item = Item::create([
            'user_id' => 1,
            'name' => 'コーヒーミル',
            'price' => 4000,
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image_path' => 'items/Waitress+with+Coffee+Grinder.jpg',
            'condition_id' => 1,
        ]);

        $item->categories()->attach([10, 3]);

        $item = Item::create([
            'user_id' => 1,
            'name' => 'メイクセット',
            'price' => 2500,
            'brand' => null,
            'description' => '便利なメイクアップセット',
            'image_path' => 'items/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'condition_id' => '2',
        ]);

        $item->categories()->attach([6, 4]);
    }
}
