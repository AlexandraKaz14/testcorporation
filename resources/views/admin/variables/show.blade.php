@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.variable')}}: {{$variable->name}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.variables.show", $variable)}}
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
                            <h3 class="card-title"><i class="fa fa-th-large mr-1"></i> {{__('common.variable card')}}</h3>
                        </div>
                        <div class="card-body">

                            <strong><i class="fa fa-paragraph mr-2"></i> {{__('common.name variable')}}</strong>
                            <p class="text-muted">
                                {{$variable->name}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-star mr-2"></i>{{__('common.starting value')}}</strong>
                                <p class="text-muted">
                                    {{$variable->start_value}}
                                </p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.created_at')}}</strong>
                            <p class="text-muted">
                                {{$variable->created_at}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.updated_at')}}</strong>
                            <p class="text-muted">
                                {{$variable->updated_at}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-check mr-2"></i>{{__('common.test')}}</strong>
                            <p class="text-muted">
                                <a href="{{route("{$currentUserRole}.tests.show", $variable->test_id)}}"> {{$variable->test->title}}</a>
                            </p>
                            <hr>
                            @if($variable->test->user->isAdmin())
                            <strong><i class="fa fa-user mr-2"></i>{{__('common.author test')}}</strong>
                            <p class="text-muted">
                                <a href="{{route('admin.users.show', $variable->test->user_id)}}"> {{$variable->test->user->name}}</a>
                            </p>
                            <hr>
                            @endif

                            <a href="{{route("{$currentUserRole}.tests.show", $variable->test)}}"
                               class="btn btn-secondary mb-2 mr-lg-2 mr-md-2">{{__('common.close')}}</a>

                            @if($variable->test->isDraft())
                                <a href="{{route("{$currentUserRole}.tests.variables.edit", $variable->id)}}"
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
