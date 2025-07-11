@extends('adminlte::page')

@section('title', 'Личный кабинет')

@section('content_header')

@stop

@section('content')
@stop
@section('plugins.PluginName', true)
@section('css')
    {{--     Add here extra stylesheets --}}
    @vite('resources/css/app.css')

@stop

@push('js')
    @include('posthog.snippet')

    <script>$(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            @foreach ($errors->all() as $error)
            toastr.error('{{$error}}')
            @endforeach
        });
    </script>

@endif

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            toastr.success('{{session('success')}}')
        });
    </script>
@endif

@if(session('welcome'))
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            toastr.success('{{session('welcome') }}', { timeOut: 5000 })
        });
    </script>
@endif


