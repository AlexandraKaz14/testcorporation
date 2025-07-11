<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testResetPassword()
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'test@mail.ru',
            'password' => 'password',
        ]);

        $response = $this->get('/password/reset');
        $response->assertStatus(200);

        $response = $this->post('/password/email', [
            'email' => 'test@mail.ru',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/password/reset');
        Notification::assertSentTo($user, ResetPassword::class);
        $notification = Notification::sent($user, ResetPassword::class)->first();

        $url = $notification->toMail($user)
            ->actionUrl;

        $this->get($url)
            ->assertStatus(200);

        $response = $this->post('/password/reset', [
            'email' => 'test@mail.ru',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'token' => $notification->token,
        ]);
        $response->assertStatus(302);
        $user->refresh();
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('password123', $user->password));
    }
}
