@extends('layouts.catalog')
@section('title', 'О проекте Корпорация тестов')
@section('description', '"Корпорация тестов" — это платформа, которая позволяет пользователям не только отвечать на вопросы, но и разрабатывать собственные тесты на любые темы с уникальными настройками, визуальным оформлением и логикой подсчёта результатов.')
@section('keywords', 'создание тестов, создать тест онлайн, простое создание тестов, создать тест быстро, интересные тесты, платформа тестов, конструктор тестов')

@section('og_title', 'О проекте Корпорация тестов')
@section('og_description', '"Корпорация тестов" — это платформа, которая позволяет пользователям не только отвечать на вопросы, но и разрабатывать собственные тесты на любые темы с уникальными настройками, визуальным оформлением и логикой подсчёта результатов.')
@section('og_image',asset('images/logo.webp'))
@section('og_url',url()->current())


@section('content')
    <div class="container col-xxl-8 px-4 py-4">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3 text-center title-create-test">О проекте</h1>

        <div class="row flex-lg-row-reverse align-items-center g-3 py-3">
            <div class="col-12 col-lg-4 d-none d-lg-flex justify-content-center">
                <img src="/images/logo.webp" class="d-block mx-lg-auto img-fluid rounded-circle " alt="logo" width="300" height="300" loading="lazy">
            </div>
            <div class="col-lg-8">
                <p lang="ru" class="project-description lead"><strong>"Корпорация тестов"</strong> — это платформа, которая позволяет пользователям не только отвечать на вопросы, но и разрабатывать собственные тесты на любые темы с уникальными настройками, визуальным оформлением и логикой подсчёта результатов.
                </p>
                <div class="mb-4 text-center">
                    <p class="mb-4">
                        <strong class="h4" style="color: rgb(43,33,136);">✨ Что предлагает "Корпорация тестов"? ✨</strong>
                    </p>
                </div>

                <p  lang="ru" class="project-description lead">&#128995; <strong>Создание тестов &#128221;</strong><br>
                    Удобный конструктор для авторов, с возможностью создавать вопросы не только с текстовыми вариантами ответов, но и с выбором изображений, а также комбинировать текст и картинки, делая тесты более наглядными и увлекательными.</p>

                <p lang="ru" class="project-description lead">&#128995; <strong>Прохождение тестов &#9989;</strong><br> Понятный интерфейс с адаптивным дизайном для комфортного прохождения на любом устройстве.</p>

                <p lang="ru" class="project-description lead">&#128995; <strong>Статистика тестов &#128202;</strong><br> Наглядные графики с динамикой прохождений за текущий и прошлый месяц, рейтинг авторов и список самых популярных тестов. Это поможет определить, какие тесты привлекают больше всего внимания и заинтересовать еще больше пользователей.</p>

                <p lang="ru" class="project-description lead">&#128995; <strong>Персонализация &#127912; &#10024;</strong><br> Настройка тем оформления для тестов и удобный способ делиться результатами с друзьями.</p>

        </div>
            <div class="col-12">
                <div class="mb-4 text-center">
                    <p class="lead mb-4">
                        <strong class="h4" style="color: rgb(43,33,136);">✨ Идея создания ✨</strong>
                    </p>
                </div>

                <div class="px-lg-6">
                    <div class="d-flex align-items-start mb-4">
                                    <p lang="ru" class="project-description lead">Мои друзья часто делились интересными тестами, это стало нашей традицией — находить и проходить что-то новое, обсуждать результаты и весело проводить время.<br> Тогда и появилась идея: а что, если создать свою платформу, где каждый сможет легко разрабатывать и делиться собственными тестами?<br>
                                        Так появилась <strong> "Корпорация тестов"</strong> благодаря моей увлеченности к тестам.</p>
                    </div>

                    <div class="align-items-start mb-4 bg-light rounded-3 p-4">
                        <p lang="ru" class="project-description lead">
                            Этот проект — не просто площадка для тестов, но и моя
                            <strong>личная практика в программировании 👩💻</strong><br>
                            Разрабатывая "Корпорацию тестов", я совершенствую навыки
                            и воплощаю интересные идеи в жизнь.
                        </p>
                        <p lang="ru" class="project-description lead">
                            В будущем сервис продолжит развиваться: появятся новые функции,
                            улучшится удобство использования, а тесты станут ещё более интерактивными.
                        </p>
                </div>
                    <div class="text-center mt-5">
                         <p class="fw-bold" style="font-size: 1.25rem; line-height: 1.7;">
                            Моя цель — сделать "Корпорацию тестов" местом, где каждый сможет раскрыть свою креативность в создании тестов
                            <span class="ms-2">🚀</span>
                        </p>
                        <img src="/images/chaika.png" class="d-block mx-lg-auto img-fluid" alt="logo" width="500"  loading="lazy">
                    </div>
            </div>

        </div>

@endsection
