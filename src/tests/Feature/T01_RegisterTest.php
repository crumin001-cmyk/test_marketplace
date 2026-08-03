<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class T01_RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function  名前が入力されていない場合、バリデーションメッセージが表示される()
    {
        // Arrange
        $response = $this->get('/register');
        $response->assertStatus(200);
        // Act
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        dd($response->exception->errors());
        // Assert
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function メールアドレスが入力されていない場合、バリデーションメッセージが表示される()
    {
        // Arrange

        // Act
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);


        // Assert
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function パスワードが入力されていない場合、バリデーションメッセージが表示される()
    {
        // Arrange

        // Act
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);
        // Assert
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function パスワードが7文字以下の場合、バリデーションメッセージが表示される()
    {
        // Arrange

        // Act
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        // Assert
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される()
    {
        // Arrange

        // Act
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => 'password',
        ]);

        // Assert
        $response->assertSessionHasErrors('password');
    }
    /** @test */
    public function 全ての項目が入力されている場合、会員情報が登録され、プロフィール設定画面に遷移される()
    {
        // Arrange

        // Act
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Assert
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
        $response->assertRedirect(route('firstLogin'));
    }
}
