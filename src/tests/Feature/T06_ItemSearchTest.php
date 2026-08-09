<?php

namespace Tests\Feature;

use Database\Seeders\ConditionSeeder;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T06_ItemSearchTest extends TestCase
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
    public function 「商品名」で部分一致検索ができる()
    {
        // Arrange
        $user = User::factory()->create();

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '黒いバッグ',
        ]);

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '白い靴',
        ]);


        // Act
        $response = $this->get(route('items.index', [
            'keyword' => 'バッグ',
        ]));


        // Assert
        $response->assertStatus(200);

        $response->assertSee('黒いバッグ');

        $response->assertDontSee('白い靴');
    }

    /** @test */
    public function 検索状態がマイリストでも保持されている()
    {
        // Arrange
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => User::factory()->create()->id,
            'name' => '黒いバッグ',
        ]);

        $user->favoriteItems()->attach($item->id);


        // Act
        // 1. ホームページで商品検索
        $response = $this->actingAs($user)
            ->get(route('items.index', [
                'keyword' => 'バッグ',
            ]));


        // 2. 検索結果表示確認
        $response->assertSee('黒いバッグ');


        // 3. マイリストページへ遷移
        $response = $this->actingAs($user)
            ->get(route('items.index', [
                'keyword' => 'バッグ',
                'tab' => 'mylist',
            ]));


        // Assert
        $response->assertStatus(200);
        $response->assertSee('黒いバッグ');
    }
}
