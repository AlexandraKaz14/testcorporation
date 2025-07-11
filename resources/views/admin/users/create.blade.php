@extends('layouts.app')
@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.user')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('admin.users.create')}}
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
                            <h3 class="card-title"><i class="fas fa-edit"></i> {{__('common.create user')}}</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-user" action="{{route("admin.users.store")}}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputName">{{__('common.name')}}</label>
                                        <input type="text" class="form-control" id="exampleInputName" name="name" value="{{old('name')}}"
                                               placeholder="{{__('common.enter name')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('common.email')}}</label>
                                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="{{old('email')}}"
                                               placeholder="{{__('common.enter email')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('common.password')}}</label>
                                        <input type="password" class="form-control" name="password"
                                               id="exampleInputPassword1"
                                               placeholder="{{__('common.enter password')}}">
                                    </div>

                                    <div class="form-group ">
                                        <label for="id_label_single">{{__('common.role')}}</label>
                                        <select class="select2 form-control" name="role">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}"
                                                    {{$user->role=== $role ? "selected" : ""}}
                                                >{{ __("common.{$role}") }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputStatus">{{__('common.status')}}</label>
                                        <select class="select2 form-control" name="status">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}"
                                                    {{$user->status === $status ? "selected" : ""}}
                                                >{{ __("common.{$status}") }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <input class="btn btn-success" id="button" type="submit" value="{{__('common.save')}}">
                                    <a href="{{route('admin.users.index')}}"
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
