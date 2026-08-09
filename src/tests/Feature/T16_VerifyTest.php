<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class T16_VerifyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 会員登録後、認証メールが送信される()
    {
        // Arrange
        Notification::fake();


        // Act
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $user = User::where('email', 'test@example.com')->first();

        // Assert
        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );
    }



    /** @test */
    public function メール認証誘導画面で「認証はこちらから」ボタンを押下するとメール認証サイトに遷移する()
    {
        // Arrange
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);


        // Act
        $response = $this->actingAs($user)
            ->get('/email/verify');


        // Assert
        $response->assertStatus(200);

        $response->assertSee('認証はこちらから');
    }



    /** @test */
    public function メール認証サイトのメール認証を完了するとプロフィール設定画面に遷移する()
    {
        // Arrange
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);


        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );


        // Act
        $response = $this->actingAs($user)
            ->get($verificationUrl);


        // Assert
        $this->assertNotNull(
            $user->fresh()->email_verified_at
        );

        $response->assertRedirect('/firstlogin');
    }
}
