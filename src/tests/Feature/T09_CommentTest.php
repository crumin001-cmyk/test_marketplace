<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T09_CommentTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function ログイン済みのユーザーはコメントを送信できる()
    {
        // Arrange
        // 1. ユーザーにログインする
        $user = User::factory()->create();

        // 商品出品者
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);


        // Act
        // 2. コメントを入力する
        // 3. コメントボタンを押す
        $response = $this->actingAs($user)
            ->post(route('items.comment', [
                'item_id' => $item->id,
            ]), [
                'content' => 'とても良い商品ですね',
            ]);


        // Assert
        $response->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'とても良い商品ですね',
        ]);
    }



    /** @test */
    public function ログイン前のユーザーはコメントを送信できない()
    {
        // Arrange
        // 1. コメントを入力する
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);


        // Act
        // 2. コメントボタンを押す
        $response = $this->post(route('items.comment', [
            'item_id' => $item->id,
        ]), [
            'content' => 'コメントです',
        ]);


        // Assert
        $response->assertRedirect(route('login'));

        $this->assertDatabaseMissing('comments', [
            'content' => 'コメントです',
        ]);
    }



    /** @test */
    public function コメントが入力されていない場合バリデーションメッセージが表示される()
    {
        // Arrange
        // 1. ユーザーにログインする
        $user = User::factory()->create();

        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);


        // Act
        // 2. コメント欄を空のまま
        // 3. コメントボタンを押す
        $response = $this->actingAs($user)
            ->post(route('items.comment', [
                'item_id' => $item->id,
            ]), [
                'content' => '',
            ]);


        // Assert
        $response->assertSessionHasErrors('content');
    }



    /** @test */
    public function コメントが255字以上の場合バリデーションメッセージが表示される()
    {
        // Arrange
        // 1. ユーザーにログインする
        $user = User::factory()->create();

        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);


        // Act
        // 2. 255文字以上のコメントを入力する
        // 3. コメントボタンを押す
        $response = $this->actingAs($user)
            ->post(route('items.comment', [
                'item_id' => $item->id,
            ]), [
                'content' => str_repeat('あ', 256),
            ]);


        // Assert
        $response->assertSessionHasErrors('content');
    }
}
