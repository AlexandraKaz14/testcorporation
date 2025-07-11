@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.audit')}}</h1>
            </div>
            <div class="col-sm-6 ">
                                {{Breadcrumbs::render('admin.audits.index')}}
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
    'label' => __('common.date of recording'),
    'name' => 'daterange',
    'class' => 'mydaterangepicker'
])
                                    </div>

                                    <div class="col-md-4">
                                        <label for="category">{{__('common.event')}}</label>
                                        <div class="input-group">
                                            <select class=" form-control select2" name="events[]"
                                                    multiple="multiple">
                                                @foreach ($events as $event)
                                                    <option value="{{ $event }}"
                                                        {{in_array($event, request()->get('events')??[])?'selected' : ""}}
                                                    >@switch($event)
                                                            @case('updated')
                                                                {{__("common.updated")}}
                                                                @break
                                                            @case('created' )
                                                                {{__("common.created")}}
                                                                @break
                                                            @case('deleted' )
                                                                {{__("common.deletion")}}
                                                                @break
                                                            @case('restored' )
                                                                {{__("common.restored")}}
                                                                @break
                                                            @default
                                                                {{ $event}}
                                                        @endswitch
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="model">{{__('common.models')}}</label>
                                        <div class="input-group">
                                            <select class="select2 form-control" name="models[]" multiple="multiple">
                                                @foreach ($models as $model)
                                                    <option value="{{ $model->auditable_type }}"
                                                        {{in_array($model->auditable_type, request()->get('models')??[])?'selected' : ""}}
                                                    >{{ $model->auditable_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="users">{{__('common.users')}}</label>
                                        <div class="input-group">
                                            <select class="select2 form-control" name="users[]" multiple="multiple">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id}}"
                                                        {{in_array($user->id,request()->get('users')??[])? 'selected' :""}}
                                                    >{{$user->name}}</option>
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
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-list mr-2"></i>{{__('common.list of actions')}}</h3>

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
            $(".mydaterangepicker").data('daterangepicker').setStartDate(moment('2025-01-01'));
            $('.mydaterangepicker').data('daterangepicker').setEndDate(moment());
        })
    </script>
@endpush
