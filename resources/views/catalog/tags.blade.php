@extends('layouts.catalog')
@section('title', 'Каталог тегов — Найдите тест по интересующим вас темам')
@section('description', 'Откройте для себя каталог тегов нашей платформы и найдите тесты, которые соответствуют вашим интересам. Удобный поиск по тегам поможет вам выбрать тесты на любые темы — от хобби и психологии до профессиональных навыков.')
@section('keywords', 'каталог тегов, все теги тестов, теги, хэштеги, поиск по тегам, любые темы, платформа тестов, выбрать теги, найти тест, пользовательские теги, тесты по интересам')

@section('og_title', 'Каталог тегов — Найдите тест по интересующим вас темам')
@section('og_description', 'Откройте для себя каталог тегов нашей платформы и найдите тесты, которые соответствуют вашим интересам. Удобный поиск по тегам поможет вам выбрать тесты на любые темы — от хобби и психологии до профессиональных навыков.')
@section('og_image',asset('images/logo.webp'))

@section('og_url',url()->current())

@section('tags')
    <div class="position-relative overflow-hidden p-3  text-center">
        <h1 class="title-tags">Все теги</h1>
        <h2 class="description-tags">Найдите тесты по тегам, которые вас интересуют</h2>
    </div>

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <form method="GET" action="{{ route('catalog.tags') }}" class="position-relative">
                    <div class="card-body row align-items-center">
                        <div class="col-12">
                            <div class="position-relative">
                                <input id="search-input" class="form-control form-control-lg form-control-borderless"
                                       type="search" name="q" value="{{ old('q', $q) }}"
                                       placeholder="Поиск по тегам">
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
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3">

        @if($tags->isEmpty())
            <div class="col-12 text-center search-no-return">
                <p class="text-muted lead">&#129335; Тег не найден</p>
            </div>
        @else


        <div class="container-tags">
            <div class="row">
                <div class="col">
                    @foreach($tags as $tag)
                        <a href="{{ route('catalog', ['tag_id' => $tag->id]) }}" class="btn btn-tag mb-1 btn-sm ">
                            <span><i class="fa-solid fa-hashtag fa-sm" style="color: #ffffff;"></i>{{ $tag->name }}</span>
                         <span class="badge bg-secondary rounded-pill">{{$tag->active_tests_count}}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        @endif
    </div>
    <div class="container d-flex justify-content-center mt-5">
        {{ $tags->links() }}
    </div>





@endsection

