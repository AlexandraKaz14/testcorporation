@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.reaction')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.questions.answers.reactions.show", $reaction)}}
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
                            <h3 class="card-title"><i class="fa fa-th-large mr-1"></i> {{__('common.reaction card')}}
                            </h3>
                        </div>
                        <div class="card-body">

                            <strong><i class="fa fa-paragraph mr-2"></i> {{__('common.variable')}}</strong>
                            <p class="text-muted">
                                {{$reaction->variable->name}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-star mr-2"></i>{{__('common.operation')}}</strong>
                            <p class="text-muted">
                                {{ __("common.{$reaction->operation}") }}
                            </p>
                            <hr>
                            <strong><i class="fa fa-star mr-2"></i>{{__('common.value')}}</strong>
                            <p class="text-muted">
                                {{$reaction->value}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.created_at')}}</strong>
                            <p class="text-muted">
                                {{$reaction->created_at}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.updated_at')}}</strong>
                            <p class="text-muted">
                                {{$reaction->updated_at}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-circle mr-2"></i>{{__('common.answer')}}</strong>
                            <p class="text-muted">
                                <a href="{{route("{$currentUserRole}.tests.questions.answers.show", $reaction->answer_id)}}"> {{$reaction->answer->text}}</a>
                            </p>
                            <hr>
                            <strong><i class="fa fa-question mr-2"></i>{{__('common.question')}}</strong>
                            <p class="text-muted">
                                <a href="{{route("{$currentUserRole}.tests.questions.show", $reaction->answer->question_id)}}"> {{$reaction->answer->question->text}}</a>
                            </p>
                            <hr>
                            <strong><i class="fa fa-check mr-2"></i>{{__('common.test')}}</strong>
                            <p class="text-muted">
                                <a href="{{route("{$currentUserRole}.tests.show", $reaction->answer->question->test_id)}}"> {{$reaction->answer->question->test->title}}</a>
                            </p>
                            <hr>
                            @if(auth()->user()->isAdmin())
                                <strong><i class="fa fa-user mr-2"></i>{{__('common.author test')}}</strong>
                                <p class="text-muted">
                                    <a href="{{route('admin.users.show', $reaction->answer->question->test->user_id)}}"> {{$reaction->answer->question->test->user->name}}</a>
                                </p>
                                <hr>
                            @endif
                            <div class="row gap-2">
                                <div
                                    class="col-12 d-flex flex-column flex-md-row flex-lg-row justify-content-md-start ">
                                    <a href="{{route("{$currentUserRole}.tests.questions.answers.show", $reaction->answer_id)}}"
                                       class="btn btn-secondary mb-2 mr-lg-2 mr-md-2">{{__('common.close')}}</a>
                                    @if($reaction->answer->question->test->isActive() || $reaction->answer->question->test->isModeration())
                                        @include('partial.button_no_edit')
                                    @else
                                        <a href="{{route("{$currentUserRole}.tests.questions.answers.reactions.edit", $reaction->id)}}"
                                           class="btn btn-info mb-2 mr-lg-2 mr-md-2">{{__('common.edit')}}</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection


@push('js')
    <script>
        $(document).ready(function () {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });

    </script>
@endpush
