@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.result')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.results.show", $result)}}
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
                            <h3 class="card-title"><i class="fa fa-th-large mr-1"></i> {{__('common.result card')}}
                            </h3>
                        </div>
                        <div class="card-body">

                                <strong><i class="fa fa-check mr-2"></i>{{__('common.condition')}}</strong>
                            @if($result->condition === 'true')
                            <p class="text-muted">
                                    {{__('common.The conditional expression is set by default, this result will be applied to the test if there are no other results.')}}</p>
                            @else
                                <p class="text-muted">
                                    {{$result->condition}}
                                </p>
                            @endif

                            <strong><i class="fa fa-paragraph mr-2"></i>{{__('common.text')}}</strong>
                            @if($result->text)
                                <p class="text-muted">
                                    {!! nl2br(e($result->text)) !!}

                                </p>
                            @else
                                <p>---</p>
                            @endif
                            <hr>

                            <strong><i class="fa fa-file-image mr-2"></i>{{__('common.picture')}}</strong>
                            <div class="row mt-4">
                                <div class="col-sm-4">
                                    <div class="position-relative">
                                        @if($result->picture)
                                            <img src="{{ Storage::url($result->picture)}}" alt="Photo 1"
                                                 class="img-fluid img-thumbnail" width="200" height="200">
                                        @else
                                            <p>---</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.created_at')}}</strong>
                            <p class="text-muted">
                                {{$result->created_at}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.updated_at')}}</strong>
                            <p class="text-muted">
                                {{$result->updated_at}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-check mr-2"></i>{{__('common.test')}}</strong>
                            <p class="text-muted">
                                <a href="{{route("{$currentUserRole}.tests.show", $result->test_id)}}"> {{$result->test->title}}</a>
                            </p>
                            <hr>
                            @if(auth()->user()->isAdmin())
                            <strong><i class="fa fa-user mr-2"></i>{{__('common.author test')}}</strong>
                            <p class="text-muted">
                                <a href="{{route('admin.users.show', $result->test->user_id)}}"> {{$result->test->user->name}}</a>
                            </p>
                            <hr>
                            @endif

                            <a href="{{route("{$currentUserRole}.tests.show", $result->test)}}"
                               class="btn btn-secondary mb-2 mr-lg-2 mr-md-2">{{__('common.close')}}</a>

                            @if($result->test->IsDraft())
                                <a href="{{route("{$currentUserRole}.tests.results.edit", $result->id)}}"
                                   class="btn btn-info mb-2 mr-lg-2 mr-md-2">{{__('common.edit')}}</a>
                            @else
                                @include('partial.button_no_edit')
                            @endif
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


