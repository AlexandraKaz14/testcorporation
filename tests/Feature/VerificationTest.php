<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    use RefreshDatabase;

    public function testVerificationEmail()
    {
        Notification::fake();

        $user = [
            'name' => 'Ivan Petrovich Petrov',
            'email' => 'Petrovich123@gmai.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ];

        $response = $this->post('/register', $user);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'email_verified_at' => null,
        ]);
        $user = User::where('email', 'Petrovich123@gmai.com')->first();

        Notification::assertSentTo($user, CustomVerifyEmail::class);
        $notification = Notification::sent($user, CustomVerifyEmail::class)->first();

        $url = $notification->toMail($user)
            ->actionUrl;
        $response = $this->get($url);
        $response->assertStatus(302);
        $user->refresh();
        $this->assertDatabaseHas('users', [
            'email' => 'Petrovich123@gmai.com',
        ]);
        $this->assertNotNull($user->email_verified_at);

    }
}
