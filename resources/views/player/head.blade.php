<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}"/>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <meta property="og:title" content="@yield('og_title')">
    <meta property="og:description" content="@yield('og_description')">
    <meta property="og:image" content="@yield('og_image')">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="800">
    <meta property="og:url" content="@yield('og_url')">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Корпорация теста">
    <meta property="og:locale" content="ru_RU">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/030f77f060.js" crossorigin="anonymous"></script>


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        {!! $theme->css_style !!}
    </style>

</head>



