@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.view user')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('admin.users.show', $user)}}
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
                            <h3 class="card-title"><i class="fas fa-id-card mr-1"></i> {{__('common.user card')}}</h3>
                        </div>
                        <div class="card-body">
                            <strong><i class="fa fa-user mr-1"></i>{{__('common.name')}}</strong>
                            <p class="text-muted">
                                {{$user->name}}
                            </p>
                            <hr>
                            <strong><i class="fa fa-envelope mr-1"></i> {{__('common.email')}}</strong>
                            <p class="text-muted">{{$user->email}}</p>
                            <hr>
                            <strong><i class="fas fa-check mr-1"></i> {{__('common.status')}}</strong>
                            <p class="text-muted">
                                {{ __("common.{$user->status}") }}
                            </p>
                            <hr>
                            <strong><i class="fas fa-user mr-1"></i> {{__('common.role')}}</strong>
                            <p class="text-muted">   {{ __("common.{$user->role}") }}</p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-1"></i> {{__('common.created_at')}}</strong>
                            <p class="text-muted">{{$user->created_at}}</p>
                            <hr>
                            <strong><i class="fa fa-calendar mr-1"></i> {{__('common.updated_at')}}</strong>
                            <p class="text-muted">{{$user->updated_at}}</p>
                            <hr>
                            <a href="{{ url()->previous(route('admin.users.index')) === url()->current() ? route('admin.users.index') :  url()->previous(route('admin.users.index'))  }}"
                               class="btn btn-secondary">{{__('common.close')}}</a>
                            <a href="{{route('admin.users.edit',$user->id)}}"
                               class="btn btn-info">{{__('common.edit')}}</a>
                            @if($user->tests->count())
                            <a href="{{route('admin.tests.index',['users[]' => $user->id])}}"
                               class="btn btn-outline-info">{{'Тесты пользователя'}}
                                <span class="badge badge-warning">{{$user->tests->count()}}</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
