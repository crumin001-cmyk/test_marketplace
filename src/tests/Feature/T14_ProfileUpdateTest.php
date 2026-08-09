<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T14_ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）()
    {
        // Arrange
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'image' => 'profile/test.png',
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

        $response->assertSee('123-4567');

        $response->assertSee('東京都渋谷区');

        $response->assertSee('テストビル');
    }
}
