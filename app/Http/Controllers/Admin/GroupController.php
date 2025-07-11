<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DataTables\GroupsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use App\Services\GroupManager;

class GroupController extends Controller
{
    public function index(GroupsDataTable $dataTable)
    {
        return $dataTable
            ->render('admin.groups.index');
    }

    public function create()
    {
        return view('admin.groups.create');

    }

    public function store(GroupManager $groupManager, CreateGroupRequest $request)
    {
        $group = $groupManager->upsertGroup(new Group(), $request->validated());

        return redirect()
            ->route('admin.groups.index', $group)
            ->withSuccess('Подборка создана');
    }

    public function show(Group $group)
    {
        return view('admin.groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
        return view('admin.groups.edit', compact('group'));
    }

    public function update(GroupManager $groupManager, UpdateGroupRequest $request, Group $group)
    {

        $group = $groupManager->upsertGroup($group, $request->validated());

        return redirect()->route('admin.groups.show', $group)
            ->withSuccess('Подборка обновлена');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('admin.groups.index')
            ->withSuccess('Подборка удалена');
    }

    public function restore($id)
    {
        Group::onlyTrashed()->find($id)->restore();

        return back()->withSuccess('Подборка восстановлена');
    }
}
