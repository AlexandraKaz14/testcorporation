@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.view category')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('admin.categories.show', $category)}}
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
                            <h3 class="card-title"><i class="fa fa-th-large mr-1"></i> {{__('common.category card')}}</h3>
                        </div>
                        <div class="card-body">
                            <strong><i class="fa fa-th-large mr-2"></i>{{__('common.title')}}</strong>
                            <p class="text-muted">
                                {{$category->title}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-1"></i> {{__('common.created_at')}}</strong>
                            <p class="text-muted">{{$category->created_at}}</p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-1"></i> {{__('common.updated_at')}}</strong>
                            <p class="text-muted">{{$category->updated_at}}</p>
                            <hr>
                            <a href="{{route('admin.categories.index')}}"
                               class="btn btn-secondary">{{__('common.close')}}</a>
                            <a href="{{route('admin.categories.edit',$category->id)}}"
                               class="btn btn-info">{{__('common.edit')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
