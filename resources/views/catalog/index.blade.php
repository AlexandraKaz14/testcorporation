@extends('layouts.catalog')
@section('title', 'Каталог тестов — Откройте мир знаний и развлечений')
@section('description', 'Исследуйте наш каталог увлекательных тестов на разные темы. Найдите тест по душе или создайте собственный, чтобы делиться с друзьями!')
@section('keywords', 'тесты онлайн, различные тесты,лучшие тесты, развлечение, обучение, пройти тест, найти тест, создать свой тест, платформа тестов')

@section('og_title', 'Каталог тестов — Откройте мир знаний и развлечений')
@section('og_description', 'Исследуйте наш каталог увлекательных тестов на разные темы. Найдите тест по душе или создайте собственный, чтобы делиться с друзьями!')
@section('og_image',asset('images/logo.webp'))
@section('og_url',url()->current())




@section('content')
        <div class="position-relative overflow-hidden p-1 p-md-2 m-md-3  text-center ">
            <div class="container-fluid">
                <h1 class="title-catalog">Каталог тестов онлайн</h1>
                <h2 class="description-catalog">Каталог увлекательных тестов на различные темы</h2>
                <div class="row text-center btn-categories">
                    <div class="col">
                        @foreach($categories as $category)
                            <a href="{{ $categoryId == $category->id ? route('catalog',  request()->except('category_id')) : route('catalog', ['category_id' => $category->id] +request()->query() )  }}"
                               class="btn btn-outline-dark mb-1 {{ $categoryId == $category->id ? 'active' : '' }}">
                                {{ $category->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @include('catalog.search')

        <div class="position-relative overflow-hidden p-1 p-md-2 m-md-3 text-center ">

            <div class="container-fluid mt-2">
                <div class="row row-cols-1 row-cols-md-1 row-cols-lg-4 g-3">
                    <div class="col">
                            <div class="dropdown">
                                <div class="dropdown-header">
                                    @switch($sortBy)
                                        @case('popular_all_time')
                                            Популярные за все время
                                            @break
                                        @case('popular_day')
                                            Популярные за день
                                            @break
                                        @case('popular_week')
                                            Популярные за неделю
                                            @break
                                        @case('popular_month')
                                            Популярные за месяц
                                            @break
                                        @case('new_test')
                                            Новые
                                            @break
                                        @case('alphabet_asc')
                                            По алфавиту А-Я
                                            @break
                                        @case('alphabet_desc')
                                            По алфавиту Я-А
                                            @break
                                        @default
                                            Сортировать
                                    @endswitch

                                </div>
                                <div class="dropdown-list">
                                    <div class="dropdown-item {{ $sortBy === 'popular_all_time' ? 'checked' : '' }}"
                                         data-sort="popular_all_time">Популярные за все время
                                    </div>

                                    <div class="dropdown-item {{ $sortBy === 'popular_day' ? 'checked' : '' }}"
                                         data-sort="popular_day">Популярные за день
                                    </div>
                                    <div class="dropdown-item {{ $sortBy === 'popular_week' ? 'checked' : '' }}"
                                         data-sort="popular_week">Популярные за неделю
                                    </div>
                                    <div class="dropdown-item {{ $sortBy === 'popular_month' ? 'checked' : '' }}"
                                         data-sort="popular_month">Популярные за месяц
                                    </div>
                                    <div class="dropdown-item {{ $sortBy === 'new_test' ? 'checked' : '' }}"
                                         data-sort="new_test">Новые
                                    </div>
                                    <div class="dropdown-item {{ $sortBy === 'alphabet_asc' ? 'checked' : '' }}"
                                         data-sort="alphabet_asc">По алфавиту А-Я
                                    </div>
                                    <div class="dropdown-item {{ $sortBy === 'alphabet_desc' ? 'checked' : '' }}"
                                         data-sort="alphabet_desc">По алфавиту Я-А
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
                </div>

            @if($selectedTagName)
                <div class="info-selected">
                    Тесты выбраны по тегу:
                    <a href="{{route('catalog',request()->except('tag_id'))}}">    <span class="badge info-selected-author-tag"> <i class="fa-solid fa-hashtag fa-sm"></i>{{$selectedTagName}}
                                <i class="fa-solid fa-xmark fa-lg"></i></span></a>
                </div>
            @endif
            @if($selectedAuthorName)
                <div class="info-selected">
                    Тесты выбраны по автору: <a
                        href="{{route('catalog',request()->except('author_id'))}}"> <span class="badge info-selected-author-tag">{{$selectedAuthorName}} <i
                                class="fa-solid fa-xmark fa-lg"></i></span>
                    </a>
                </div>
            @endif


                @if($tests->isEmpty())
                    <div class="col-12 text-center search-no-return">
                        <p class="text-muted lead">&#129335; Тест не найден</p>
                    </div>
                @endif

                <div class="container-fluid my-4">
                    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-6 g-3">
                        @foreach($tests as $test)

                            <div class="col">
                                <a href="{{ route('player.open', ['slug' => $test->slug]) }}"
                                   class="text-decoration-none text-dark">
                                    <div class="collection-card position-relative">
                                        <img src="{{ Storage::url($test->picture) }}" alt="Collection Image">

                                        <div class="collection-card-body">
                                            <h5 class="group-card-title">{{$test->title}}</h5></div>

                                        <div class="card-footer count-taking-test bg-transparent border-success">
                                            @switch($sortBy)
                                                @case('popular_day')
                                                    <p>
                                                        Пройден {{$test->takingsSubDay()->count()}} раз</p>
                                                    @break
                                                @case('popular_week')
                                                    <p>
                                                        Пройден {{$test->takingsSubWeek()->count()}} раз</p>
                                                    @break
                                                @case('popular_month')
                                                    <p>
                                                        Пройден {{$test->takingsSubMonth()->count()}} раз</p>
                                                    @break
                                                @default
                                                    <p >Пройден {{$test->takings()->count()}}
                                                        раз</p>
                                            @endswitch
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
        </div>

        <div class="container d-flex justify-content-center mt-5">
            {{ $tests->links() }}
        </div>



    <script>
        document.querySelector('.dropdown-header').addEventListener('click', function () {
            const dropdown = this.parentElement;
            dropdown.classList.toggle('open');
        });

        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function () {
                document.querySelectorAll('.dropdown-item').forEach(i => i.classList.remove('checked'));
                this.classList.add('checked');
                document.querySelector('.dropdown-header').textContent = this.textContent;
                document.querySelector('.dropdown').classList.remove('open');
            });
        });

        function cardAutoHeight() {
            let maxH = Math.max(...Array.from(document.querySelectorAll('.test-card')).map(o => o.offsetHeight))
            document.querySelectorAll('.test-card').forEach((e) => {
                e.style.height = maxH + 'px';
            })
        }

        window.addEventListener('load', cardAutoHeight);
        window.addEventListener('resize', cardAutoHeight);


        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function () {
                const sortBy = this.dataset.sort;
                const url = new URL(window.location.href);
                url.searchParams.set('sort_by', sortBy);
                window.location.href = url.toString();
            });
        });
    </script>

@endsection
