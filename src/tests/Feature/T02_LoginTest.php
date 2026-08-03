<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T02_LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function メールアドレスが入力されていない場合、バリデーションメッセージが表示される()
    {
        // Arrange

        // Act
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        // Assert
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function パスワードが入力されていない場合、バリデーションメッセージが表示される()
    {
        // Arrange

        // Act
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        // Assert
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function 入力情報が間違っている場合、バリデーションメッセージが表示される()
    {
        // Arrange
        // 登録されていない情報を入力する

        // Act
        $response = $this->post('/login', [
            'email' => 'notfound@example.com',
            'password' => 'password',
        ]);

        // Assert
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function 正しい情報が入力された場合、ログイン処理が実行される()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Act
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Assert
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('items.index'));
    }

    /** @test */
    public function ログアウトができる()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)
            ->post('/logout');

        // Assert
        $this->assertGuest();

        $response->assertRedirect('/');
    }
}
