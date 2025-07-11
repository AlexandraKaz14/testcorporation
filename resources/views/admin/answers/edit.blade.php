@extends('layouts.app')
@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.question')}} № {{$answer->number}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.questions.answers.edit", $answer)}}
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
                            <h3 class="card-title"><i class="fas fa-edit"></i> {{__('common.edit answer')}}</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-group" action="{{route("{$currentUserRole}.tests.questions.answers.update",$answer->id)}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="question_id" value="{{ $answer->question_id }}">
                                <div class="card-body">

                                    @include('partial.cropper', [
                                           'inputLabel' => __('common.picture'),
                                           'chooseFileLabel' => __('common.choose file'),
                                           'currentPicturePath' => $answer->picture,
                                           'name' => 'picture',
                                           'finalWidth' => 800,
                                           'finalHeight' => 600,
                               ])

                                    <div class="form-group">
                                        <label for="exampleInputDescription">{{__('common.text answer')}}</label>
                                        <textarea type="text" class="form-control" name="text"
                                                  id="exampleInputDescription"
                                                  placeholder="{{__('common.enter answer text')}}">{{$answer->text}}</textarea>
                                    </div>

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



