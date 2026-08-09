<?php

namespace Tests\Feature;

use Database\Seeders\ConditionSeeder;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T08_FavoriteTest extends TestCase
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
}
