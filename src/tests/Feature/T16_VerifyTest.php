<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;
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
    public function 会員登録後認証メールが送信される()
    {
        // Arrange
        Mail::fake();


        // Act
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);


        // Assert
        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        Mail::assertSent(\Illuminate\Auth\Notifications\VerifyEmail::class);
    }



    /** @test */
    public function メール認証誘導画面で認証はこちらからを押下すると認証メールサイトに遷移する()
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
