<?php

namespace Tests\Feature;

use Database\Seeders\ConditionSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T10_PurchaseTest extends TestCase
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
    public function 「購入する」ボタンを押下すると購入が完了する()
    {
        // Arrange
        $buyer = User::factory()->create();

        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
        ]);


        // Act
        $response = $this->actingAs($buyer)
            ->post(route('purchase.store', [
                'item_id' => $item->id,
            ]), [
                'payment_method' => 'コンビニ払い',
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区1-1',
                'building' => 'テストビル',
            ]);


        // Assert
        $response->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);
    }



    /** @test */
    public function 購入した商品は商品一覧画面にてsoldと表示される()
    {
        // Arrange
        $buyer = User::factory()->create();

        $seller = User::factory()->create();


        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);


        // Act
        $this->actingAs($buyer)
            ->post(route('purchase.store', [
                'item_id' => $item->id,
            ]), [
                'payment_method' => 'カード払い',
                'postal_code' => '123-4567',
                'address' => '東京都',
            ]);


        // Assert
        $item->refresh();

        $this->assertNotNull($item->sold_at);
    }



    /** @test */
    public function プロフィール購入した商品一覧に追加されている()
    {
        // Arrange
        $buyer = User::factory()->create();

        $seller = User::factory()->create();


        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);


        Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'postal_code' => '123-4567',
            'address' => '東京都',
            'payment_method' => 'コンビニ払い',
        ]);


        // Act
        $response = $this->actingAs($buyer)
            ->get(route('mypage', [
                'page' => 'buy',
            ]));


        // Assert
        $response->assertStatus(200);
        $response->assertSee($item->name);
    }
}
