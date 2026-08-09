<?php

namespace Tests\Feature;

use Database\Seeders\ConditionSeeder;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T11_PaymentMethodTest extends TestCase
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
    public function 小計画面で変更が反映される()
    {
        // Arrange
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'price' => 5000,
            'user_id' => User::factory()->create()->id,
        ]);


        // Act
        $response = $this->actingAs($user)
            ->get(route('purchase.show', [
                'item_id' => $item->id,
            ]));


        // Assert
        $response->assertStatus(200);
        $response->assertSee('5,000');
    }
}
