<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Moderation;
use App\Models\Question;
use App\Models\Result;
use App\Models\Tag;
use App\Models\Test;
use App\Models\Theme;
use App\Models\User;
use App\Models\Variable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class TestTest extends TestCase
{
    use RefreshDatabase;

    public function testOpenPageTests()
    {
        $this->loginByAdmin();
        $response = $this->get(route('admin.tests.index'));
        $response->assertStatus(200);
    }

    public function testOpenPageTestsByAuthors()
    {
        $this->loginByAuthor();
        $response = $this->get(route('author.tests.index'));
        $response->assertStatus(200);
    }

    public function testDontOpenPageTestsByAuthors()
    {
        $this->loginByAuthor();
        $response = $this->get(route('admin.tests.index'));
        $response->assertStatus(403);
    }

    public function testOpenPageCreate()
    {
        $this->loginByAdmin();
        $response = $this->get(route('admin.tests.create'));

        $response->assertStatus(200);
    }

    public function testOpenPageCreateByAuthor()
    {
        $this->loginByAuthor();
        $response = $this->get(route('author.tests.create'));

        $response->assertStatus(200);
    }

    public function testDontOpenPageCreateByAuthor()
    {
        $this->loginByAuthor();
        $response = $this->get(route('admin.tests.create'));

        $response->assertStatus(403);
    }

    public function testStoreTest()
    {
        $this->loginByAdmin();

        Storage::fake('public');
        $categories = Category::factory()->create([
            'title' => 'Литература',
        ]);
        $tags = Tag::factory()->create();
        $file = UploadedFile::fake()->image('test2.jpg');

        $response = $this->post(route('admin.tests.store'), [
            'title' => 'Утка Поганка',
            'slug' => 'utka-poganka',
            'description' => 'Описание теста Утка Поганка',
            'picture' => $file,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Тест создан');
    }

    public function testStoreTestByAuthor()
    {
        $this->loginByAuthor();

        Storage::fake('public');
        $categories = Category::factory()->create();
        $tags = Tag::factory()->create();
        $file = UploadedFile::fake()->image('test2.jpg');

        $response = $this->post(route('author.tests.store'), [
            'title' => 'Утка Поганка',
            'slug' => 'utka-poganka',
            'description' => 'Описание теста Утка Поганка',
            'picture' => $file,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Тест создан');
    }

    public function testPageShowTest()
    {
        $this->loginByAdmin();

        Storage::fake('public');
        $categories = Category::factory()->create();
        $tags = Tag::factory()->create();
        $file = UploadedFile::fake()->image('test5.jpg');

        $this->post(route('admin.tests.store'), [
            'title' => 'Новый тест',
            'slug' => 'slag-slag-slag',
            'description' => 'Описание нового теста',
            'picture' => $file,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ])->assertStatus(302);

        $this->assertDatabaseHas('tests', [
            'title' => 'Новый тест',
        ]);

        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.show', $test));
        $response->assertSee('Новый тест');
        $response->assertSee('Описание нового теста');
    }

    public function testPageShowTestByAuthor()
    {
        $this->loginByAuthor();

        Storage::fake('public');
        $categories = Category::factory()->create();
        $tags = Tag::factory()->create();
        $file = UploadedFile::fake()->image('test5.jpg');

        $this->post(route('author.tests.store'), [
            'title' => 'Новый тест',
            'slug' => 'slag-slag-slag',
            'description' => 'Описание нового теста',
            'picture' => $file,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ])->assertStatus(302);

        $this->assertDatabaseHas('tests', [
            'title' => 'Новый тест',
        ]);

        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('author.tests.show', $test));
        $response->assertSee('Новый тест');
        $response->assertSee('Описание нового теста');
    }

    public function testPageEditTest()
    {
        $this->loginByAdmin();
        Test::factory()->create([
            'title' => 'Новый тест2',
        ]);
        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.edit', $test));
        $response->assertSee('Новый тест2');
    }

    public function testPageEditTestByAuthor()
    {
        $this->loginByAuthor();

        Storage::fake('public');
        $categories = Category::factory()->create();
        $tags = Tag::factory()->create();
        $file = UploadedFile::fake()->image('test5.jpg');

        $this->post(route('author.tests.store'), [
            'title' => 'Новый тест автора',
            'slug' => 'slag-slag-slag',
            'description' => 'Описание нового теста',
            'picture' => $file,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ])->assertStatus(302);

        $this->assertDatabaseHas('tests', [
            'title' => 'Новый тест автора',
        ]);
        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('author.tests.edit', $test));
        $response->assertStatus(200);
        $response->assertSee('Новый тест автора');
    }

    public function testPageEditTestStatusActive()
    {
        $this->loginByAuthor();

        Storage::fake('public');
        $categories = Category::factory()->create();
        $tags = Tag::factory()->create();
        $file = UploadedFile::fake()->image('test5.jpg');

        $this->post(route('author.tests.store'), [
            'title' => 'Новый тест автора',
            'slug' => 'slag-slag-slag',
            'description' => 'Описание нового теста',
            'picture' => $file,
            'status' => Test::STATUS_ACTIVE,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ])->assertStatus(302);

        $this->assertDatabaseHas('tests', [
            'title' => 'Новый тест автора',
            'status' => 'active',
        ]);
        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('author.tests.edit', $test));
        $response->assertStatus(403);
    }

    public function testUpdateTest()
    {
        $this->loginByAdmin();

        Storage::fake('public');
        $categories = Category::factory()->create();
        $tags = Tag::factory()->create();
        $file = UploadedFile::fake()->image('test76.jpg');
        $file2 = UploadedFile::fake()->image('test23.jpg');

        $this->post(route('admin.tests.store'), [
            'title' => 'Тест',
            'slug' => 'utka-poganka-new',
            'description' => 'Описание',
            'picture' => $file,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ])->assertStatus(302);

        $test = Test::query()->latest('id')->first();
        Storage::disk()->assertExists($test->picture);
        $picture1 = $test->picture;

        $response = $this->get(route('admin.tests.edit', $test));
        $response->assertStatus(200);
        $response->assertSee('Тест');
        $this->patch(route('admin.tests.update', $test), [
            'title' => 'Заголовок редактированный',
            'slug' => 'utka-poganka-new2',
            'description' => 'Описание редактированного теста',
            'picture' => $file2,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ])
            ->assertStatus(302);
        $test->refresh();
        Storage::disk()->assertExists($test->picture);
        Storage::disk()->delete($picture1);

        Storage::disk()->assertMissing($picture1);

        $response = $this->get(route('admin.tests.show', $test));
        $response->assertSee('Заголовок редактированный');
        $response->assertSee('Описание редактированного теста');
        $this->assertDatabaseHas('tests', [
            'title' => 'Заголовок редактированный',
        ]);
    }

    public function testDeleteTest()
    {
        $this->loginByAdmin();

        Storage::fake('public');
        $categories = Category::factory()->create([
            'title' => 'Кошки и собаки',
        ]);
        $tags = Tag::factory()->create();
        $file = UploadedFile::fake()->image('test5.jpg');

        $this->get(route('admin.tests.index'));
        $this->post(route('admin.tests.store'), [
            'title' => 'Заголовок 1',
            'description' => 'Описание теста',
            'picture' => $file,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ])
            ->assertStatus(302);
        $test = Test::query()->latest('id')->first();
        $this->assertDatabaseHas('tests', [
            'id' => $test->id,
            'deleted_at' => null,
        ]);
        $response = $this->delete(route('admin.tests.destroy', $test));
        $this->assertSoftDeleted('tests', [
            'id' => $test->id,
            'deleted_at' => now(),
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Тест удален');
        $response = $this->get(route('admin.tests.show', $test));
        $response->assertStatus(404);
    }

    public function testDeleteTestStatusActive()
    {
        $this->loginByAuthor();

        Storage::fake('public');
        $categories = Category::factory()->create([
            'title' => 'Кошки и собаки',
        ]);
        $tags = Tag::factory()->create();
        $file = UploadedFile::fake()->image('test5.jpg');

        $this->get(route('author.tests.index'));
        $this->post(route('author.tests.store'), [
            'title' => 'Заголовок 1',
            'description' => 'Описание теста',
            'picture' => $file,
            'status' => 'active',
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ])
            ->assertStatus(302);
        $test = Test::query()->latest('id')->first();
        $this->assertDatabaseHas('tests', [
            'id' => $test->id,
            'deleted_at' => null,
        ]);
        $response = $this->delete(route('author.tests.destroy', $test));

        $response->assertStatus(403);
    }

    public function testRestoreTest()
    {
        $this->loginByAdmin();

        $deleteTest = Test::factory()->create([
            'deleted_at' => now(),
        ]);
        $this->get(route('admin.tests.show', $deleteTest->id))
            ->assertStatus(404);
        $this->assertSoftDeleted('tests', [
            'id' => $deleteTest->id,
        ]);

        $response = $this->post(route('admin.tests.restore', $deleteTest->id));
        $response->assertStatus(302);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Тест восстановлен');

        $this->assertDatabaseHas('tests', [
            'id' => $deleteTest->id,
            'deleted_at' => null,
        ]);
        $this->get(route('admin.tests.show', $deleteTest->id))
            ->assertStatus(200);
    }

    public function testFilterDeletedTests()
    {
        $this->loginByAdmin();

        $undeletedTest = Test::factory()->create();
        $deletedTest = Test::factory()->create([
            'deleted_at' => now(),
        ]);
        $response = $this->get(route('admin.tests.index', [
            'deletedStatuses' => [Test::STATUS_DELETED],
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);
        $response->assertStatus(200);
        $response->assertSee($deletedTest->title);
        $response->assertDontSee($undeletedTest->title);
    }

    public function testFilterUndeletedTests()
    {
        $this->loginByAdmin();

        $undeletedTest = Test::factory()->create();
        $deletedTest = Test::factory()->create([
            'deleted_at' => now(),
        ]);
        $response = $this->get(route('admin.tests.index', [
            'deletedStatuses' => [Test::STATUS_UNDELETED],
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);
        $response->assertStatus(200);
        $response->assertSee($undeletedTest->title);
        $response->assertDontSee($deletedTest->title);
    }

    public function testFilterDataCreateTests()
    {
        $this->loginByAdmin();

        $createdAtTimes = [
            '2024-09-20 09:00:00',
            '2024-09-21 12:00:00',
            '2024-09-22 13:00:00',
            '2024-09-27 13:00:00',
            now(),
        ];
        $tests = [];
        foreach ($createdAtTimes as $createdAt) {
            $tests[] = Test::factory()->create([
                'created_at' => $createdAt,
            ]);
        }
        $response = $this->get(route('admin.tests.index', [
            'daterange' => '2024-09-20 - 2024-09-21',
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);
        $response->assertStatus(200);
        $response->assertSee($tests[0]->title);
        $response->assertSee($tests[1]->title);
        $response->assertDontSee($tests[2]->title);
        $response->assertDontSee($tests[3]->title);
        $response->assertDontSee($tests[4]->title);
    }

    public function testCreateTags()
    {
        $this->loginByAdmin();

        $tag = Tag::factory()->create([
            'name' => 'Волки',
        ]);

        $test1 = Test::factory()->create([
            'title' => 'Тест 1',
        ]);
        $test2 = Test::factory()->create([
            'title' => 'Тест 2',
        ]);
        $tag->tests()
            ->attach([$test1->id, $test2->id]);
        $test = Test::query()->latest('id')->first();
        $response = $this->get('admin/tests/{test}', [
            'test' => $test,
        ]);
        $response->assertSee('Волки');
    }

    public function testFilterCategories()
    {
        $this->loginByAdmin();

        $category1 = Category::factory()->create([
            'title' => 'Психология',
        ]);
        $category2 = Category::factory()->create([
            'title' => 'Развлекательные',
        ]);

        $test1 = Test::factory()->create([
            'title' => 'Первый тест',
            'description' => 'Тест будет с тегом психология',

        ]);
        $test2 = Test::factory()->create([
            'title' => 'Второй тест',
            'description' => 'Тест будет с тегом развлекательные',

        ]);

        $test1->categories()
            ->attach($category1->id);
        $test2->categories()
            ->attach($category2->id);

        $response = $this->get(route('admin.tests.index', [
            'categories' => [$category1->id],
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);

        $response = $this->get(route('admin.tests.show', $test1));
        $response->assertStatus(200);
        $response->assertSee('Тест будет с тегом психология');
    }

    public function testFilterTags()
    {
        $this->loginByAdmin();

        $tag1 = Tag::factory()->create([
            'name' => 'коты',
        ]);
        $tag2 = Tag::factory()->create([
            'name' => 'собаки',
        ]);

        $test1 = Test::factory()->create([
            'title' => 'Первый тест',
            'description' => 'Тест с тегом коты',
        ]);
        $test2 = Test::factory()->create([
            'title' => 'Второй тест',
            'description' => 'Тест с тегом собаки',
        ]);

        $test1->tags()
            ->attach($tag1->id);
        $test2->tags()
            ->attach($tag2->id);

        $response = $this->get(route('admin.tests.index', [
            'tags' => [$tag1->id],
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);

        $response = $this->get(route('admin.tests.show', $test1));
        $response->assertStatus(200);
        $response->assertSee('Тест с тегом коты');
    }

    public function testFilterStatus()
    {
        $this->loginByAdmin();

        $testStatus = Test::factory()->create([
            'status' => Test::STATUS_DRAFT,
        ]);

        $response = $this->get(route('admin.tests.index', [
            'statuses' => [Test::STATUS_DRAFT],
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);
        $response->assertSee($testStatus->title);
    }

    public function testUserAuthorTests()
    {
        $this->loginByAdmin();

        $user1 = User::factory()->create([
            'name' => 'Ivan',
        ]);
        $user2 = User::factory()->create([
            'name' => 'Petr',
        ]);
        $user3 = User::factory()->create([
            'name' => 'Maria',
        ]);

        $test1 = Test::factory()->create([
            'title' => 'Тест 1',
            'user_id' => $user1->id,
        ]);

        $response = $this->get(route('admin.tests.index', [
            'users' => [$user1->id],
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);

        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.show', $test));
        $response->assertStatus(200);
        $response->assertSee($user1->name);
    }

    public function testStatusDraftToActiveOnlyQuestion()
    {
        $this->loginByAdmin();
        $testStatusDraft = Test::factory()->create([
            'status' => Test::STATUS_DRAFT,
        ]);
        $this->get(route('admin.tests.show', $testStatusDraft->id))
            ->assertStatus(200);

        $question1 = [
            'text' => 'Описание вопроса',
            'number' => 1,
            'type' => Question::TYPE_ONLY_ANSWER,
            'test_id' => $testStatusDraft->id,
        ];
        $response = $this->post(route('admin.tests.questions.store'), $question1);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Вопрос создан');
        $response = $this->get(route('admin.tests.publish', $testStatusDraft->id));
        $response->assertRedirect()
            ->assertSessionHasErrors();
    }

    public function testStatusDraftToActive()
    {
        $this->loginByAdmin();
        $testStatusDraft = Test::factory()->create([
            'status' => Test::STATUS_DRAFT,
        ]);
        $this->get(route('admin.tests.show', $testStatusDraft->id))
            ->assertStatus(200);

        $question = Question::factory()->create([
            'test_id' => $testStatusDraft->id,
            'text' => 'вопрос 1',
        ]);
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertStatus(200);
        $this->post(route('admin.tests.questions.answers.store'), [
            'text' => 'Ответ',
            'number' => 1,
            'question_id' => $question->id,
        ])
            ->assertStatus(302);
        Variable::factory()->create([
            'name' => 'ответ',
            'test_id' => $testStatusDraft->id,
        ]);
        $response = $this->post(route('admin.tests.results.store'), [
            'test_id' => $testStatusDraft->id,
            'condition' => 'ответ ==20',
            'text' => 'такой результат',
            'number' => 1,
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Результат создан');
        $response = $this->get(route('admin.tests.publish', $testStatusDraft->id));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Тест успешно опубликован!');
        $this->assertDatabaseHas('tests', [
            'id' => $testStatusDraft->id,
            'status' => Test::STATUS_ACTIVE,
        ]);

        $this->get(route('catalog'))
            ->assertStatus(200);
        $response = $this->get(route('player.open', $testStatusDraft->slug));
        $response->assertStatus(200);

    }

    public function testReturnTestToDraft()
    {
        $this->loginByAdmin();
        $testStatusDraft = Test::factory()->create([
            'status' => Test::STATUS_DRAFT,
        ]);
        $this->get(route('admin.tests.show', $testStatusDraft->id))
            ->assertStatus(200);

        $question = Question::factory()->create([
            'test_id' => $testStatusDraft->id,
            'text' => 'вопрос 1',
        ]);
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertStatus(200);
        $this->post(route('admin.tests.questions.answers.store'), [
            'text' => 'Ответ',
            'number' => 1,
            'question_id' => $question->id,
        ])
            ->assertStatus(302);
        Variable::factory()->create([
            'name' => 'ответ',
            'test_id' => $testStatusDraft->id,
        ]);
        $response = $this->post(route('admin.tests.results.store'), [
            'test_id' => $testStatusDraft->id,
            'condition' => 'ответ ==20',
            'text' => 'такой результат',
            'number' => 1,
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Результат создан');
        $response = $this->get(route('admin.tests.publish', $testStatusDraft->id));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Тест успешно опубликован!');
        $this->assertDatabaseHas('tests', [
            'id' => $testStatusDraft->id,
            'status' => Test::STATUS_ACTIVE,
        ]);
        $response = $this->get(route('admin.tests.return_draft', $testStatusDraft->id));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Тест в черновике, редактирование доступно');
        $this->assertDatabaseHas('tests', [
            'id' => $testStatusDraft->id,
            'status' => Test::STATUS_DRAFT,
        ]);

    }

    public function testStatusDraftToModeration()
    {
        Bus::fake();
        $user = $this->loginByAuthor();
        $testStatusDraft = Test::factory()->create([
            'user_id' => $user->id,
        ]);
        $question = Question::factory()->create([
            'test_id' => $testStatusDraft->id,
        ]);
        Answer::factory()->create([
            'question_id' => $question->id,
        ]);
        Result::factory()->create([
            'test_id' => $testStatusDraft->id,
        ]);

        $response = $this->get(route('author.tests.submit_moderation', $testStatusDraft->id));
        $response->assertStatus(302);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Тест успешно отправлен на модерацию!');
        $this->assertDatabaseHas('tests', [
            'id' => $testStatusDraft->id,
            'status' => Test::STATUS_MODERATION,
        ]);

        $moderation = Moderation::where('test_id', $testStatusDraft->id)->first();
        $this->assertDatabaseHas('moderation_tests', [
            'id' => $moderation->id,
            'test_id' => $testStatusDraft->id,
            'moderation_status' => Moderation::MODERATION_STATUS_PENDING,
        ]);

    }

    public function testPageEditByAuthor()
    {
        $user = $this->loginByAuthor();
        $test = Test::factory()->create([
            'title' => 'Новый тест2',
            'user_id' => $user->id,
        ]);

        $this->assertNotNull($test);

        $response = $this->get(route('author.tests.show', $test));
        $response->assertStatus(200);
    }

    public function testStatusDraftToModerationWithoutQuestions()
    {

        $user = $this->loginByAuthor();

        $test = Test::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('author.tests.submit_moderation', $test->id));

        $response->assertStatus(302);

        $response->assertRedirect()
            ->assertSessionHas('errors');

        $this->assertDatabaseHas('tests', [
            'id' => $test->id,
            'status' => Test::STATUS_DRAFT,
        ]);

    }

    public function testStatusDraftToModerationAfterRejection()
    {
        Bus::fake();

        $user = $this->loginByAuthor();

        $test = Test::factory()->create([
            'user_id' => $user->id,
        ]);
        $moderation = Moderation::factory()->create([
            'test_id' => $test->id,
            'moderation_status' => Moderation::MODERATION_STATUS_REJECTED,
            'rejection_reason' => 'Some reason',
            'moderator_id' => 1,
            'moderation_at' => now(),
        ]);

        $question = Question::factory()->create([
            'test_id' => $test->id,
        ]);
        Answer::factory()->create([
            'question_id' => $question->id,
        ]);
        Result::factory()->create([
            'test_id' => $test->id,
        ]);

        $response = $this->get(route('author.tests.submit_moderation', $test->id));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Тест успешно отправлен на модерацию!');

        $this->assertDatabaseHas('tests', [
            'id' => $test->id,
            'status' => Test::STATUS_MODERATION,
        ]);

        $this->assertDatabaseHas('moderation_tests', [
            'id' => $moderation->id,
            'test_id' => $test->id,
            'moderation_status' => Moderation::MODERATION_STATUS_PENDING,
            'rejection_reason' => null,
            'moderator_id' => null,
            'moderation_at' => null,
        ]);
    }

    public function testSubmitToModerationWithoutResult()
    {
        Bus::fake();

        $this->loginByAuthor();

        Storage::fake('public');
        $categories = Category::factory()->create([
            'title' => 'животные',
        ]);
        $tags = Tag::factory()->create();
        $file = UploadedFile::fake()->image('test2.jpg');
        Theme::factory()->create();
        $theme = Theme::query()->latest('id')->first();
        $response = $this->post(route('author.tests.store'), [
            'title' => 'Тест на модерацию',
            'slug' => 'test-moderation',
            'description' => 'Описание теста на модерацию без результата',
            'picture' => $file,
            'theme_id' => $theme->id,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Тест создан');
        $testStatusDraft = Test::query()->latest('id')->first();
        $response = $this->get(route('author.tests.show', $testStatusDraft->id));
        $response->assertStatus(200);

        $question = Question::factory()->create([
            'test_id' => $testStatusDraft->id,
            'text' => 'вопрос 1',
        ]);
        $response = $this->get(route('author.tests.questions.show', $question));
        $response->assertStatus(200);

        $response = $this->get(route('author.tests.submit_moderation', $testStatusDraft->id));
        $response->assertStatus(302);

        $response->assertRedirect()
            ->assertSessionHas('errors');
    }

    public function testStatusDraftToModerationUnauthorized()
    {
        $test = Test::factory()->create();

        $response = $this->get(route('author.tests.submit_moderation', $test->id));
        $response->assertStatus(302)
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('tests', [
            'id' => $test->id,
            'status' => Test::STATUS_DRAFT,
        ]);
    }

    public function testStatusDraftToModerationTransactionRollback()
    {
        $user = $this->loginByAuthor();

        $test = Test::factory()->create([
            'user_id' => $user->id,
        ]);

        $question = Question::factory()->create([
            'test_id' => $test->id,
        ]);
        Answer::factory()->create([
            'question_id' => $question->id,
        ]);
        Result::factory()->create([
            'test_id' => $test->id,
        ]);

        $dbMock = Mockery::mock(DB::getFacadeRoot())->makePartial();
        DB::swap($dbMock);

        $dbMock->shouldReceive('transaction')
            ->andThrow(new \Exception('Transaction failed'));

        $response = $this->get(route('author.tests.submit_moderation', $test->id));
        $response->assertStatus(500);

        $this->assertDatabaseHas('tests', [
            'id' => $test->id,
            'status' => Test::STATUS_DRAFT,
        ]);
        Mockery::close();
    }
}
