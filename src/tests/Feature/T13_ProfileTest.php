<?php

namespace Tests\Feature;

use Database\Seeders\ConditionSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T13_ProfileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ConditionSeeder::class);
    }
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）()
    {
        // Arrange
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'image' => 'profile/test.png',
        ]);


        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品',
        ]);


        $buyItem = Item::factory()->create([
            'user_id' => User::factory()->create()->id,
            'name' => '購入商品',
        ]);


        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $buyItem->id,
            'postal_code' => '123-4567',
            'address' => '東京都',
            'payment_method' => 'コンビニ払い',
        ]);


        // Act
        $response = $this->actingAs($user)
            ->get(route('mypage', [
                'page' => 'sell',
            ]));

        // Assert
        $response->assertStatus(200);

        $response->assertSee('テストユーザー');

        $response->assertSee('profile/test.png');

        $response->assertSee('出品商品');

        // 購入商品タブを開く
        $response = $this->actingAs($user)
            ->get(route('mypage', [
                'page' => 'buy',
            ]));
        // Assert
        $response->assertStatus(200);
        // 購入商品
        $response->assertSee('購入商品');
    }
}
