@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.users')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('admin.users.index')}}
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
                            <h3 class="card-title"><i class="fas fa-filter mr-2"></i>{{__('common.filters')}}</h3>
                        </div>

                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-4">
                                        @include('partial.daterangepicker', [
    'startDate' => $startDate,
    'endDate' => $endDate,
    'label' => __('common.date of registration'),
    'name' => 'daterange',
    'class' => 'mydaterangepicker'
])
                                    </div>

                                    <div class="col-md-4">
                                        <label for="role">{{__('common.role')}}</label>
                                        <div class="input-group">
                                            <select class=" form-control select2" name="roles[]" multiple="multiple">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role }}"
                                                        {{in_array($role,request()->get('roles')??[])? 'selected' :""}}
                                                    >{{ __("common.{$role}") }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="status">{{__('common.status')}}</label>
                                        <div class="input-group">
                                            <select class="select2 form-control" name="statuses[]" multiple="multiple">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status }}"
                                                        {{in_array($status, request()->get('statuses')??[])?'selected' : ""}}
                                                    >{{ __("common.{$status}") }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="deleteStatus">{{__('common.state')}}</label>
                                        <div class="input-group">
                                            <select class=" form-control select2" name="deletedStatuses[]" multiple="multiple">
                                                @foreach ($deletedStatuses as $deletedStatus)
                                                    <option value="{{ $deletedStatus }}"
                                                        {{in_array($deletedStatus, request()->get('deletedStatuses')??[])? 'selected' :""}}
                                                    >{{ __("common.{$deletedStatus}") }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <input class="btn btn-primary" id="button" type="submit" value="{{__('common.filter')}}">
                                <input class="btn btn-warning text-white" id="reset" type="submit"
                                       value="{{__('common.clear filters')}}">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title mb-3 mb-lg-0 mb-md-1"><i class="fa fa-list mr-2"></i>{{__('common.list of users')}}</h3>
                            <div class="card-tools w-100 w-md-auto">
                                <div class="row g-2">
                                    <div class="col-12 d-flex flex-column flex-md-row justify-content-md-end gap-2">
                                        <a href="{{route('admin.users.create')}}"
                                           class="btn btn-success mb-2 mr-lg-2 mr-md-2">
                                            <i class="fas fa-plus mr-2"></i>{{__('common.add user')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="card-body table-responsive p-0">
                            {{ $dataTable->table() }}
                        </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>

@endsection

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module', ]) }}

    <script>
        $('#reset').click(function (e) {
            e.preventDefault();
            $('.select2').val("").trigger('change')
            $(".mydaterangepicker").data('daterangepicker').setStartDate(moment('2024-01-01'));
            $('.mydaterangepicker').data('daterangepicker').setEndDate(moment());
        })
    </script>
@endpush






