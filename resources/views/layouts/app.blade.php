<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body class="grey lighten-5">

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper">
                <a href="{{ url('/') }}" class="brand-logo">&nbsp{{ config('app.name', 'Laravel') }}</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                @guest
                    <ul class="right hide-on-med-and-down">
                        <li class="{{ Route::currentRouteName() == 'login' ? 'active' : ''}}"><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <li class="{{ Route::currentRouteName() == 'register' ? 'active' : ''}}"><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    </ul>
                @else
                    <ul class="right hide-on-med-and-down">
                        <li class="{{ Route::currentRouteName() == 'routes.index' ? 'active' : ''}}"><a href="{{ route('routes.index') }}">{{ __('Dashboard') }}</a></li>
                        <li class="{{ Route::currentRouteName() == 'routes.create' ? 'active' : ''}}"><a href="{{ route('routes.create') }}">{{ __('Create') }}</a></li>
                        <li class="{{ Route::currentRouteName() == 'routes.trashed' ? 'active' : ''}}"><a href="{{ route('routes.trashed') }}">{{ __('Trash') }}</a></li>
                        <li><a href="{{ route('logout') }}" class="logout">{{ __('Logout') }}</a></li>
                    </ul>
                @endguest
            </div>
        </nav>
    </div>

    <ul class="sidenav" id="mobile-demo">
        @guest
            <li class="{{ Route::currentRouteName() == 'login' ? 'active' : ''}}"><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
            <li class="{{ Route::currentRouteName() == 'register' ? 'active' : ''}}"><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
        @else
            <li class="{{ Route::currentRouteName() == 'routes.index' ? 'active' : ''}}"><a href="{{ route('routes.index') }}">{{ __('Dashboard') }}</a></li>
            <li class="{{ Route::currentRouteName() == 'routes.create' ? 'active' : ''}}"><a href="{{ route('routes.create') }}">{{ __('Create') }}</a></li>
            <li class="{{ Route::currentRouteName() == 'routes.trashed' ? 'active' : ''}}"><a href="{{ route('routes.trashed') }}">{{ __('Trash') }}</a></li>
            <li><a href="{{ route('logout') }}" class="logout">{{ __('Logout') }}</a></li>
        @endguest
    </ul>

    @include('cookieConsent::index')

    <div id="app">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('script')

    <script>
        $(document).ready(function(){
            $('.sidenav').sidenav();
            $('.dropdown-trigger').dropdown();
            $('.logout').click(function(e) {
                e.preventDefault();
                $('#logout-form').submit();
            });
        });
    </script>
</body>
</html>
