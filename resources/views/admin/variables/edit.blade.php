@extends('layouts.app')
@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.edit variable')}} : {{$variable->name}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.variables.edit", $variable)}}

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
                            <h3 class="card-title"><i class="fas fa-edit"></i> {{__('common.edit variable')}}</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-variable" action="{{route("{$currentUserRole}.tests.variables.update", $variable->id)}}" method="post">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="test_id" value="{{ $variable->test_id }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputName">{{__('common.name')}}</label>
                                        <input type="text" class="form-control" id="exampleInputName" name="name" value="{{$variable->name}}"
                                               placeholder="{{__('common.enter name variable')}}">
                                    </div>

                                        <div class="form-group">
                                            <label for="exampleInputValue">{{__('common.starting value')}}</label>
                                            <input type="number" step="any" class="form-control" id="exampleInputValue" name="start_value" value="{{$variable->start_value}}"
                                                   placeholder="{{__('common.enter starting value')}}">
                                        </div>

                                    <input class="btn btn-success" id="button" type="submit" value="{{__('common.save')}}">
                                    <a href="{{route("{$currentUserRole}.tests.show", $variable->test)}}"
                                       class="btn btn-secondary">{{__('common.close')}}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')

@endpush
