@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.view theme')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('admin.themes.show', $theme)}}
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
                            <h3 class="card-title"><i class="fa fa-th-large mr-1"></i> {{__('common.theme card')}}</h3>
                        </div>
                        <div class="card-body">
                            <strong><i class="fa fa-paragraph mr-2"></i>
                                {{__('common.title theme')}}</strong>
                            <p class="text-muted">
                                {{$theme->title}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-code mr-2"></i>
                                {{__('common.style css')}}</strong>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" style="max-height: 300px; overflow-y: auto; background: #f8f9fa; border: 1px solid #e0e0e0;">
                                        <pre>{{ $theme->css_style }}</pre>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <strong><i class="fa fa-calendar mr-1"></i> {{__('common.created_at')}}</strong>
                            <p class="text-muted">{{$theme->created_at}}</p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-1"></i> {{__('common.updated_at')}}</strong>
                            <p class="text-muted">{{$theme->updated_at}}</p>
                            <hr>
                            <a href="{{route('admin.themes.index')}}"
                               class="btn btn-secondary">{{__('common.close')}}</a>
                            <a href="{{route('admin.themes.edit',$theme->id)}}"
                               class="btn btn-info">{{__('common.edit')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
