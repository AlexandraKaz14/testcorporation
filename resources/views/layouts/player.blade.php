<!DOCTYPE html>

<html lang="en">

@include('player.head')

<body>

@yield('content')

@yield('result')

@include('posthog.snippet')

</body>

</html>
