@extends('layouts.catalog')
@section('title', 'Тематические подборки тестов — Исследуйте лучшие тесты по различным темам')
@section('description', 'Откройте уникальные подборки тестов, собранные по различным темам: психология, развлечение, профессиональные навыки и многое другое. Найдите тесты, которые подходят именно вам, и делитесь результатами с друзьями!')
@section('keywords', 'подборки тестов, различные темы, группа тестов, лучшие тесты, тесты по интересам, развлекательные тесты, найти тест')

@section('og_title', 'Тематические подборки тестов — Исследуйте лучшие тесты по различным темам')
@section('og_description', 'Откройте уникальные подборки тестов, собранные по различным темам: психология, развлечение, профессиональные навыки и многое другое. Найдите тесты, которые подходят именно вам, и делитесь результатами с друзьями!')
@section('og_image',asset('images/logo.webp'))
@section('og_url',url()->current())

@section('groups')
    <div class="position-relative overflow-hidden p-3  text-center">
        <h1 class="title-groups">Тематические подборки тестов</h1>
        <h2 class="description-groups">Лучшие тесты, собранные для вас</h2>
    </div>
            <div class="position-relative overflow-hidden p-3">
                <div class="container py-4">
                    <div class="row g-2">
                        @foreach($groups as $group)
                            <div class="col-12">
                                <a href="{{ route('catalog.open_groups', ['slug' => $group->slug]) }}"
                                   class="text-decoration-none text-dark">
                                <div class="card card-group-tests mb-3 w-100">
                                    <div class="row g-0">
                                        <div class="col-md-2">
                                            <img src="{{ Storage::url($group->picture) }}"
                                                 class="img-fluid rounded-start card-image-group"
                                                 alt="{{ $group->title }}">
                                            @if($group->created_at && $group->created_at->diffInDays(now()) <= 7)
                                                <span class="badge text-bg-warning position-absolute top-0 start-0 m-2">Новая подборка</span>
                                            @endif
                                        </div>
                                        <div class="col-md-10">
                                            <div class="card-body d-flex flex-column">
                                                    <h5 class="card-title card-title-group">{{ $group->title }}</h5>
                                                    <p class="card-text text-group">{{ mb_strlen($group->description) > 120 ?
                    mb_substr($group->description, 0, 119) . '...' :
                    $group->description}}</p>
                                                <p class="card-text">
                                                    <small class="text-muted ">Тестов в подборке: {{ $group->tests->count() }}</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    <div class="container d-flex justify-content-center mt-5">
        {{ $groups->links() }}
    </div>
@endsection








