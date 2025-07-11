@extends('layouts.app')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.themes')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('admin.themes.index')}}
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

                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                            <h3 class="card-title mb-3 mb-lg-0 mb-md-1"><i class="fa fa-list mr-2"></i>{{__('common.list of themes')}}
                            </h3>
                            <div class="card-tools w-100 w-md-auto">
                                <div class="row g-2">
                                    <div class="col-12 d-flex flex-column flex-md-row justify-content-md-end gap-2">
                                        <a href="{{route('admin.themes.create')}}"
                                           class="btn btn-success mb-2 mr-lg-2 mr-md-2">
                                            <i class="fas fa-plus mr-2"></i>{{__('common.add themes')}}</a>
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

@endpush
