@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.answer')}} № {{$answer->number}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.questions.answers.show", $answer)}}
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
                            <h3 class="card-title"><i class="fa fa-th-large mr-1"></i> {{__('common.answer card')}}</h3>
                        </div>
                        <div class="card-body">

                            <strong><i class="fa fa-file-image mr-2"></i>{{__('common.picture')}}</strong>

                            <div class="row mt-4">
                                <div class="col-sm-4">
                                    <div class="position-relative">
                                        @if($answer->picture)
                                            <img src="{{ Storage::url($answer->picture) }}" alt="Photo 1"
                                                 class="img-fluid img-thumbnail" width="300" height="300">
                                        @else
                                            <p>---</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <strong>№ {{__('common.number answer')}}</strong>
                            <p class="text-muted">
                                {{$answer->number}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-pencil mr-2"></i>{{__('common.text answer')}}</strong>
                            @if($answer->text)
                                <p class="text-muted">
                                    {{$answer->text}}
                                </p>
                            @else
                                <p>---</p>
                            @endif
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.created_at')}}</strong>
                            <p class="text-muted">
                                {{$answer->created_at}}
                            </p>

                            <hr>
                            <strong><i class="fa fa-question mr-2"></i>{{__('common.question')}}</strong>
                            <p class="text-muted">
                                <a href="{{route("{$currentUserRole}.tests.questions.show", $answer->question_id)}}"> {{$answer->question->text}}</a>
                            </p>
                            <hr>
                            <strong><i class="fa fa-check mr-2"></i>{{__('common.test')}}</strong>
                            <p class="text-muted">
                                <a href="{{route("{$currentUserRole}.tests.show", $answer->question->test_id)}}"> {{$answer->question->test->title}}</a>
                            </p>
                            <hr>
                            @if(auth()->user()->isAdmin())
                                <strong><i class="fa fa-user mr-2"></i>{{__('common.author test')}}</strong>
                                <p class="text-muted">
                                    <a href="{{route('admin.users.show', $answer->question->test->user_id)}}"> {{$answer->question->test->user->name}}</a>
                                </p>
                                <hr>
                            @endif
                            <div class="row gap-2">
                                <div
                                    class="col-12 d-flex flex-column flex-md-row flex-lg-row justify-content-md-start ">
                                    <a href="{{route("{$currentUserRole}.tests.questions.show", $answer->question)}}"
                                       class="btn btn-secondary mb-2 mr-lg-2 mr-md-2">{{__('common.close')}}</a>

                                    @if($answer->question->test->isActive() || $answer->question->test->isModeration())
                                        @include('partial.button_no_edit')

                                    @else
                                        <a href="{{route("{$currentUserRole}.tests.questions.answers.edit", $answer->id)}}"
                                           class="btn btn-info mb-2 mr-lg-2 mr-md-2">{{__('common.edit')}}</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @include('admin.answers.content.reactions')

@endsection


