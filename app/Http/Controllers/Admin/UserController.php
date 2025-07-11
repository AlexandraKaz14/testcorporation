<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable, IndexUserRequest $request)
    {
        return $dataTable
            ->render('admin.users.index', [
                'deletedStatuses' => User::DELETED_STATUSES,
                'startDate' => $request->get('startDate'),
                'endDate' => $request->get('endDate'),
            ]);
    }

    public function create()
    {
        $user = new User();

        return view('admin.users.create', compact('user'));
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);

        return redirect()->route('admin.users.show', $user)
            ->withSuccess('Пользователь создан');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (!$data['password']) {
            unset($data['password']);
        }
        $data['email'] = strtolower($data['email']);
        $user->update($data);
        return redirect()->route('admin.users.show', $user)
            ->withSuccess('Пользователь обновлен');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->withSuccess('Пользователь удален');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->restore();
        return back()->withSuccess('Пользователь восстановлен');
    }

    public function loginAsUser(User $user)
    {
        if (!Auth::check() ||
            auth()
                ->user()
                ->role !== User::ROLE_ADMIN ||
                            $user->status !== User::STATUS_ACTIVE ||
                            $user->trashed()) {
            return back()->withErrors('Доступ запрещен');
        }
        Auth::login($user);

        return redirect()->route('profile')
            ->withSuccess('Вы вошли под пользователем: ' . $user->name);
    }
}
