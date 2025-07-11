@extends('layouts.player')

@section('title', $takingTest->test->title)
@section('description', $takingTest->test->meta_description)
@section('keywords', $takingTest->test->meta_keywords)

@section('og_title', 'Мой результат теста: ' . $takingTest->test->title)
@section('og_description', $takingTest->generated_text_result)
@section('og_image',$takingTest->generated_picture_result ? Storage::url($takingTest->generated_picture_result) : asset('images/logo.webp'))
@section('og_url',url()->current())




@section('result')

    <div class="main-result">

        <div class=" result-container">

            <div class="w-100 d-flex justify-content-end">
                <div class="btn-result-back-catalog">
                    @if($takingTest->is_temporary === false)
                        <a href="{{ route('catalog')  }}" style="text-decoration: none; color: inherit;">
                            <i class="fa-solid fa-xmark fa-2xl"></i>
                        </a>
                    @else
                        <a href="{{route("{$currentUserRole}.tests.show", $takingTest->test)}}"
                           style="text-decoration: none; color: inherit;">
                            <i class="fa-solid fa-xmark fa-2xl"></i>
                        </a>
                    @endif
                </div>
            </div>

            <div class="result-body">
                @if($takingTest->is_temporary === true)
                    <div class="alert alert-warning mt-2" role="alert">
                        Вы находитесь в режиме предпросмотра результата теста. В этом режиме результат не сохраняется, а
                        поделиться им невозможно. Для дальнейших действий вернитесь в личный кабинет.
                        <a href="{{route("{$currentUserRole}.tests.show", $takingTest->test)}}" class="alert-link">Личный
                            кабинет</a>
                    </div>
                @endif

                <div class="test-categories-container text-center">
                    @foreach($takingTest->test->categories as $category)
                        <a href="{{ route('catalog', ['category_id' => $category->id]) }}"> <span
                                class="btn  btn-sm mb-2 btn-test-categories">{{$category->title}}</span></a>
                    @endforeach
                </div>

                <div class="test-title-result text-center">
                    <p>Результат теста: "{{$takingTest->test->title}}"<p>
                </div>

                <div class="d-grid  col-lg-2 col-md-4 col-6 col-sm-6 mx-auto mb-3">
                    <a class="btn btn-lg btn-repeat" href="{{ route('player.open', ['slug' => $slug]) }}" role="button">
                        @if ((auth()->check() && auth()->id() === $takingTest->user_id) ||
      (!$takingTest->user_id && (string) $takingTest->guest_id === (string) session()->get('guest_id')))
                            Пройти еще раз
                        @else
                            Пройти тест
                        @endif
                    </a>
                </div>

                <div class="row flex-lg-row align-items-center g-5 py-5">
                    @if($takingTest->generated_picture_result)
                        <div class="image-container-result  container-fluid  col-10">
                            <img src="{{ Storage::url($takingTest->generated_picture_result)}}"
                                 class="d-block mx-lg-auto  result-image img-fluid" alt="Result Image" loading="lazy">
                        </div>
                    @endif
                    @if($takingTest->generated_text_result)
                        <div class="col-lg-10 col-sm-12 container-fluid">
                            @if(strlen($takingTest->generated_text_result)<60)
                                <p lang="ru" class="result-text lead text-center">
                                {!! nl2br(e($takingTest->generated_text_result)) !!}
                            </p>
                            @else
                                <p lang="ru" class="result-text lead">
                                    {!! nl2br(e($takingTest->generated_text_result)) !!}
                                </p>
                            @endif

                        </div>
                    @endif
                </div>

                <div class="result-share text-center">
                    <p> Поделитесь результатом теста c друзьями:</p>
                    <div class="share-button"
                         @if($takingTest->is_temporary !== false)
                             style="pointer-events: none; opacity: 0.5"
                        @endif
                    >
                        @include('partial.share_button', ['shareUrl'=>$shareUrl])
                    </div>
                    <div class="test-tags-container text-center">
                        @foreach($takingTest->test->tags as $tag)
                            <a href="{{ route('catalog', ['tag_id' => $tag->id]) }}"> <span
                                    class="badge  mb-1 test-tags"> <i
                                        class="fa-solid fa-hashtag fa-sm"></i>{{$tag->name}}</span></a>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        </div>

@endsection

