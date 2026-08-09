<?php

namespace Tests\Feature;

use Database\Seeders\ConditionSeeder;
use Database\Seeders\CategorySeeder;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T04_ItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ConditionSeeder::class);
        $this->seed(CategorySeeder::class);
    }

    /** @test */
    public function 全商品を取得できる()
    {
        // Arrange
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
        ]);

        // Act
        $response = $this->get(route('items.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('items');
        $response->assertSee('テスト商品');
    }


    /** @test */
    public function 購入済み商品は「Sold」と表示される()
    {
        // Arrange
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '購入済み商品',
            'sold_at' => now(),
        ]);

        // Act
        $response = $this->get(route('items.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }


    /** @test */
    public function 自分が出品した商品は表示されない()
    {
        // Arrange
        $user = User::factory()->create();

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品',
        ]);

        Item::factory()->create([
            'user_id' => User::factory()->create()->id,
            'name' => '他人の商品',
        ]);

        // Act
        $response = $this->actingAs($user)
            ->get(route('items.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }
}
