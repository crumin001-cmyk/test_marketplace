<?php

namespace Tests\Feature;

use Database\Seeders\ConditionSeeder;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T05_MylistTest extends TestCase
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
    public function いいねした商品だけが表示される()
    {
        // Arrange
        $user = User::factory()->create();

        $favoriteItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'いいねした商品',
        ]);

        $notFavoriteItem = Item::factory()->create([
            'user_id' => $user->id,
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

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '購入済み商品',
            'sold_at' => now(),
        ]);
        $user->favoriteItems()->attach($item->id);


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
    public function 未認証の場合は何も表示されない()
    {
        // Arrange
        Item::factory()->create([
            'name' => '商品A',
        ]);

        // Act
        // 未認証のままマイリストページを開く
        $response = $this->get(route('items.index', [
            'tab' => 'mylist',
        ]));

        // Assert
        $response->assertStatus(200);
        $response->assertDontSee('商品A');
    }
}
