@extends('layouts.app')
@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.themes')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('admin.themes.create')}}
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
                            <h3 class="card-title"><i class="fas fa-edit"></i> {{__('common.create theme')}}</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-user" action="{{route('admin.themes.store')}}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputName">{{__('common.title')}}</label>
                                        <input type="text" class="form-control" id="exampleInputName" name="title" value="{{old('title')}}"
                                               placeholder="{{__('common.enter title theme')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputTheme">{{__('common.style css')}}</label>
                                        <textarea type="text" class="form-control" name="css_style"
                                                  id="exampleInputTheme"
                                                  placeholder="{{__('common.enter style css')}}">{{old('text')}}</textarea>
                                    </div>

                                    <input class="btn btn-success" id="button" type="submit" value="{{__('common.save')}}">
                                    <a href="{{route('admin.themes.index')}}"
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
