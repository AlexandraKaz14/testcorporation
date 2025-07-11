<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Reaction;
use App\Models\Result;
use App\Models\Tag;
use App\Models\Test;
use App\Models\Theme;
use App\Models\User;
use App\Models\Variable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateUserTestThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init-app-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создает пользователя, тест и тему';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();
        $userName = 'Иван Петров';
        $testTitle = 'Какой ты цветовод огородник';
        $themeTitle = 'Темная тема';

        $user = User::create([
            'name' => $userName,
            'email' => Str::slug($userName) . '@example.com',
            'password' => bcrypt('password'),
            'status' => User::STATUS_ACTIVE,
            'role' => User::ROLE_ADMIN,
        ]);

        $this->info("Пользователь {$userName} создан с ID {$user->id}");

        $categoryNames = ['Наука', 'Искусство', 'Развлечения', 'Психология', 'Фильмы'];

        $category = Category::create([
            'title' => $categoryNames[array_rand($categoryNames)],
        ]);

        $this->info("Категория {$category->title} создана с ID {$category->id}");

        $tagsName = ['фиалка', 'фикус', 'цветоводство', 'комнатные_растения', 'цветы_зеленые_друзья'];
        $tags = [];
        foreach ($tagsName as $tagName) {
            $tags[] = Tag::create([
                'name' => $tagName,
            ]);
        }

        $theme = Theme::create([
            'title' => $themeTitle,
            'css_style' => '.container-header {
            position: relative;
            width: 100%;
            height: 70px;
            background-color: rgb(0, 0, 0);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-content {
            padding-top: 50px;
            padding-bottom: 50px;
            background-color: rgb(141, 138, 138);
        }

        .test-container {
            max-width: 1000px;
            margin: 100px auto;
            background-color: rgb(255, 255, 255);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .test-container:hover {
            transform: translateY(-10px);
        }

        .test-body {
            padding: 24px;
        }

        .btn-start {
            font-size: 20px;
            border: none;
            padding: 10px 30px;
            text-align: center;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;
            box-shadow: 0 0 20px #eee;
            border-radius: 10px;
            background-image: linear-gradient(to right, #444343 0%, #a3adac 51%, #000000 100%);
        }

        .btn-start:hover {
            background-position: right center;
            color: white;
        }

        .categories {
            margin-top: 10px;
        }

        .test-tags {
            margin-left: 2px;
            margin-right: 2px;
        }

        .test-tags-container {
            margin: 40px 0 0;
        }

        .test-title {
            font-size: 18px;
            margin: 10px 0;
            color: #333;
            font-family: Calibri, sans-serif;
        }

        .test-description {
            font-size: 20px;
            color: rgba(0, 0, 0, 0.76);
            margin-top: 15px;
            font-family: Calibri, sans-serif;
            text-align: justify;
        }

        .test-info {
            color: #000000;
        }

        .count-questions {
            color: rgba(0, 0, 0, 0.76);
        }

        .image-container {
            width: 500px;
            height: 400px;
            overflow: hidden; /* Обрезаем изображение */
            margin: 20px auto 0; /* Центрирование контейнера изображения */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .test-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Пропорционально масштабируем изображение */
            border-radius: 10px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.17);
        }

        .question-container {
            max-width: 1000px;
            margin: 100px auto;
            background-color: rgb(255, 255, 255);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px; /* дополнительно */
        }

        .question-body {
            padding: 10px 40px 40px 40px;
        }

        .image-container-question {
            width: 350px;
            height: 300px;
            overflow: hidden; /* Обрезаем изображение */
            margin: 20px auto 0; /* Центрирование контейнера изображения */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .question-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Пропорционально масштабируем изображение */
            border-radius: 10px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.17);
        }

        .question-text {
            font-size: 20px;
            color: rgba(0, 0, 0, 0.76);
            margin-bottom: 20px;
            margin-top: 20px;
            font-family: Calibri, sans-serif;
            text-align: justify;
        }

        .btn-next {
            margin-top: 20px;
            width: 100%;
            font-size: 20px;
            border: none;
            padding: 10px 30px;
            text-align: center;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;
            box-shadow: 0 0 20px #eee;
            border-radius: 10px;
            background-image: linear-gradient(to right, #444343 0%, #a3adac 51%, #000000 100%);
        }

        .btn-next:hover {
            background-position: right center;
            color: rgba(255, 255, 255, 0.39);
        }

        .radio-section {
            display: flex;
            align-items: center;
            justify-content: left;
        }

        .radio-item [type="radio"] {
            display: none;
        }

        .radio-item + .radio-item {
            margin-top: 15px;
        }

        .radio-item label {
            white-space: normal; /* Позволяет тексту переноситься */
            word-wrap: break-word; /* Разрывает слова, если они слишком длинные */
            overflow-wrap: break-word; /* Аналогично предыдущему, для современных браузеров */
            max-width: 100%;
            display: block;
            padding: 20px 60px;
            background: rgba(190, 190, 190, 0.75);
            border: 2px solid rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 400;
            min-width: 250px;
            position: relative;
            transition: 0.4s ease-in-out 0s;
            font-family: Calibri, sans-serif;
        }

        .radio-item label:after,
        .radio-item label:before {
            content: "";
            position: absolute;
            border-radius: 50%;
        }

        .radio-item label:after {
            height: 19px;
            width: 19px;
            border: 2px solid #000000;
            left: 19px;
            top: 50%; /* Центровка по вертикали */
            transform: translateY(-50%); /* Для идеальной центровки */
        }

        .radio-item label:before {
            background: rgba(0, 0, 0, 0.76);
            height: 19px;
            width: 19px;
            left: 19px;
            top: 50%; /* Центровка по вертикали */
            transform: translateY(-50%) scale(5); /* Центровка и начальный масштаб */
            opacity: 0;
            visibility: hidden;
            transition: 0.4s ease-in-out 0s;
        }

        .radio-item [type="radio"]:checked ~ label {
            border-color: rgba(0, 0, 0, 0.71);
        }

        .radio-item [type="radio"]:checked ~ label::before {
            opacity: 1;
            visibility: visible;
            transform: translateY(-50%) scale(1); /* Уменьшение масштаба и сохранение центровки */
        }

        .progress-container {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 15px;
        }

        .progress-bar {
            height: 10px;
            background-color: #000000;
            width: 0;
            transition: width 0.4s ease;
        }

        .progress-text {
            font-size: 22px;
            text-align: left;
            color: rgba(0, 0, 0, 0.76);
            font-family: Comic Sans MS, sans-serif;
        }

        .radio-input {
            display: none;
        }

        .radio-label {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 10px;
            overflow: hidden;
        }

        .radio-input:checked + .radio-label {
            border-color: rgba(0, 0, 0, 0.71);
        }

        .radio-image {
            width: 200px;
            height: 200px;
            transition: transform 0.2s ease;
        }

        .label-card {
            width: 250px;
            height: 300px;
            border-color: rgba(0, 0, 0, 0.71);

        }

        .result-share p {
            font-size: 1.1em;
            color: #333;
        }

        img {
            max-width: 100%;
            display: block;
            vertical-align: middle;
        }

        .image-container-answer {
            width: 250px;
            height: 300px;
            overflow: hidden; /* Обрезаем изображение */
            margin: 20px auto 0; /* Центрирование контейнера изображения */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .answer-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Пропорционально масштабируем изображение */
            /*border-radius: 5px;*/
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.17);
        }

        .answer-text {
            font-size: 16px;
        }

        label.radio-card {
            cursor: pointer;
        }

        label.radio-card .card-content-wrapper {
            background: rgba(190, 190, 190, 0.75);
            border-radius: 5px;
            width: 300px;
            min-height: 500px;
            max-height: 600px;
            padding: 15px;
            display: grid;
            box-shadow: 0 2px 4px 0 rgba(219, 215, 215, 0.04);
            transition: 200ms linear;
        }

        label.radio-card .check-icon {
            width: 20px;
            height: 20px;
            display: inline-block;
            border: 2px solid #000000;
            border-radius: 50%;
            transition: 200ms linear;
            position: relative;
        }

        label.radio-card .check-icon:before {
            content: "";
            position: absolute;
            inset: 0;
            background-repeat: no-repeat;
            background-size: 12px;
            background-position: center center;
            transform: scale(1.6);
            transition: 200ms linear;
            opacity: 0;
        }

        label.radio-card input[type=radio] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        label.radio-card input[type=radio]:checked + .card-content-wrapper {
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.76), 0 0 0 2px rgba(56, 53, 53, 0.45);
        }

        label.radio-card input[type=radio]:checked + .card-content-wrapper .check-icon {
            background: rgb(0, 0, 0);
            border-color: rgba(49, 49, 49, 0.58);

            transform: scale(1.2);
        }

        label.radio-card input[type=radio]:checked + .card-content-wrapper .check-icon:before {
            transform: scale(1);
            opacity: 1;
        }

        label.radio-card input[type=radio]:focus + .card-content-wrapper .check-icon {
            box-shadow: 0 0 0 4px rgba(117, 118, 124, 0.2);
            border-color: rgba(0, 0, 0, 0.76);
        }

        label.radio-card .card-content img {
            margin-bottom: 10px;
        }

        label.radio-card .card-content {
            font-size: 16px;
            letter-spacing: -0.24px;
            text-align: center;
            margin-bottom: 10px;
        }

        label.radio-card .card-content {
            font-size: 18px;
            line-height: 1.4;
            text-align: center;
            font-family: Calibri, sans-serif;
        }

        /*/стили результатов*/

        .main-result {
            padding-top: 50px;
            padding-bottom: 50px;
            background-color: rgb(141, 138, 138);
        }

        .result-container {
            max-width: 1000px;
            margin: 100px auto;
            background-color: rgb(255, 255, 255);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px; /* дополнительно */
        }

        .result-body {
            padding: 20px 40px 40px 40px;
        }

        .image-container-result {
            width: 500px;
            height: 400px;
            overflow: hidden; /* Обрезаем изображение */
            margin: 10px auto 0; /* Центрирование контейнера изображения */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .result-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Пропорционально масштабируем изображение */
            border-radius: 10px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.17);
        }

        .result-text {
            font-size: 20px;
            margin: 30px 0;
            font-family: Calibri, sans-serif;
            text-align: justify;
        }

        .test-title-result {
            font-size: 24px;
            margin: 10px 0 20px 0;
            color: #333;
            font-family: Calibri, sans-serif;
        }

        .btn-repeat {
            margin-top: 20px;
            margin-bottom: 20px;
            background-color: #000000;
            font-family: Calibri, sans-serif;
            border: none;
            padding: 10px 10px;
            color: white;
            font-size: 1.1em;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 2px rgb(141, 138, 138);
        }

        .btn-repeat:hover {
            background-position: right center;
            color: black;
            background-color: rgba(141, 138, 138, 0.31);

        }

        .result-share {
            font-family: Calibri, sans-serif;
            max-width: 400px;
            margin: 60px auto;
            text-align: center;
        }

        .result-share p {
            font-size: 1.1em;
            color: #333;
        }

        .container {
            position: relative; /* Это нужно для позиционирования прелоадера */
            width: 100%;
            height: 200px;
            background-color: #8d8a8a;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .content {
            font-size: 24px;
            color: #333;
        }

        .preloader {
            position: absolute; /* Абсолютное позиционирование внутри контейнера */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            width: 100px;
        }

        .preloader div {
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: #000000;
            border-radius: 50%;
            animation: bounce 1.5s infinite ease-in-out;
        }

        .preloader div:nth-child(2) {
            animation-delay: -0.75s;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-50px);
            }
        }',
        ]);

        $this->info("Тема '{$themeTitle}' создана с ID {$theme->id}");

        $picturePath = 'pictures/' . uniqid() . '.jpeg';
        Storage::disk()->put($picturePath, file_get_contents(resource_path('fixtures/images/cover_test.jpeg')));

        $testData = [
            'title' => $testTitle,
            'description' => 'Тест поможет тебе узнать, насколько хорошо ты разбираешься в уходе за растениями и какой стиль цветоводства тебе ближе всего. Этот тест покажет, какой тип садовода в тебе скрыт: внимательный ботаник, увлечённый коллекционер редких растений или, может быть, лёгкий любитель, ценящий зелёных друзей за простоту и уют. Ответь на вопросы и узнай, какие растения станут твоими лучшими друзьями, и насколько твой подход к цветоводству гармонирует с природой!',
            'slug' => Str::slug($testTitle . '-' . now()->timestamp),
            'status' => Test::STATUS_ACTIVE,
            'user_id' => $user->id,
            'categories' => $category->id,
            'theme_id' => $theme->id,
            'picture' => $picturePath,
        ];

        $test = Test::create($testData);
        $test->categories()
            ->sync($category);
        $test->tags()
            ->sync(collect($tags)->pluck('id'));
        $this->info("Тест '{$testTitle}' создан с ID {$test->id} и связан с темой '{$themeTitle}'");

        $variable = Variable::create([
            'test_id' => $test->id,
            'name' => 'цветочник',
            'start_value' => 0,
        ]);

        $pictureQuestion1 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureQuestion1, file_get_contents(resource_path('fixtures/images/decabrist.jpg')));

        $questionData1 = [
            'text' => 'Декабрист — это цветущий кактус. Называется он так из-за своей способности радовать яркими цветами зимой, преимущественно в декабре. Как по-научному называют это растение?',
            'type' => 'only',
            'test_id' => $test->id,
            'number' => 1,
            'picture' => $pictureQuestion1,
        ];

        $question1 = Question::create($questionData1);

        $answer1 = Answer::create([
            'question_id' => $question1->id,
            'number' => 1,
            'text' => 'Хамеолобивия',
        ]);

        $answer2 = Answer::create([
            'question_id' => $question1->id,
            'number' => 2,
            'text' => 'Астрофитум звёздчатый',
        ]);

        $answer3 = Answer::create([
            'question_id' => $question1->id,
            'number' => 3,
            'text' => 'Шлюмбергера',
        ]);

        $answer4 = Answer::create([
            'question_id' => $question1->id,
            'number' => 4,
            'text' => 'Опунция',
        ]);

        $reaction1 = Reaction::create([
            'answer_id' => $answer3->id,
            'variable_id' => $variable->id,
            'operation' => 'addition',
            'value' => 5,
        ]);

        $pictureQuestion2 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureQuestion2, file_get_contents(resource_path('fixtures/images/FikusLirata.jpg')));

        $questionData2 = [
            'text' => 'Какое растение представлено на фото?',
            'type' => 'only',
            'test_id' => $test->id,
            'number' => 2,
            'picture' => $pictureQuestion2,
        ];

        $question2 = Question::create($questionData2);

        $answer21 = Answer::create([
            'question_id' => $question2->id,
            'number' => 1,
            'text' => 'Драцена',
        ]);

        $answer22 = Answer::create([
            'question_id' => $question2->id,
            'number' => 2,
            'text' => 'Юкка слоновая',
        ]);

        $answer23 = Answer::create([
            'question_id' => $question2->id,
            'number' => 3,
            'text' => 'Фикус Лирата',
        ]);

        $answer24 = Answer::create([
            'question_id' => $question2->id,
            'number' => 4,
            'text' => 'Фикус Бенджамина Кинки',
        ]);

        $reaction2 = Reaction::create([
            'answer_id' => $answer23->id,
            'variable_id' => $variable->id,
            'operation' => 'addition',
            'value' => 5,
        ]);

        $questionData3 = [
            'text' => 'О каком растении в популярной примете говорится: при правильном уходе это растение приносит в дом достаток и финансовое благополучие',
            'type' => 'only',
            'test_id' => $test->id,
            'number' => 3,
        ];

        $question3 = Question::create($questionData3);

        $pictureAnswer31 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureAnswer31, file_get_contents(resource_path('fixtures/images/aloe.jpg')));

        $answer31 = Answer::create([
            'question_id' => $question3->id,
            'number' => 1,
            'picture' => $pictureAnswer31,
        ]);

        $pictureAnswer32 = 'pictures/' . uniqid() . '.jpeg';
        Storage::disk()->put($pictureAnswer32, file_get_contents(resource_path('fixtures/images/manki.jpeg')));

        $answer32 = Answer::create([
            'question_id' => $question3->id,
            'number' => 2,
            'picture' => $pictureAnswer32,
        ]);

        $pictureAnswer33 = 'pictures/' . uniqid() . '.png';
        Storage::disk()->put($pictureAnswer33, file_get_contents(resource_path('fixtures/images/derevo.png')));

        $answer33 = Answer::create([
            'question_id' => $question3->id,
            'number' => 3,
            'picture' => $pictureAnswer33,
        ]);

        $pictureAnswer34 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureAnswer34, file_get_contents(resource_path('fixtures/images/elastika.jpg')));

        $answer34 = Answer::create([
            'question_id' => $question3->id,
            'number' => 4,
            'picture' => $pictureAnswer34,
        ]);

        $reaction3 = Reaction::create([
            'answer_id' => $answer33->id,
            'variable_id' => $variable->id,
            'operation' => 'addition',
            'value' => 5,
        ]);

        $pictureQuestion4 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureQuestion4, file_get_contents(resource_path('fixtures/images/sukkulenty.jpg')));

        $questionData4 = [
            'text' => 'Суккуленты (в переводе с латинского «сочные») — это особый вид растений, способных накапливать воду в листьях и стеблях, чтобы выдерживать периоды долгой засухи. Какое растение относится к данному виду?',
            'type' => 'only',
            'test_id' => $test->id,
            'number' => 4,
            'picture' => $pictureQuestion4,
        ];

        $question4 = Question::create($questionData4);

        $answer41 = Answer::create([
            'question_id' => $question4->id,
            'number' => 1,
            'text' => 'Спатифиллум – это неприхотливое комнатное растение среднего размера с множеством красивых глянцевых темно-зеленых листьев и большими белыми цветками, с длительным периодом цветения до нескольких недель.',
        ]);

        $answer42 = Answer::create([
            'question_id' => $question4->id,
            'number' => 2,
            'text' => 'Фикус Бенджамина – неприхотливое вечнозеленое многолетнее растение. Максимальная высота взрослого растения 250 см. Листовые пластины крупные с заостренными и вытянутыми на конце кончиками, зеленого окраса.',
        ]);

        $answer43 = Answer::create([
            'question_id' => $question4->id,
            'number' => 3,
            'text' => 'Эхеверия. За необычную декоративную красоту и расположение листьев растение называют каменной розой. В диких условиях эхеверия распространена в южных районах США, на территории Мексики и Перу.',
        ]);

        $answer44 = Answer::create([
            'question_id' => $question4->id,
            'number' => 4,
            'text' => 'Пеларгония - многолетние травянистое растение. Стебли прямые или ползучие, ветвистые. Листья простые, пальчатые или пальчато-рассечённые. Цветки разнообразной окраски, собраны в мало- или многоцветковые зонтиковидные соцветия.',
        ]);

        $reaction4 = Reaction::create([
            'answer_id' => $answer43->id,
            'variable_id' => $variable->id,
            'operation' => 'addition',
            'value' => 5,
        ]);

        $pictureQuestion5 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureQuestion5, file_get_contents(resource_path('fixtures/images/kupala.jpg')));

        $questionData5 = [
            'text' => 'Согласно славянским поверьям, это растение цветёт лишь один миг, в ночь накануне Ивана Купалы, сорвать цветок очень трудно, тем более что нечистая сила этому всячески препятствует и запугивает человека, в некоторых случаях лишая рассудка, речи, памяти. О каком растении идет речь?',
            'type' => 'only',
            'test_id' => $test->id,
            'number' => 5,
            'picture' => $pictureQuestion5,
        ];

        $question5 = Question::create($questionData5);

        $pictureAnswer51 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureAnswer51, file_get_contents(resource_path('fixtures/images/bagulnik.jpg')));

        $answer51 = Answer::create([
            'question_id' => $question5->id,
            'number' => 1,
            'text' => 'Багульник болотный',
            'picture' => $pictureAnswer51,
        ]);

        $pictureAnswer52 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureAnswer52, file_get_contents(resource_path('fixtures/images/azalia.jpg')));

        $answer52 = Answer::create([
            'question_id' => $question5->id,
            'number' => 2,
            'text' => 'Азалия',
            'picture' => $pictureAnswer52,
        ]);

        $pictureAnswer53 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureAnswer53, file_get_contents(resource_path('fixtures/images/chvosch.jpg')));

        $answer53 = Answer::create([
            'question_id' => $question5->id,
            'number' => 3,
            'text' => 'Хвощ полевой',
            'picture' => $pictureAnswer53,
        ]);

        $pictureAnswer54 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureAnswer54, file_get_contents(resource_path('fixtures/images/paporotnik.jpg')));

        $answer54 = Answer::create([
            'question_id' => $question5->id,
            'number' => 4,
            'text' => 'Папоротник',
            'picture' => $pictureAnswer54,
        ]);

        $reaction5 = Reaction::create([
            'answer_id' => $answer53->id,
            'variable_id' => $variable->id,
            'operation' => 'addition',
            'value' => 2,
        ]);

        $reaction6 = Reaction::create([
            'answer_id' => $answer54->id,
            'variable_id' => $variable->id,
            'operation' => 'addition',
            'value' => 5,
        ]);

        $pictureQuestion6 = 'pictures/' . uniqid() . '.png';
        Storage::disk()->put($pictureQuestion6, file_get_contents(resource_path('fixtures/images/aroidnyi.png')));

        $questionData6 = [
            'text' => 'Монотипный род растений семейства Ароидные, представленный единственным видом, происходящим из тропической Африки. Название получил из-за схожести листьев с листьями замии.',
            'type' => 'only',
            'test_id' => $test->id,
            'number' => 6,
            'picture' => $pictureQuestion6,
        ];

        $question6 = Question::create($questionData6);

        $pictureAnswer61 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureAnswer61, file_get_contents(resource_path('fixtures/images/opuncia.jpg')));

        $answer61 = Answer::create([
            'question_id' => $question6->id,
            'number' => 1,
            'text' => 'Кактус Опунция',
            'picture' => $pictureAnswer61,
        ]);

        $pictureAnswer62 = 'pictures/' . uniqid() . '.jpeg';
        Storage::disk()->put($pictureAnswer62, file_get_contents(resource_path('fixtures/images/ficus.jpeg')));

        $answer62 = Answer::create([
            'question_id' => $question6->id,
            'number' => 2,
            'text' => 'Фикус',
            'picture' => $pictureAnswer62,
        ]);

        $pictureAnswer63 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureAnswer63, file_get_contents(resource_path('fixtures/images/tolst.jpg')));

        $answer63 = Answer::create([
            'question_id' => $question6->id,
            'number' => 3,
            'text' => 'Толстянка',
            'picture' => $pictureAnswer63,
        ]);

        $pictureAnswer64 = 'pictures/' . uniqid() . '.jpeg';
        Storage::disk()->put($pictureAnswer64, file_get_contents(resource_path('fixtures/images/zamiokulkas.jpeg')));

        $answer64 = Answer::create([
            'question_id' => $question6->id,
            'number' => 4,
            'text' => 'Замиокулькас',
            'picture' => $pictureAnswer64,
        ]);

        $reaction7 = Reaction::create([
            'answer_id' => $answer64->id,
            'variable_id' => $variable->id,
            'operation' => 'addition',
            'value' => 5,
        ]);

        $pictureQuestion7 = 'pictures/' . uniqid() . '.webp';
        Storage::disk()->put($pictureQuestion7, file_get_contents(resource_path('fixtures/images/fikus.webp')));

        $questionData7 = [
            'text' => 'Какой признак указывает на недостаток влаги у растения "Фикус Бенджамина"?',
            'type' => 'only',
            'test_id' => $test->id,
            'number' => 7,
            'picture' => $pictureQuestion7,
        ];

        $question7 = Question::create($questionData7);

        $answer71 = Answer::create([
            'question_id' => $question7->id,
            'number' => 1,
            'text' => 'Появление темных пятен на листьях',
        ]);

        $answer72 = Answer::create([
            'question_id' => $question7->id,
            'number' => 2,
            'text' => 'Увядание и загибание краев листьев',
        ]);

        $answer73 = Answer::create([
            'question_id' => $question7->id,
            'number' => 3,
            'text' => 'Листья начинают желтеть и опадать',
        ]);

        $answer74 = Answer::create([
            'question_id' => $question7->id,
            'number' => 4,
            'text' => 'Образование корневой гнили',
        ]);

        $reaction8 = Reaction::create([
            'answer_id' => $answer73->id,
            'variable_id' => $variable->id,
            'operation' => 'addition',
            'value' => 5,
        ]);

        $pictureQuestion8 = 'pictures/' . uniqid() . '.webp';
        Storage::disk()->put($pictureQuestion8, file_get_contents(resource_path('fixtures/images/spatifilum.webp')));

        $questionData8 = [
            'text' => 'Какой уровень освещения предпочитает растение "Спатифиллум"?',
            'type' => 'only',
            'test_id' => $test->id,
            'number' => 8,
            'picture' => $pictureQuestion8,
        ];

        $question8 = Question::create($questionData8);

        $answer81 = Answer::create([
            'question_id' => $question8->id,
            'number' => 1,
            'text' => 'Прямой солнечный свет',
        ]);

        $answer82 = Answer::create([
            'question_id' => $question8->id,
            'number' => 2,
            'text' => 'Полутень или рассеянный свет',
        ]);

        $answer83 = Answer::create([
            'question_id' => $question8->id,
            'number' => 3,
            'text' => 'Полная тень',
        ]);

        $answer84 = Answer::create([
            'question_id' => $question8->id,
            'number' => 4,
            'text' => 'Яркий искусственный свет',
        ]);

        $reaction9 = Reaction::create([
            'answer_id' => $answer82->id,
            'variable_id' => $variable->id,
            'operation' => 'addition',
            'value' => 5,
        ]);

        $questionData9 = [
            'text' => 'Какое растение с эффектными "разрезными" листьями называют "швейцарским сыром"?',
            'type' => 'only',
            'test_id' => $test->id,
            'number' => 9,
        ];

        $question9 = Question::create($questionData9);

        $answer91 = Answer::create([
            'question_id' => $question9->id,
            'number' => 1,
            'text' => 'Пеперомия',
        ]);

        $answer92 = Answer::create([
            'question_id' => $question9->id,
            'number' => 2,
            'text' => 'Антуриум',
        ]);

        $answer93 = Answer::create([
            'question_id' => $question9->id,
            'number' => 3,
            'text' => 'Филодендрон',
        ]);

        $answer94 = Answer::create([
            'question_id' => $question9->id,
            'number' => 4,
            'text' => 'Монстера',
        ]);

        $reaction10 = Reaction::create([
            'answer_id' => $answer94->id,
            'variable_id' => $variable->id,
            'operation' => 'addition',
            'value' => 5,
        ]);

        $questionData10 = [
            'text' => 'Из-за времени цветения, выпадающего на Рождество и Новый год, а также из-за формы прицветников, у растения есть народное название — «рождественская звезда». Что это за растение?',
            'type' => 'only',
            'test_id' => $test->id,
            'number' => 10,
        ];

        $question10 = Question::create($questionData10);

        $pictureAnswer10 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureAnswer10, file_get_contents(resource_path('fixtures/images/fon.jpg')));

        $answer10 = Answer::create([
            'question_id' => $question10->id,
            'number' => 1,
            'picture' => $pictureAnswer10,
        ]);

        $pictureAnswer11 = 'pictures/' . uniqid() . '.png';
        Storage::disk()->put($pictureAnswer11, file_get_contents(resource_path('fixtures/images/Newflora.png')));

        $answer11 = Answer::create([
            'question_id' => $question10->id,
            'number' => 2,
            'picture' => $pictureAnswer11,
        ]);

        $pictureAnswer12 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureAnswer12, file_get_contents(resource_path('fixtures/images/puassentia.jpg')));

        $answer12 = Answer::create([
            'question_id' => $question10->id,
            'number' => 3,
            'picture' => $pictureAnswer12,
        ]);

        $pictureAnswer13 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureAnswer13, file_get_contents(resource_path('fixtures/images/dekabrist0.jpg')));

        $answer13 = Answer::create([
            'question_id' => $question10->id,
            'number' => 4,
            'picture' => $pictureAnswer13,
        ]);
        $reaction11 = Reaction::create([
            'answer_id' => $answer12->id,
            'variable_id' => $variable->id,
            'operation' => 'addition',
            'value' => 5,
        ]);

        $pictureResult1 = 'pictures/' . uniqid() . '.jpg';
        Storage::disk()->put($pictureResult1, file_get_contents(resource_path('fixtures/images/result1.jpg')));

        $result1 = Result::create([
            'test_id' => $test->id,
            'number' => 1,
            'picture' => $pictureResult1,
            'condition' => 'цветочник >= 40',
            'is_default' => false,
            'text' => 'Позвольте, господин профессор, пожать вам руку.
Вы — Профессор цветоводства!
В мире растений тебе нет равных — ты знаешь их язык, понимаешь их потребности и предугадываешь каждое изменение. Сложные виды, редкие экземпляры, привередливые растения, которые другим кажутся невозможными в уходе, — для тебя это захватывающий вызов и возможность продемонстрировать мастерство. Твой опыт, знания и тонкое чутье превращают твой дом в настоящую лабораторию для экспериментов и миниатюрный ботанический сад.
Ты разбираешься в тонкостях микроклимата, освещения, знаешь оптимальные сочетания удобрений и всегда держишь под рукой профессиональные инструменты для ухода за растениями. Твое увлечение — это не просто хобби, а образ жизни. Растения буквально растут у тебя на глазах, отвечая на твои старания великолепными цветами и здоровьем.

Продолжай делиться своим опытом, вдохновлять окружающих и, возможно, даже расширить свои знания до преподавания или ведения мастер-классов. Вы — профессор в мире цветов, и это звание тебе по праву принадлежит!',
        ]);

        $pictureResult2 = 'pictures/' . uniqid() . '.jpeg';
        Storage::disk()->put($pictureResult2, file_get_contents(resource_path('fixtures/images/result2.jpeg')));

        $result2 = Result::create([
            'test_id' => $test->id,
            'number' => 2,
            'picture' => $pictureResult2,
            'condition' => 'цветочник > 25 && цветочник < 40',
            'is_default' => false,
            'text' => 'Вы — увлеченный цветовод-энтузиаст!

Твои зеленые друзья чувствуют себя великолепно под твоим уходом! Ты уже набрался опыта, знаешь основы и с легкостью справляешься с разнообразными растениями. Твоим подопечным ты обеспечиваешь правильный полив, свет и подкормку, и они отвечают тебе пышной листвой и яркими цветами.

Ты не боишься экспериментов — пробуешь разные виды растений, находишь для каждого свои "лайфхаки" и с удовольствием пополняешь коллекцию. Хотя ты еще не достиг уровня профессионала, тебя уже можно назвать экспертом среди любителей. Возможно, у тебя даже есть мечта о мини-оранжерее или теплице для новых экзотических видов!

Продолжай расширять свои знания, наблюдать за растениями и совершенствовать свои навыки. Кому-то уже кажется, что твой дом — это маленький ботанический сад, а впереди у тебя еще много удивительных открытий в мире растений. Ты уже почти на грани мастерства!',
        ]);

        $pictureResult3 = 'pictures/' . uniqid() . '.jpeg';
        Storage::disk()->put($pictureResult3, file_get_contents(resource_path('fixtures/images/result3.jpeg')));

        $result3 = Result::create([
            'test_id' => $test->id,
            'number' => 3,
            'picture' => $pictureResult3,
            'is_default' => false,
            'condition' => 'цветочник >= 15 && цветочник <= 25',
            'text' => 'Вы — начинающий цветовод!
Ты только делаешь первые шаги в мире растений, и это здорово! Возможно, ты пока не знаешь всех тонкостей ухода за цветами, но у тебя точно есть желание учиться и пробовать что-то новое. Твой путь цветовода только начинается, и впереди много интересных открытий!
Сейчас тебе могут подойти простые и неприхотливые растения, такие как суккуленты, сансевиерии или замиокулькасы — они будут идеальными компаньонами, чтобы набраться опыта и уверенности. Не стесняйся узнавать больше о своих растениях, наблюдать за ними и радоваться каждому новому листочку.
Помни, что любой опыт — это шаг к большему успеху. С каждым днем ты становишься всё более уверенным в уходе за своими зелеными друзьями, и кто знает — возможно, в будущем ты превратишь свое увлечение в настоящее искусство цветоводства!',
        ]);

        $pictureResult4 = 'pictures/' . uniqid() . '.jpeg';
        Storage::disk()->put($pictureResult4, file_get_contents(resource_path('fixtures/images/result4.jpeg')));

        $result4 = Result::create([
            'test_id' => $test->id,
            'number' => 4,
            'picture' => $pictureResult4,
            'condition' => 'цветочник >= 0 && цветочник < 15',
            'is_default' => false,
            'text' => 'Вы — мастер выживания растений!
Ты настоящий специалист по кактусам! Эти стойкие и независимые растения как будто созданы для тебя. В мире цветоводства ты предпочитаешь минимализм и надежность — те, кто умеют выживать в любых условиях, просто идеально вписываются в твой стиль жизни.
Твой кактус — это не просто растение, это верный и неприхотливый друг, который ценит твой подход. Полив раз в месяц? Легко. Много света и немного заботы? Это твой стиль! Возможно, у тебя не всегда получается вырастить капризные фиалки или орхидеи, но твой кактус всегда рядом, радует зелеными иголками и сохраняет отличное настроение, даже если ты немного забываешь о нем.
Помни: даже у самых опытных цветоводов порой не получается создать идеальные условия для капризных растений. Твой талант заботиться о тех, кто умеет выживать, — это тоже особый навык. Ведь кактусы тоже могут цвести, и твое терпение и легкость в уходе рано или поздно обязательно принесут результаты!',
        ]);
        DB::commit();
    }
}
