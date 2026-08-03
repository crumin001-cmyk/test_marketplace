<?php

namespace Tests\Feature;

use Database\Seeders\ConditionSeeder;
use Database\Seeders\CategorySeeder;
use App\Models\Category;
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


    /** @test */
    public function 商品詳細ページで必要な情報が表示される()
    {
        // Arrange
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '商品詳細',
            'description' => '商品説明',
            'price' => 1000,
        ]);

        // Act
        $response = $this->get(route('items.show', $item));

        // Assert
        $response->assertStatus(200);
        $response->assertSee('商品詳細');
        $response->assertSee('商品説明');
        $response->assertSee('1000');
    }


    /** @test */
    public function 複数選択されたカテゴリが表示されている()
    {
        // Arrange
        $user = User::factory()->create();

        $category1 = Category::where('name', 'ファッション')->first();

        $category2 = Category::where('name', 'メンズ')->first();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'カテゴリテスト商品',
        ]);

        $item->categories()->attach([
            $category1->id,
            $category2->id,
        ]);


        // Act
        $response = $this->get(route('items.show', $item));


        // Assert
        $response->assertStatus(200);
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }

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
