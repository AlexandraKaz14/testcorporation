@extends('layouts.app')
@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.categories')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('admin.categories.edit', $category)}}
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
                            <h3 class="card-title"><i class="fas fa-edit"></i> {{__('common.edit category')}}</h3>
                        </div>
                        <div class="card-body">

                            <form id="form-user" action="{{route('admin.categories.update', $category->id)}}" method="post">
                                @csrf
                                @method('patch')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputName">{{__('common.title')}}</label>
                                        <input type="text" class="form-control" id="exampleInputName" name="title"
                                               value="{{$category->title}}"
                                               placeholder="{{__('common.enter title category')}}">
                                    </div>
                                    <input class="btn btn-success" id="button" type="submit"
                                           value="{{__('common.save')}}">
                                    <a href="{{route('admin.categories.index')}}"
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
