@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.tests')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.index")}}
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
    'label' => __('common.date of create'),
    'name' => 'daterange',
    'class' => 'mydaterangepicker',
])
                                    </div>

                                    <div class="col-md-4">
                                        <label for="category">{{__('common.categories')}}</label>
                                        <div class="input-group">
                                            <select class=" form-control select2" name="categories[]"
                                                    multiple="multiple">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{in_array($category->id,request()->get('categories')??[])? 'selected' :""}}
                                                    >{{$category->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="tag">{{__('common.tags')}}</label>
                                        <div class="input-group">
                                            <select class="select2 form-control" name="tags[]" multiple="multiple">
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}"
                                                        {{in_array($tag->id, request()->get('tags')??[])?'selected' : ""}}
                                                    >{{ $tag->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    @can('search-user',$currentUser )
                                        <div class="col-md-4">
                                            <label for="authorTest">{{__('common.author test')}}</label>
                                            <div class="input-group">
                                                <select class=" form-control select2" name="users[]"
                                                        multiple="multiple">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id}}"
                                                            {{in_array($user->id,request()->get('users')??[])? 'selected' :""}}
                                                        >{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endcan


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

                                    <div class="col-md-4">
                                        <label for="deleteStatus">{{__('common.state test')}}</label>
                                        <div class="input-group">
                                            <select class=" form-control select2" name="deletedStatuses[]"
                                                    multiple="multiple">
                                                @foreach ($deletedStatuses as $deletedStatus)
                                                    <option value="{{ $deletedStatus }}"
                                                        {{in_array($deletedStatus,request()->get('deletedStatuses')??[])? 'selected' :""}}
                                                    >{{ __("common.{$deletedStatus}") }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <input class="btn btn-primary" id="button" type="submit"
                                       value="{{__('common.filter')}}">
                                <input class="btn btn-warning text-white" id="reset" type="submit"
                                       value="{{__('common.clear filters')}}">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                            <h3 class="card-title mb-3 mb-lg-0 mb-md-1"><i class="fa fa-list mr-2"></i>{{__('common.list of tests')}}
                            </h3>
                            <div class="card-tools w-100 w-md-auto">
                                <div class="row g-2">
                                    <div class="col-12 d-flex flex-column flex-md-row justify-content-md-end gap-2">
                                        <a href="{{route("{$currentUserRole}.tests.create")}}"
                                           class="btn btn-success mb-2 mr-lg-2 mr-md-2">
                                            <i class="fas fa-plus mr-2"></i>{{__('common.add test')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive">
                            {{ $dataTable->table() }}
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
