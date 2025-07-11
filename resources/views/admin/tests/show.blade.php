@extends('layouts.app')

@section('content_header')

    @if($test->moderation && $test->moderation->isRejection()  &&  $test->user->isAuthor())
        <div class="alert alert-warning" role="alert">
            <strong>Внимание!</strong>
            <br>
            <p> Тест не прошел модерацию и не был опубликован в каталоге. Исправьте тест в соответствии с указанными причинами и повторно отправьте на модерацию. <p>
            <p><strong>Причина отказа:</strong> {{$test->moderation->rejection_reason}}</p>
        </div>
        <hr>
    @endif

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.test')}}: {{$test->title}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.show", $test)}}
            </div>
        </div>
    </div>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-th-large mr-1"></i> {{__('common.test card')}}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: block;">

                            <strong><i class="fa fa-file-image mr-2"></i>{{__('common.test cover')}}</strong>

                            <div class="row mt-4">
                                <div class="col-sm-4">
                                    <div class="position-relative">
                                        <img src="{{ Storage::url($test->picture)}}" alt="Photo 1"
                                             class="img-fluid img-thumbnail" width="300" height="300">
                                    </div>

                                </div>
                            </div>
                            <hr>
                            <strong><i class="fa fa-paragraph mr-2"></i>{{__('common.title')}}</strong>
                            <p class="text-muted">
                                {{$test->title}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-paragraph mr-2"></i>{{__('common.slug')}}</strong>
                            <p class="text-muted">
                                {{$test->slug}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-paragraph mr-2"></i>{{__('common.description')}}</strong>
                            <p class="text-muted">
                                {{$test->description}}
                            </p>
                            <hr>
                            @if($test->background_image)
                                <strong><i class="fa fa-file-image mr-2"></i>{{__('common.background_image')}}</strong>
                                <div class="row mt-4">
                                    <div class="col-sm-4">
                                        <div class="position-relative">
                                            <img src="{{ Storage::url($test->background_image)}}" alt="Photo 2"
                                                 class="img-fluid img-thumbnail" width="300">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endif
                            <strong><i class="fa fa-paragraph mr-2"></i>{{__('common.design theme')}}</strong>
                            <p class="text-muted">
                                {{$test->theme->title}}
                            </p>

                            @if(auth()->user()->isAdmin())

                                <strong><i class="fa fa-paragraph mr-2"></i>{{__('common.meta-tags keywords')}}</strong>
                                <p class="text-muted">
                                    {{$test->meta_keywords}}
                                </p>
                                <hr>
                                <strong><i class="fa fa-paragraph mr-2"></i>{{__('common.meta-tags description')}}
                                </strong>
                                <p class="text-muted">
                                    {{$test->meta_description}}
                                </p>
                            @endif
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.created_at')}}</strong>
                            <p class="text-muted">
                                {{$test->created_at}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.updated_at')}}</strong>
                            <p class="text-muted">
                                {{$test->updated_at}}
                            </p>
                            <hr>
                            @if(auth()->user()->isAdmin())
                            <strong><i class="fa fa-user mr-2"></i>{{__('common.author test')}}</strong>
                            <p class="text-muted">
                                <a href="{{route("admin.users.show", $test->user_id)}}"> {{$test->user->name}}</a>
                            </p>
                            <hr>
                            @endif
                            <strong><i class="fa fa-list mr-2"></i>{{__('common.categories')}}</strong>
                            <p class="text-muted">
                                @foreach($test->categories  as $category)
                                    <li>
                                        <a href="{{route("{$currentUserRole}.tests.index", ['categories[]' => $category->id])}}">{{$category->title}}</a>
                                    </li>
                                @endforeach
                            </p>
                            <hr>
                            <strong><i class="fa fa-tag mr-2"></i>{{__('common.tags')}}</strong>
                            <p class="text-muted">
                                @foreach($test->tags as $tag)
                                    <a class="btn btn-xs btn-outline-success"
                                       href="{{route("{$currentUserRole}.tests.index",['tags[]' => $tag->id,])}}">
                                        <i class="fas fa-hashtag"></i>{{$tag->name}}</a>
                                @endforeach
                            </p>
                            <hr>
                            @if($test->isModeration())
                            <div class="alert alert-warning" role="alert">
                                {{__('common.Attention! Moderation test')}}
                            </div>
                            <hr>
                            @endif
                            @if($test->isActive())
                                <div class="alert alert-success" role="alert">
                                    {{__('common.Active test')}}
                                </div>
                                <hr>
                            @endif




                                <div class="row gap-2">
                                    <!-- Кнопка "Закрыть" -->
                                    <div class="col-12 d-flex flex-column flex-md-row flex-lg-row justify-content-md-start ">
                                        <a href="{{ route("{$currentUserRole}.tests.index") }}" rel="noopener" target="_blank"
                                           class="btn btn-secondary mb-2 mr-lg-2 mr-md-2">
                                            {{ __('common.close') }}
                                        </a>


                                    <!-- Кнопка "Редактировать" -->
                                        @if($test->isDraft())
                                            <a href="{{ route("{$currentUserRole}.tests.edit", $test->id) }}"
                                               class="btn btn-info mb-2 mr-lg-2 mr-md-2">
                                                {{ __('common.edit') }}
                                            </a>
                                        @else
                                            @include('partial.button_no_edit')
                                        @endif

                                    @if($test->questions->isNotEmpty() &&
                                        $test->results->isNotEmpty() &&
                                        $test->questions->contains(fn($question) => $question->answers->isNotEmpty()))

                                        @if($test->isDraft() || $test->isModeration())
                                                <a href="{{ route('player.open', $test->slug) }}"
                                                   class="btn btn-info mb-2 mr-lg-2 mr-md-2">
                                                    {{ __('common.preview test') }}
                                                </a>
                                        @endif

                                        @if($test->isDraft() && $test->user->isAuthor())
                                                <a href="{{ route("{$currentUserRole}.tests.submit_moderation", $test->id) }}"
                                                   class="btn btn-success mb-2 mr-lg-2 mr-md-2">
                                                    {{ __('common.submit for moderation') }}
                                                </a>
                                        @elseif($test->isDraft() && $test->user->isAdmin())
                                                <a href="{{ route('admin.tests.publish', $test->id) }}"
                                                   class="btn btn-success mb-2 mr-lg-2 mr-md-2">
                                                    {{ __('common.publish test') }}
                                                </a>
                                        @elseif($test->isActive() || $test->isModeration())
                                                <a href="{{ route("{$currentUserRole}.tests.return_draft", $test->id) }}"
                                                   class="btn btn-info mb-2 mr-lg-2 mr-md-2 ">
                                                    {{ __('common.to draft') }}
                                                </a>
                                        @endif

                                    @endif
                                    </div>
                                </div>











                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.tests.content.questions')
        @include('admin.tests.content.variables')
        @include('admin.tests.content.result')

    </section>

@endsection

@push('js')

    @include('partial.sortable',[
    'updateSequenceUrl'=>route("{$currentUserRole}.tests.question_sequence", $test),
    'selector'=>'#myTable',
])
    @include('partial.sortable',[
        'updateSequenceUrl'=>route("{$currentUserRole}.tests.result_sequence", $test),
        'selector'=>'#myTableResults',
    ])

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            var showDeletedQuestionsBtn = document.getElementById('show-deleted-questions');
            var showDeletedVariablesBtn = document.getElementById('show-deleted-variables');

            var questionsTable = document.querySelector('#myTable tbody');
            if (!questionsTable || questionsTable.children.length === 0) {
                if (showDeletedQuestionsBtn) {
                    showDeletedQuestionsBtn.style.display = 'none';
                }
            }
            var variablesTable = document.querySelector('#myTableVariables tbody');
            if (!variablesTable || variablesTable.children.length === 0) {
                if (showDeletedVariablesBtn) {
                    showDeletedVariablesBtn.style.display = 'none';
                }
            }

        });

    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Получаем сохраненную позицию скролла
            const scrollPosition = sessionStorage.getItem("scrollPosition");
            if (scrollPosition !== null) {
                // Используем requestAnimationFrame для плавности
                requestAnimationFrame(() => {
                    window.scrollTo({ top: parseInt(scrollPosition, 10), behavior: "smooth" });
                });
            }
        });

        window.addEventListener("beforeunload", function () {
            // Сохраняем текущую позицию прокрутки перед уходом
            sessionStorage.setItem("scrollPosition", window.scrollY);
        });

        // Обработчик кликов для кнопок и ссылок
        document.addEventListener("click", function (event) {
            if (event.target.tagName === "A" || event.target.tagName === "BUTTON") {
                sessionStorage.setItem("scrollPosition", window.scrollY);
            }
        });

        // Обработчик для кнопки "Закрыть" или "Назад"
        document.querySelectorAll('.btn-back').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Предотвращаем мгновенный переход
                const url = this.getAttribute('href'); // Получаем ссылку

                // Плавно скроллим вверх
                window.scrollTo({ top: 0, behavior: "smooth" });

                // Ждем 300 мс, затем переходим по ссылке
                setTimeout(() => {
                    window.location.href = url;
                }, 300);
            });
        });
    </script>
@endpush



