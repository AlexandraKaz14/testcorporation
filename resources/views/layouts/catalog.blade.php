<!DOCTYPE html>

<html lang="en">

@include('catalog.head')
<body>

@include('catalog.header')

<main class="flex-grow-1">

    @yield('content')
    @yield('tags')
    @yield('authors')
    @yield('groups')
    @yield('create_test')
    @yield('project')
    @yield('contact')

</main>
@include('catalog.footer')

@include('posthog.snippet')

</body>

</html>

