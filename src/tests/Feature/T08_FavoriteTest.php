<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T08_FavoriteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function いいねした商品だけが表示される()
    {
        // Arrange
        $user = User::factory()->create();

        $favoriteItem = Item::factory()->create([
            'name' => 'いいねした商品',
        ]);

        $notFavoriteItem = Item::factory()->create([
            'name' => 'いいねしていない商品',
        ]);


        $user->favoriteItems()->attach($favoriteItem->id);


        // Act
        $response = $this->actingAs($user)
            ->get(route('items.index', [
                'tab' => 'mylist',
            ]));


        // Assert
        $response->assertStatus(200);

        $response->assertSee('いいねした商品');

        $response->assertDontSee('いいねしていない商品');
    }



    /** @test */
    public function 購入済み商品はSoldと表示される()
    {
        // Arrange
        $user = User::factory()->create();

        Item::factory()->create([
            'name' => '購入済み商品',
            'sold_at' => now(),
        ]);


        // Act
        $response = $this->actingAs($user)
            ->get(route('items.index', [
                'tab' => 'mylist',
            ]));


        // Assert
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }


    /** @test */
    public function いいねアイコンを押下することによっていいね登録できる()
    {
        // Arrange
        $user = User::factory()->create();

        $item = Item::factory()->create();


        // Act
        // 商品詳細ページを開く
        $this->actingAs($user)
            ->get(route('items.show', $item));


        // いいねアイコンを押す
        $response = $this->post(route('favorite.store', $item));


        // Assert
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }



    /** @test */
    public function 追加済みのアイコンは色が変化する()
    {
        // Arrange
        $user = User::factory()->create();

        $item = Item::factory()->create();


        // Act
        $this->actingAs($user)
            ->post(route('favorite.store', $item));


        $response = $this->actingAs($user)
            ->get(route('items.show', $item));


        // Assert
        $response->assertStatus(200);
        $response->assertSee('favorite');
    }



    /** @test */
    public function 再度いいねアイコンを押下することによっていいね解除できる()
    {
        // Arrange
        $user = User::factory()->create();

        $item = Item::factory()->create();


        // 初回いいね
        $user->favoriteItems()->attach($item->id);


        // Act
        // 商品詳細ページから再度押下
        $response = $this->actingAs($user)
            ->delete(route('favorite.destroy', $item));


        // Assert
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }




    /** @test */
    public function 未認証の場合はいいねできない()
    {
        // Arrange
        $item = Item::factory()->create();


        // Act
        $response = $this->get(route('items.index', [
            'tab' => 'mylist',
        ]));


        // Assert
        $response->assertRedirect(route('login'));
    }
}
