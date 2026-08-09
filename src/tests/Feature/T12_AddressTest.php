<?php

namespace Tests\Feature;

use Database\Seeders\ConditionSeeder;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T12_AddressTest extends TestCase
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
