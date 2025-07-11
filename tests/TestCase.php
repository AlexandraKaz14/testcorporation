<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    protected $seed = true;

    protected function loginByRole(string $role): User
    {
        $user = User::factory()->create([
            'role' => $role,
            'status' => User::STATUS_ACTIVE,
        ]);
        $this->actingAs($user);

        return Auth::user();
    }

    protected function loginByAdmin(): User
    {
        return $this->loginByRole(User::ROLE_ADMIN);
    }

    protected function loginByModerator(): User
    {
        return $this->loginByRole(User::ROLE_MODERATOR);
    }

    protected function loginByAuthor(): User
    {
        return $this->loginByRole(User::ROLE_AUTHOR);
    }
}
