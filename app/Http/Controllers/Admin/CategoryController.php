<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable
            ->render('admin.categories.index');
    }

    public function create()
    {
        $category = new Category();
        return view('admin.categories.create', compact('category'));

    }

    public function store(CreateCategoryRequest $request)
    {
        $data = $request->validated();
        $category = Category::create($data);

        return redirect()->route('admin.categories.show', $category)
            ->withSuccess('Категория добавлена');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));

    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update($data);
        return redirect()->route('admin.categories.show', $category)
            ->withSuccess('Категория обновлена');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index', $category)
            ->withSuccess('Категория удалена');
    }
}
