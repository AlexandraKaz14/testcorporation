<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Events\CustomLoginEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')
            ->except('logout');
        $this->middleware('auth')
            ->only('logout');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        if (!$request->has('code') || !$request->has('state')) {

            return redirect()->route('login')
                ->with('error', 'Недопустимый запрос.');
        }

        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                [
                    'email' => $googleUser->getEmail(),
                ],
                [
                    'name' => $googleUser->getName(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => User::ROLE_AUTHOR,
                    'status' => User::STATUS_ACTIVE,
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user);
            $this->afterLogin($user);

            return redirect()->route('profile');

        } catch (\Exception $e) {
            Log::warning('Ошибка входа через Google: ' . $e->getMessage());

            return redirect()->route('login')
                ->with('error', 'Не удалось войти через Google.');
        }
    }

    public function redirectToYandex()
    {
        return Socialite::driver('yandex')->redirect();
    }

    public function handleYandexCallback(Request $request)
    {
        if (!$request->has('code') || !$request->has('state')) {
            return redirect()->route('login')
                ->with('error', 'Недопустимый запрос.');
        }

        try {
            $yandexUser = Socialite::driver('yandex')->user();

            $user = User::firstOrCreate([
                'email' => $yandexUser->email,
            ], [
                'name' => $yandexUser->name,
                'password' => Hash::make(Str::random(24)),
                'role' => User::ROLE_AUTHOR,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]);

            Auth::login($user);
            $this->afterLogin($user);

            return redirect()->route('profile');

        } catch (\Exception $e) {
            Log::warning('Ошибка входа через Yandex: ' . $e->getMessage());

            return redirect()->route('login')
                ->with('error', 'Не удалось войти через Yandex.');
        }
    }

    protected function authenticated(Request $request, $user)
    {
        $this->afterLogin($user);
    }

    private function afterLogin(User $user)
    {
        session()->flash('welcome', 'Добро пожаловать, ' . $user->name . '!');
        event(new CustomLoginEvent($user));
    }
}
