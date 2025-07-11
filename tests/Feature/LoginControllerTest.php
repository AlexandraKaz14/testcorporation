<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::query()->delete();
    }

    public static function userAttributionProvider(): array
    {
        return [
            [User::ROLE_ADMIN, User::STATUS_ACTIVE, null, true],
            [User::ROLE_MODERATOR, User::STATUS_ACTIVE, null, true],
            [User::ROLE_AUTHOR, User::STATUS_ACTIVE, null, true],
            [User::ROLE_ADMIN, User::STATUS_BLOCKED, null, false],
            [User::ROLE_MODERATOR, User::STATUS_BLOCKED, null, false],
            [User::ROLE_AUTHOR, User::STATUS_BLOCKED, null, false],
            [User::ROLE_ADMIN, User::STATUS_ACTIVE, now(), false],
            [User::ROLE_MODERATOR, User::STATUS_ACTIVE, now(), false],
            [User::ROLE_AUTHOR, User::STATUS_ACTIVE, now(), false],
            [User::ROLE_ADMIN, User::STATUS_BLOCKED, now(), false],
            [User::ROLE_MODERATOR, User::STATUS_BLOCKED, now(), false],
            [User::ROLE_AUTHOR, User::STATUS_BLOCKED, now(), false],
        ];
    }

    #[DataProvider('userAttributionProvider')]
    public function testLogin(string $role, string $status, ?Carbon $deletedAt, bool $isAuth): void
    {
        $credentials = [
            'email' => 'test@test.ru',
            'password' => '12345678',
        ];
        User::factory()->create($credentials + [
            'role' => $role,
            'status' => $status,
            'deleted_at' => $deletedAt,
        ]);
        $response = $this->post('/login', $credentials);
        $this->followRedirects($response);
        $this->assertTrue($isAuth === auth()->check());
    }

    public function testLoginPage()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testAuthenticatedUserRedirectHomePage()
    {
        $credentials = [
            'email' => 'test@test.ru',
            'password' => '12345678',
        ];
        User::factory()->create($credentials);
        $response = $this->post('/login', $credentials);
        $response->assertRedirect('/profile');
    }

    public function testAuthenticatedUser()
    {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => '123456789a',
        ]);
        $response = $this->post('/login', [
            'email' => 'test@gmail.com',
            'password' => '123456789a',
        ]);
        $response->assertRedirect('profile');
        $this->assertAuthenticatedAs($user);
    }

    public function testNotAuthenticatedUser()
    {
        $user = User::factory()->create([
            'email' => 'test1@gmail.com',
            'password' => '123456789a',
        ]);
        $response = $this->post('/login', [
            'email' => 'test2@gmail.com',
            'password' => '123456789a',
        ]);
        $this->assertGuest();
    }

    public function testRedirectToYandex()
    {
        $response = $this->get(url('auth/yandex'));
        $response->assertRedirect();
    }

    public function testYandexCallbackAndLogin()
    {

        $mockedYandexUser = \Mockery::mock(\Laravel\Socialite\Two\User::class);
        $mockedYandexUser->shouldReceive('getEmail')
            ->andReturn('user@example.com');
        $mockedYandexUser->shouldReceive('getName')
            ->andReturn('Test User');
        $mockedYandexUser->email = 'user@example.com';
        $mockedYandexUser->name = 'Test User';

        Socialite::shouldReceive('driver')->andReturnSelf();
        Socialite::shouldReceive('user')->andReturn($mockedYandexUser);

        $response = $this->get(url('auth/yandex/callback?code=fake-code&state=fake-state'));

        $user = User::where('email', 'user@example.com')->first();
        $this->assertNotNull($user, 'Пользователь не был создан.');
        $this->assertEquals('Test User', $user->name);

        $this->assertTrue(Auth::check(), 'Пользователь не авторизован.');

        $response->assertRedirect(route('profile'));
    }

    public function testRedirectToGoogle()
    {
        $response = $this->get(url('auth/google'));
        $response->assertRedirect();
    }

    public function testGoogleCallbackAndLogin()
    {
        $mockedGoogleUser = \Mockery::mock(\Laravel\Socialite\Two\User::class);
        $mockedGoogleUser->shouldReceive('getEmail')
            ->andReturn('user1@example.com');
        $mockedGoogleUser->shouldReceive('getName')
            ->andReturn('Test User');
        $mockedGoogleUser->email = 'user1@example.com';
        $mockedGoogleUser->name = 'Test User';

        Socialite::shouldReceive('driver')->andReturnSelf();
        Socialite::shouldReceive('user')->andReturn($mockedGoogleUser);

        $response = $this->get(url('auth/google/callback?code=fake-code&state=fake-state'));

        $user = User::where('email', 'user1@example.com')->first();
        $this->assertNotNull($user, 'Пользователь не был создан.');
        $this->assertEquals('Test User', $user->name);

        $this->assertTrue(Auth::check(), 'Пользователь не авторизован.');
        $response->assertRedirect(route('profile'));
    }
}
