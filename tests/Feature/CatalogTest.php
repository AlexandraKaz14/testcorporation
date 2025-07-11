<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Group;
use App\Models\Tag;
use App\Models\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testOpenCatalog(): void
    {
        Test::factory()->create([
            'title' => 'Тест активный',
            'status' => Test::STATUS_ACTIVE,
        ]);

        $response = $this->get(route('catalog'));
        $response->assertStatus(200);
        $response->assertSee('Тест активный');

    }

    public function testDraftNotDisplayedToCatalog(): void
    {
        Test::factory()->create([
            'title' => 'Тест активный',
            'status' => Test::STATUS_ACTIVE,
        ]);
        Test::factory()->create([
            'title' => 'Тест черновик',
            'status' => Test::STATUS_DRAFT,
        ]);

        $response = $this->get(route('catalog'));
        $response->assertStatus(200);
        $response->assertSee('Тест активный');
        $response->assertDontSee('Тест черновик');
    }

    public function testOpenPageAuthors(): void
    {
        $user1 = User::factory()->create([
            'name' => 'Petr Ivanov',
            'role' => User::ROLE_AUTHOR,
        ]);
        $user2 = User::factory()->create([
            'name' => 'Ivan Ivanov',
            'role' => User::ROLE_AUTHOR,
        ]);

        Test::factory()->create([
            'user_id' => $user1->id,
            'title' => 'Тест активный',
            'status' => Test::STATUS_ACTIVE,
        ]);

        Test::factory()->create([
            'user_id' => $user2->id,
            'title' => 'Тест черновик',
            'status' => Test::STATUS_DRAFT,
        ]);

        $response = $this->get(route('catalog.authors'));
        $response->assertStatus(200);
        $response->assertSee('Petr Ivanov');
        $response->assertDontSee('Ivan Ivanov');

    }

    public function testOpenPageTags(): void
    {
        $this->loginByAdmin();

        Storage::fake('public');
        $categories = Category::factory()->create([
            'title' => 'Кошки и собаки',
        ]);
        $tags = Tag::factory()->create([
            'name' => 'гуси',
        ]);
        $file = UploadedFile::fake()->image('test5.jpg');

        $this->post(route('admin.tests.store'), [
            'title' => 'Заголовок 1',
            'description' => 'Описание теста',
            'picture' => $file,
            'status' => Test::STATUS_ACTIVE,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ])
            ->assertStatus(302);
        $response = $this->get(route('catalog.tags'));
        $response->assertStatus(200);
        $response->assertSee('гуси');
    }

    public function testSeeCategoriesToCatalog(): void
    {
        $this->loginByAdmin();

        Storage::fake('public');
        $categories = Category::factory()->create([
            'title' => 'Кошки и собаки',
        ]);
        $tags = Tag::factory()->create([
            'name' => 'гуси',
        ]);
        $file = UploadedFile::fake()->image('test5.jpg');

        $this->post(route('admin.tests.store'), [
            'title' => 'Заголовок 1',
            'description' => 'Описание теста',
            'picture' => $file,
            'status' => Test::STATUS_ACTIVE,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ])
            ->assertStatus(302);
        $response = $this->get(route('catalog'));
        $response->assertStatus(200);
        $response->assertSee('Кошки и собаки');
        $response->assertSee('Заголовок 1');
    }

    public function testOpenPageGroupsTest(): void
    {

        Group::factory()->create([
            'title' => 'Моя подборка',
        ]);

        Group::factory()->create([
            'title' => 'Вторая подборка',
        ]);

        $response = $this->get(route('catalog.groups'));
        $response->assertStatus(200);
        $response->assertSee('Моя подборка');
        $response->assertSee('Вторая подборка');
    }

    public function testOpenGroupTests()
    {
        $group = Group::factory()->create([
            'title' => 'Моя подборка',
            'slug' => 'my-group',
            'description' => 'Подборка тестов про фильмы и сериалы',

        ]);
        $response = $this->get(route('catalog.groups'));
        $response->assertStatus(200);
        $response->assertSee('Моя подборка');
        $response = $this->get(route('catalog.open_groups', [
            'slug' => $group->slug,
        ]));
        $response->assertStatus(200);
        $response->assertSee('Моя подборка');
        $response->assertSee('Подборка тестов про фильмы и сериалы');

    }

    public function testOpenPageCreateTests()
    {
        $response = $this->get(route('catalog.create'));
        $response->assertStatus(200);
    }

    public function testOpenPageAboutProject()
    {
        $response = $this->get(route('project'));
        $response->assertStatus(200);
    }

    public function testOpenPageContact()
    {
        $response = $this->get(route('contacts'));
        $response->assertStatus(200);
    }

    public function testFeedbackSend()
    {
        Notification::fake();

        $data = [
            'name' => 'Ivan',
            'email' => 'ivan@example.com',
            'message' => 'Hello!',
        ];

        $response = $this->post(route('contacts.feedback.send'), $data);

        $response->assertSessionHas('success', $data['name'] . ',' . ' Ваше сообщение отправлено!');

        $response->assertRedirect();
    }

    public function testFeedbackSendWithInvalidData()
    {
        Notification::fake();

        $data = [
            'name' => '',
            'email' => 'email',
            'message' => '',
        ];

        $response = $this->post(route('contacts.feedback.send'), $data);

        $response->assertSessionHasErrors(['name', 'email', 'message']);

        Notification::assertNothingSent();
    }
}
