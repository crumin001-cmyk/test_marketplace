<?php

namespace Tests\Feature;

use Database\Seeders\CategorySeeder;
use Database\Seeders\ConditionSeeder;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class T07_ItemDetailsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ConditionSeeder::class);
        $this->seed(CategorySeeder::class);
    }
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 必要な情報が表示される()
    {
        // Arrange
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '商品詳細',
            'description' => '商品説明',
            'price' => 1000,
        ]);

        // Act
        $response = $this->get(route('items.show', $item));

        // Assert
        $response->assertStatus(200);
        $response->assertSee('商品詳細');
        $response->assertSee('商品説明');
        $response->assertSee('1,000');
    }


    /** @test */
    public function 複数選択されたカテゴリが表示されている()
    {
        // Arrange
        $user = User::factory()->create();

        $category1 = Category::where('name', 'ファッション')->first();

        $category2 = Category::where('name', 'メンズ')->first();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'カテゴリテスト商品',
        ]);

        $item->categories()->attach([
            $category1->id,
            $category2->id,
        ]);


        // Act
        $response = $this->get(route('items.show', $item));


        // Assert
        $response->assertStatus(200);
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }
}
