<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Models\User;
use App\Services\ProfileManager;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected ProfileManager $profileManager;

    public function __construct(ProfileManager $profileManager)
    {
        $this->profileManager = $profileManager;
    }

    public function index(User $user)
    {
        $user = auth()
            ->user();
        $data = $this->profileManager->getProfileData($user);
        return view('admin.profiles.index', $data);
    }

    public function updatePassword(UpdateUserPasswordRequest $request)
    {
        $user = auth()
            ->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors([
                    'current_password' => 'Текущий пароль неверный',
                ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile')
            ->with('success', 'Пароль успешно обновлен');
    }

    public function showNotifications()
    {
        $unreadNotifications = auth()
            ->user()
            ->unreadNotifications;

        return view('admin.profiles.notifications', compact('unreadNotifications'));
    }

    public function showPageInstruction()
    {
        return view('admin.profiles.instruction');
    }
}
