<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testOpenPageCategories(): void
    {
        $this->loginByAdmin();
        $response = $this->get(route(
            'admin.categories.index'
        ));
        $response->assertStatus(200);
    }

    public function testPageCreate()
    {
        $this->loginByAdmin();
        $response = $this->get(route(
            'admin.categories.index'
        ));
        $response->assertStatus(200);
        $this->get(route(
            'admin.categories.create'
        ))->assertStatus(200);
    }

    public function testStoreCategory()
    {
        $this->loginByAdmin();
        $response = $this->post(route('admin.categories.store'), [
            'title' => 'Моя категория',
        ])
            ->assertStatus(302)
            ->assertSessionHas('success', 'Категория добавлена');

        $this->assertDatabaseHas('categories', [
            'title' => 'Моя категория',
        ]);
        $category = Category::query()->latest('id')->first();
        $response = $this->get(route('admin.categories.show', $category));
        $response->assertSee('Моя категория');
    }

    public function testEditCategory()
    {
        $this->loginByAdmin();
        $this->post(route('admin.categories.store'), [
            'title' => 'Проверка редактирования',
        ])
            ->assertRedirect()
            ->assertSessionHas('success', 'Категория добавлена');
        $category = Category::query()->latest('id')->first();
        $response = $this->get(route(
            'admin.categories.edit',
            $category
        ));
        $response->assertStatus(200);
        $response->assertSee('Проверка редактирования');
    }

    public function testUpdateCategory()
    {
        $this->loginByAdmin();
        $this->post(route('admin.categories.store'), [
            'title' => 'Новая категория',
        ])
            ->assertStatus(302);
        $category = Category::query()->latest('id')->first();
        $response = $this->get(route(
            'admin.categories.edit',
            $category
        ));
        $response->assertStatus(200);
        $this->patch(route('admin.categories.update', $category), [
            'title' => 'Измененная новая категория',
        ]) ->assertRedirect()
            ->assertSessionHas('success', 'Категория обновлена');
        $this->assertDatabaseHas('categories', [
            'title' => 'Измененная новая категория',
        ]);
    }

    public function testDeleteCategory()
    {
        $this->loginByAdmin();
        $this->get(route('admin.categories.index'));
        $this->post(route('admin.categories.store'), [
            'title' => 'Удаленная категория',
        ])
            ->assertStatus(302);
        $category = Category::query()->latest('id')->first();
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'deleted_at' => null,
        ]);
        $response = $this->delete(route('admin.categories.destroy', $category));
        $this->assertSoftDeleted('categories', [
            'id' => $category->id,
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Категория удалена');
        $response = $this->get(route('admin.categories.show', $category));
        $response->assertStatus(404);
    }

    public function testRequiredTitleCategory()
    {
        $this->loginByAdmin();
        $response = $this->post(route('admin.categories.store'), [
            'title' => null,
        ]);
        $response->assertSessionHasErrors(['title']);
    }

    public function testCategoryHasManyTests()
    {
        $this->loginByAdmin();

        $category = Category::factory()->create([
            'title' => 'Кошки и собаки',
        ]);
        $test1 = Test::factory()->create([
            'title' => 'Тест 1',
        ]);
        $test2 = Test::factory()->create([
            'title' => 'Тест 2',
        ]);

        $category->tests()
            ->attach([$test1->id, $test2->id]);

        $category->refresh();
        $this->assertCount(2, $category->tests);
        $this->assertTrue($category->tests->contains($test1));
        $this->assertTrue($category->tests->contains($test2));
    }

    public function testIndexCategories()
    {
        $this->loginByAdmin();

        $category1 = Category::factory()->create([
            'title' => 'Category 1',
        ]);
        $category2 = Category::factory()->create([
            'title' => 'Category 2',
        ]);

        $response = $this->get(route('admin.categories.index'), [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);

    }
}
