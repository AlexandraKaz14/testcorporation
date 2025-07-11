<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>


    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">

    @if(auth()->user()->isAuthor())
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge badge-warning navbar-badge">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('profile.notifications') }}" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i>
                        {{ __('common.new notifications') }}
                        <span class="badge badge-warning">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span><br>

                        @php
                            $lastNotification = auth()->user()->unreadNotifications->sortByDesc('created_at')->first();
                        @endphp

                        @if ($lastNotification)
                            <p class="text-sm text-muted">
                                <i class="far fa-clock mr-1"></i>
                                {{ $lastNotification->created_at->diffForHumans() }}
                            </p>
                        @endif
                    </a>
                @else
                    <a href="{{ route('profile.notifications') }}" class="dropdown-item">
                    <span class="dropdown-item dropdown-header">
                    {{ __('common.there are no new notifications') }}
                </span>
                    </a>
                @endif
            </div>
        </li>
    @endif








    {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
