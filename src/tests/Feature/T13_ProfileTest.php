<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T13_ProfileTest extends TestCase
{
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
            'profile_image' => 'profile/test.png',
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
        ]);


        // Act
        $response = $this->actingAs($user)
            ->get(route('mypage'));


        // Assert
        $response->assertStatus(200);

        $response->assertSee('テストユーザー');

        $response->assertSee('出品商品');

        $response->assertSee('購入商品');
    }



    /** @test */
    public function 変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）()
    {
        // Arrange
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profile/test.png',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
        ]);


        // Act
        $response = $this->actingAs($user)
            ->get(route('profile.edit'));


        // Assert
        $response->assertStatus(200);

        $response->assertSee('テストユーザー');

        $response->assertSeae('123-4567');

        $response->assertSee('東京都渋谷区');

        $response->assertSee('テストビル');
    }



    /** @test */
    public function プロフィール情報を更新できる()
    {
        // Arrange
        $user = User::factory()->create();


        // Act
        $response = $this->actingAs($user)
            ->post(route('profile.update'), [
                'name' => '変更後ユーザー',
                'postal_code' => '987-6543',
                'address' => '大阪府大阪市',
                'building' => '変更ビル',
            ]);


        // Assert
        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '変更後ユーザー',
            'postal_code' => '987-6543',
            'address' => '大阪府大阪市',
            'building' => '変更ビル',
        ]);
    }
}
