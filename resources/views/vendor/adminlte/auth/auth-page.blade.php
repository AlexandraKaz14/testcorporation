@extends('adminlte::master')

<title>@yield('title')</title>

<meta name="description" content="@yield('description')">
<meta name="keywords" content="@yield('keywords')">

<meta property="og:title" content="@yield('og_title')">
<meta property="og:description" content="@yield('og_description')">
<meta property="og:image" content="@yield('og_image')">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="800">
<meta property="og:url" content="@yield('og_url')">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Корпорация тестов">
<meta property="og:locale" content="ru_RU">



@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')

@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')

@yield('auth_body')

@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop


@include('posthog.snippet')
