<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Test;
use App\Models\User;
use App\Notifications\TestApprovedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdatePassword(): void
    {
        $user = User::factory()->create([
            'name' => 'Ivan',
            'email' => 'ivan@gmail.com',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);
        $this->actingAs($user);

        $updatePasswordData = [
            'current_password' => 'password',
            'new_password' => 'password2',
            'new_password_confirmation' => 'password2',
        ];

        $this->patch(route('profile.update-password'), $updatePasswordData)
            ->assertRedirect('/profile')
            ->assertSessionHas('success', 'Пароль успешно обновлен');

    }

    public function testIncorrectPassword()
    {
        $user = User::factory()->create([
            'name' => 'Ivan',
            'email' => 'ivan@gmail.com',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);
        $this->actingAs($user);

        $incorrectData = [
            'current_password' => 'password123',
            'new_password' => 'password2',
            'new_password_confirmation' => 'password2',
        ];

        $this->patch(route('profile.update-password'), $incorrectData)
            ->assertSessionHasErrors('current_password');
    }

    public function testOpenPageInstruction()
    {
        $this->loginByAdmin();
        $response = $this->get(route('instruction'));
        $response->assertStatus(200);
    }

    public function testShowNotifications()
    {
        $user = User::factory()->create([
            'name' => 'Ivan',
            'email' => 'ivan@gmail.com',
            'password' => 'password',
            'role' => User::ROLE_AUTHOR,
            'status' => User::STATUS_ACTIVE,
        ]);
        $test = Test::factory()->create([
            'title' => 'Мой тест',
            'slug' => 'my-test',
        ]);
        $notification = DatabaseNotification::query()->create([
            'id' => Str::uuid()->toString(),
            'type' => TestApprovedNotification::class,
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'data' => [
                'message' => "Ваш тест '{$test->title}' успешно опубликован!",
                'test_url' => route('player.open', $test->slug),
            ],
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->get(route('profile.notifications'));

        $response->assertStatus(200);

        $response->assertViewHas('unreadNotifications', function ($notifications) use ($notification) {
            return $notifications->contains($notification);
        });

        $response->assertViewIs('admin.profiles.notifications');
    }
}
