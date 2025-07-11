@extends('layouts.app')
@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.question')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.questions.create", $question->test)}}
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
                            <h3 class="card-title"><i class="fas fa-edit"></i> {{__('common.create question')}}</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-group" action="{{route("{$currentUserRole}.tests.questions.store")}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="test_id" value="{{ $question->test->id }}">

                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="exampleInputQuestion">{{__('common.question text')}}</label>
                                        <textarea type="text" class="form-control" name="text"
                                                  id="exampleInputQuestion"
                                                  placeholder="{{__('common.enter question text')}}">{{old('text')}}</textarea>
                                    </div>

                                    @include('partial.cropper', [
                                    'inputLabel' => __('common.picture'),
                                    'chooseFileLabel' => __('common.choose file'),
                                    'name' => 'picture',
                                    'finalWidth' => 600,
                                    'finalHeight' => 400,])

                                    <div class="form-group ">
                                        <label for="id_label_single">{{__('common.form answer')}}</label>
                                        <select class="select2 form-control" name="type">
                                            @foreach ($types as $type)
                                                <option value="{{ $type }}"
                                                    {{$question->type === $type ? "selected" : ""}}
                                                >{{ __("common.{$type}") }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input class="btn btn-success" id="submitBtn" type="submit"
                                           value="{{__('common.save')}}">
                                    <a href="{{route("{$currentUserRole}.tests.show", $question->test)}}"
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
    <script>$(document).ready(function () {
            $('.select2').select2();
        });
    </script>

@endpush
