@extends('layouts.catalog')
@section('title', 'Авторы тестов - поиск тестов по авторам')
@section('description', 'Познакомьтесь с авторами тестов на платформе. Узнайте, кто создал интересные и познавательные тесты, и выберите любимые тесты по их авторам.')
@section('keywords', 'авторы тестов, поиск тестов, создатели тестов, лучшие тесты, интересные тесты, платформа тестов, пройти тест, найти тест')

@section('og_title', 'Авторы тестов - поиск тестов по авторам')
@section('og_description', 'Познакомьтесь с авторами тестов на платформе. Узнайте, кто создал интересные и познавательные тесты, и выберите любимые тесты по их авторам.')
@section('og_image',asset('images/logo.webp'))
@section('og_url',url()->current())

@section('authors')
    <div class="position-relative overflow-hidden p-1  text-center">
        <h1 class="title-author">Авторы тестов</h1>
        <h2 class="description-author">На этой странице представлены авторы, создающие уникальные тесты.
            <br> Вы можете найти интересные тесты, сгруппированные по авторам, а также воспользоваться поиском, чтобы быстро найти тесты любимого автора</h2>
    </div>

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <form method="GET" action="{{ route('catalog.authors') }}" class="position-relative">
                    <div class="card-body row align-items-center">
                        <div class="col-12">
                            <div class="position-relative">
                                <input id="search-input" class="form-control form-control-lg form-control-borderless"
                                       type="search" name="q" value="{{ old('q', $q) }}"
                                       placeholder="Поиск по авторам">
                                <div class="search-icon">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="position-relative overflow-hidden p-1 p-md-5 m-md-3">

            @if($authors->isEmpty())
                <div class="col-12 text-center search-no-return">
                    <p class="text-muted lead">&#129335; Автор не найден</p>
                </div>
            @else

                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6  mb-1 mb-sm-0">
                                <div class="dropdown">
                                    <div class="dropdown-header">
                                        @switch($sortBy)
                                            @case('popular')
                                                Популярные
                                                @break
                                            @case('new_author')
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
                                        <div class="dropdown-item {{ $sortBy === 'popular' ? 'checked' : '' }}"
                                             data-sort="popular">Популярные</div>
                                        <div class="dropdown-item {{ $sortBy === 'new_author' ? 'checked' : '' }}"
                                             data-sort="new_author">Новые</div>
                                        <div class="dropdown-item {{ $sortBy === 'alphabet_asc' ? 'checked' : '' }}"
                                             data-sort="alphabet_asc">По алфавиту А-Я</div>
                                        <div class="dropdown-item {{ $sortBy === 'alphabet_desc' ? 'checked' : '' }}"
                                             data-sort="alphabet_desc">По алфавиту Я-А</div>
                                    </div>
                                </div>

                            </div>

                    </div>

            <div class="row authors-card">
                    @foreach($authors as $author)
                    <div class="col-sm-6  mb-1 mb-sm-0">
                        <div class="card card-author">
                            <div class="card-body">
                                <h4 class="card-title">{{$author->name}}</h4>
                                <p class="card-text count-test">Количество тестов
                                    <span class="badge bg-secondary rounded-pill">{{$author->active_tests_count}}</span>
                                </p>
                                <a href="{{ route('catalog', ['author_id' => $author->id]) }}" class="btn btn-look-test btn-sm">Смотреть тесты</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>


            @endif
        </div>

    </div>
    <div class="container d-flex justify-content-center mt-5">
        {{ $authors->links() }}
    </div>
    <script>
        document.querySelector('.dropdown-header').addEventListener('click', function () {
            const dropdown = this.parentElement;
            dropdown.classList.toggle('open');
        });



        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function () {
                const sort = this.dataset.sort;
                const url = new URL(window.location.href);
                url.searchParams.set('sort_by', sort);
                window.location.href = url.toString();
            });
        });

    </script>
@endsection
