<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T10_PurchaseTest extends TestCase
{
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



    /** @test */
    public function 小計画面で変更が反映される()
    {
        // Arrange
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'price' => 5000,
            'user_id' => User::factory()->create()->id,
        ]);


        // Act
        $response = $this->actingAs($user)
            ->get(route('purchase.show', [
                'item_id' => $item->id,
            ]));


        // Assert
        $response->assertStatus(200);
        $response->assertSee('5000');
    }



    /** @test */
    public function 送付先住所変更画面にて登録した住所が商品購入画面に反映されている()
    {
        // Arrange
        $user = User::factory()->create();


        $user->update([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
        ]);


        $item = Item::factory()->create([
            'user_id' => User::factory()->create()->id,
        ]);


        // Act
        $response = $this->actingAs($user)
            ->get(route('purchase.show', [
                'item_id' => $item->id,
            ]));


        // Assert
        $response->assertStatus(200);

        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('テストビル');
    }



    /** @test */
    public function 購入した商品に送付先住所が紐づいて登録される()
    {
        // Arrange
        $buyer = User::factory()->create();

        $seller = User::factory()->create();


        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);


        // Act
        $response = $this->actingAs($buyer)
            ->post(route('purchase.store', [
                'item_id' => $item->id,
            ]), [
                'postal_code' => '123-4567',
                'address' => '大阪府大阪市',
                'building' => 'マンション101',
                'payment_method' => 'カード払い',
            ]);


        // Assert
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'user_id' => $buyer->id,
            'postal_code' => '123-4567',
            'address' => '大阪府大阪市',
            'building' => 'マンション101',
        ]);
    }
}
