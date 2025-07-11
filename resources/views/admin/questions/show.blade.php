@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.question')}} № {{$question->number}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.questions.show", $question)}}
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
                            <h3 class="card-title"><i class="fa fa-th-large mr-1"></i> {{__('common.question card')}}
                            </h3>
                        </div>
                        <div class="card-body">

                            <strong><i class="fa fa-file-image mr-2"></i>{{__('common.picture')}}</strong>

                            <div class="row mt-4">
                                <div class="col-sm-4">
                                    <div class="position-relative">
                                        @if($question->picture)
                                            <img src="{{ Storage::url($question->picture)}}" alt="Photo 1"
                                                 class="img-fluid img-thumbnail" width="300" height="300">
                                        @else
                                            <p>---</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <strong>№ {{__('common.number question')}}</strong>
                            <p class="text-muted">
                                {{$question->number}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-question mr-2"></i>{{__('common.text question')}}</strong>
                            @if($question->text)
                                <p class="text-muted">
                                    {{$question->text}}
                                </p>
                            @else
                                <p>---</p>
                            @endif

                            <hr>
                            <strong><i class="fa fa-check mr-2"></i>{{__('common.form answer')}}</strong>
                            <p class="text-muted">
                                {{__('common.' . $question->type)}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.created_at')}}</strong>
                            <p class="text-muted">
                                {{$question->created_at}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.updated_at')}}</strong>
                            <p class="text-muted">
                                {{$question->updated_at}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-check mr-2"></i>{{__('common.test')}}</strong>
                            <p class="text-muted">
                                <a href="{{route("{$currentUserRole}.tests.show", $question->test_id)}}"> {{$question->test->title}}</a>
                            </p>
                            <hr>
                            @if(auth()->user()->isAdmin())
                            <strong><i class="fa fa-user mr-2"></i>{{__('common.author test')}}</strong>
                            <p class="text-muted">
                                <a href="{{route("admin.users.show", $question->test->user_id)}}"> {{$question->test->user->name}}</a>
                            </p>
                            <hr>
                            @endif

                            <div class="row gap-2">
                                <div class="col-12 d-flex flex-column flex-md-row flex-lg-row justify-content-md-start ">

                                <a href="{{route("{$currentUserRole}.tests.show", $question->test)}}"
                               class="btn btn-secondary btn-back mb-2 mr-lg-2 mr-md-2 ">{{__('common.close')}}</a>

                            @if($question->test->isActive() || $question->test->isModeration() )
                                @include('partial.button_no_edit')
                            @else
                                <a href="{{route("{$currentUserRole}.tests.questions.edit", $question->id)}}"
                                   class="btn btn-info mb-2 mr-lg-2 mr-md-2">{{__('common.edit')}}</a>
                            @endif
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{--раздел ответы--}}
        @include('admin.questions.content.answers')


    </section>

@endsection

@push('js')


@include('partial.sortable',[
    'updateSequenceUrl'=>route("{$currentUserRole}.tests.questions.answer_sequence", $question),
    'selector'=>'#myTable',
])

<script>
    document.addEventListener('DOMContentLoaded', function () {

        var showDeletedAnswersBtn = document.getElementById('show-deleted-answers');

        var answersTable = document.querySelector('#myTable tbody');
        if (!answersTable || answersTable.children.length === 0) {
            if (showDeletedAnswersBtn) {
                showDeletedAnswersBtn.style.display = 'none';
            }
        }

    });
</script>

@endpush
