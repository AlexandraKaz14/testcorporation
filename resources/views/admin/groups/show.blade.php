@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.group')}}: {{$group->title}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('admin.groups.show', $group)}}
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
                            <h3 class="card-title"><i class="fa fa-th-large mr-1"></i> {{__('common.test card')}}</h3>
                        </div>
                        <div class="card-body">

                            <strong><i class="fa fa-file-image mr-2"></i>{{__('common.cover')}}</strong>

                            <div class="row mt-4">
                                <div class="col-sm-4">
                                    <div class="position-relative">
                                        <img src="{{ Storage::url($group->picture) }}" alt="Photo 1"
                                             class="img-fluid img-thumbnail" width="300" height="300">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <strong><i class="fa fa-paragraph mr-2"></i>{{__('common.title')}}</strong>
                            <p class="text-muted">
                                {{$group->title}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-paragraph mr-2"></i>{{__('common.slug')}}</strong>
                            <p class="text-muted">
                                {{$group->slug}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-paragraph mr-2"></i>{{__('common.description')}}</strong>
                            <p class="text-muted">
                                {{$group->description}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.created_at')}}</strong>
                            <p class="text-muted">
                                {{$group->created_at}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-2"></i>{{__('common.updated_at')}}</strong>
                            <p class="text-muted">
                                {{$group->updated_at}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-list mr-2"></i>{{__('common.tests')}}</strong>
                            <p class="text-muted">
                                @foreach($group->tests  as $test)
                                    <li>
                                        <a href="{{route('admin.tests.show', $test->id)}}">{{$test->title}}</a>
                                    </li>
                                @endforeach
                            </p>
                            <hr>

                            <div class="col-12">
                                <a href="{{route('admin.groups.index')}}" rel="noopener" target="_blank"
                                   class="btn btn-secondary mr-2">{{__('common.close')}}</a>
                                <a href="{{route('admin.groups.edit', $group->id)}}"
                                   class="btn btn-info">{{__('common.edit')}}</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection










