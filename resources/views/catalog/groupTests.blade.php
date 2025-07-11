@extends('layouts.catalog')
@section('title',$group->title)
@section('description', $group->description)
@section('keywords', 'подборки тестов, различные темы, группа тестов, лучшие тесты, тесты по интересам, развлекательные тесты, найти тест')

@section('og_title', $group->title)
@section('og_description', $group->description)
@section('og_image', Storage::url($group->picture))

@section('og_url',url()->current())

@section('content')
        <div class="position-relative overflow-hidden p-3  text-center ">
            <h1 class="title-group-test">{{$group->title}}</h1>
            <h2 class="description-groups">{{$group->description}}</h2>
        </div>

        <div class="position-relative overflow-hidden p-1 p-md-2 m-md-3 text-center ">
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
                                            <p >Пройден {{$test->takings()->count()}}
                                                раз</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        </div>

@endsection
