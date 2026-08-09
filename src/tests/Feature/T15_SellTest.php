<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ConditionSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class T15_SellTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CategorySeeder::class);
        $this->seed(ConditionSeeder::class);
    }
    use RefreshDatabase;

    /** @test */
    public function 商品出品画面にて必要な情報が保存できること()
    {
        // Arrange
        Storage::fake('public');

        $user = User::factory()->create();

        $category = Category::first();

        $condition = Condition::first();


        // Act
        $response = $this->actingAs($user)
            ->post(route('sell.store'), [
                'image' => UploadedFile::fake()
                    ->create('test.jpeg', 100, 'image/jpeg'),

                'name' => 'テスト商品',

                'description' => '商品の説明です',

                'price' => 1000,

                'brand' => 'Nike',

                'condition_id' => $condition->id,

                'categories' => [
                    $category->id
                ],
            ]);


        // Assert
        $response->assertRedirect(
            route('mypage', ['page' => 'sell'])
        );


        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'description' => '商品の説明です',
            'price' => 1000,
            'brand' => 'Nike',
            'condition_id' => $condition->id,
        ]);


        $this->assertDatabaseHas('category_item', [
            'category_id' => $category->id,
        ]);
    }
}
