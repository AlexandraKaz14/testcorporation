@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.moderation')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('admin.moderations.index')}}
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
    'label' => __('common.date of moderation'),
    'name' => 'daterange',
    'class' => 'mydaterangepicker'
])
                                    </div>

                                    <div class="col-md-4">
                                        <label for="category">{{__('common.moderation status')}}</label>
                                        <div class="input-group">
                                            <select class=" form-control select2" name="statuses[]"
                                                    multiple="multiple">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status }}"
                                                        {{in_array($status, request()->get('statuses')??[])?'selected' : ""}}
                                                    >{{ __("common.{$status}") }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="model">{{__('common.moderator')}}</label>
                                        <div class="input-group">
                                            <select class="select2 form-control" name="moderators[]" multiple="multiple">
                                                @foreach ($moderators as $moderator)
                                                    <option value="{{ $moderator->id }}"
                                                        {{in_array($moderator->id, request()->get('moderators')??[])?'selected' : ""}}
                                                    >{{$moderator->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="users">{{__('common.author test')}}</label>
                                        <div class="input-group">
                                            <select class="select2 form-control" name="authors[]" multiple="multiple">
                                                @foreach ($authors as $author)
                                                    <option value="{{ $author->id}}"
                                                        {{in_array($author->id,request()->get('authors')??[])? 'selected' :""}}
                                                    >{{$author->name}}</option>
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
                            <h3 class="card-title"><i class="fa fa-list mr-2"></i>{{__('common.list of tests for moderation')}}</h3>
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

@include('partial.scroll-position')

    <script>
        $('#reset').click(function (e) {
            e.preventDefault();
            $('.select2').val("").trigger('change')
            $(".mydaterangepicker").data('daterangepicker').setStartDate(moment('2025-01-01'));
            $('.mydaterangepicker').data('daterangepicker').setEndDate(moment());
        })
    </script>

@endpush
