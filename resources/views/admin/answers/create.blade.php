@extends('layouts.app')
@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.answer')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.questions.answers.create", $answer->question)}}
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
                            <h3 class="card-title"><i class="fas fa-edit"></i> {{__('common.create answer')}}</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-group"
                                  action="{{route("{$currentUserRole}.tests.questions.answers.store")}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="question_id" value="{{ $answer->question->id }}">

                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="exampleInputQuestion">{{__('common.text answer')}}</label>
                                        <textarea type="text" class="form-control" name="text"
                                                  id="exampleInputQuestion"
                                                  placeholder="{{__('common.enter answer text')}}">{{old('text')}}</textarea>
                                    </div>

                                    @include('partial.cropper', [
                               'inputLabel' => __('common.picture'),
                               'chooseFileLabel' => __('common.choose file'),
                               'name' => 'picture',
                               'finalWidth' => 800,
                               'finalHeight' => 600,])

                                    <input class="btn btn-success" id="submitBtn" type="submit"
                                           value="{{__('common.save')}}">
                                    <a href="{{route("{$currentUserRole}.tests.questions.show", $answer->question)}}"
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


