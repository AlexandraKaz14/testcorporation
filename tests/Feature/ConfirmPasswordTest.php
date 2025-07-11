<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConfirmPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulPasswordConfirmation(): void
    {
        $user = [
            'password' => '123456789',
        ];
        User::factory()->create($user);

        $response = $this->post('/login', $user);
        $response->assertStatus(302);
        $response = $this->post(route('password.confirm', [
            'password' => '123456789',
        ]));
        $response->assertRedirect();
        $response->assertStatus(302);
    }

    public function testPasswordConfirmationFailed()
    {
        $user = User::factory()->create([
            'password' => 'correct123',
            'status' => User::STATUS_ACTIVE,
        ]);
        $this->actingAs($user);
        $response = $this->post(route('password.confirm', [
            'password' => 'incorrect123',
        ]));
        $response->assertRedirect();
        $response->assertSessionHasErrors('password');
    }
}
