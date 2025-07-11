@extends('layouts.app')
@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Реакция</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.questions.answers.reactions.create", $reaction->answer)}}

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
                            <h3 class="card-title"><i class="fas fa-edit"></i>{{__('common.create reaction')}}</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-reaction" action="{{route("{$currentUserRole}.tests.questions.answers.reactions.store")}}" method="post">
                                @csrf

                                <input type="hidden" name="answer_id" value="{{ $reaction->answer->id }}">

                                    <div class="form-group">
                                    <label for="variable_id">{{__('common.variables')}}</label>
                                    <select name="variable_id" class="select2 form-control" required>
                                        @foreach($variables as $variable)
                                            <option value="{{ $variable->id }}">{{ $variable->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="operation">{{__('common.operation')}}</label>
                                    <select class="select2 form-control" name="operation">
                                        @foreach (array_keys($operations) as $operation)
                                            <option value="{{ $operation }}"
                                                {{$reaction->operation === $operation ? "selected" : ""}}
                                            >{{ __("common.{$operation}") }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="value">{{__('common.value')}}</label>
                                    <input type="number" step="any" name="value" class="form-control">
                                </div>

                                    <input class="btn btn-success" id="button" type="submit" value="{{__('common.save')}}">
                                    <a href="{{route("{$currentUserRole}.tests.questions.answers.show", $reaction->answer_id)}}"
                                       class="btn btn-secondary">{{__('common.close')}}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
    <script>$(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endpush
