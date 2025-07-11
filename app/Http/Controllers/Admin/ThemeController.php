<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DataTables\ThemesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateThemeRequest;
use App\Http\Requests\UpdateThemeRequest;
use App\Models\Theme;

class ThemeController extends Controller
{
    public function index(ThemesDataTable $dataTable)
    {
        return $dataTable
            ->render('admin.themes.index');
    }

    public function create()
    {
        return view('admin.themes.create');
    }

    public function store(CreateThemeRequest $request)
    {
        $data = $request->validated();
        $theme = Theme::create($data);

        return redirect()->route('admin.themes.show', $theme)
            ->withSuccess('Тема добавлена');
    }

    public function show(Theme $theme)
    {
        return view('admin.themes.show', compact('theme'));

    }

    public function edit(Theme $theme)
    {
        return view('admin.themes.edit', compact('theme'));
    }

    public function update(UpdateThemeRequest $request, Theme $theme)
    {
        $data = $request->validated();
        $theme->update($data);
        return redirect()->route('admin.themes.show', $theme)
            ->withSuccess('Тема обновлена');
    }

    public function destroy(Theme $theme)
    {
        $theme->delete();
        return redirect()->route('admin.themes.index', $theme)
            ->withSuccess('Тема удалена');
    }
}
