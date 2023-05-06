@include('common.alert')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://kit.fontawesome.com/17a01b966a.js" crossorigin="anonymous"></script>
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        {{--    x-data en de button eronder is voor het hamburger menu toggelen op mobiel    --}}
        <div class="sidebar-wrapper" x-data="{ open: false }">
            <button class="hamburger-menu"  @click="open = ! open"><i class="fa-solid fa-bars fa-2xl"></i></button>
            <div class="sidebar">
                <div class="menu-top">
                    <a class="img" href="/dashboard"><i class="fa-solid fa-car-side fa-4x"></i>Vierkante wielen</a>
                    <div class="menu-links">
                        {{--Kijkt of de pagina geopent is en geeft een class die de link blauw maakt als de pagina geopent is--}}
                        <a class="{{ request()->is('announcement') ? 'active' : '' }}" href="/announcement"><i class="fa-solid fa-circle-exclamation"></i>Mededelingen</a>
                        <a class="{{ request()->is('lesson') ? 'active' : '' }}" href="/lesson"><i class="fa-solid fa-calendar-days"></i>Lesrooster</a>
                        <a class="{{ request()->is('profile') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user"></i>Profile</a>
                    </div>
                </div>
                <div class="menu-top">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button>
                            <i class="fa-solid fa-right-from-bracket"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
            <div class="responsive-wrapper"  x-cloak x-show="open">
                <div class="sidebar">
                    <div class="menu-top">
                        <a class="img" href="/dashboard"><i class="fa-solid fa-car-side fa-4x"></i>Vierkante wielen</a>
                        <div class="menu-links">
                            {{--Kijkt of de pagina geopent is en geeft een class die de link blauw maakt als de pagina geopent is--}}
                            <a class="{{ request()->is('announcement') ? 'active' : '' }}" href="/announcement"><i class="fa-solid fa-circle-exclamation"></i>Mededelingen</a>
                            <a class="{{ request()->is('lesson') ? 'active' : '' }}" href="/lesson"><i class="fa-solid fa-calendar-days"></i>Lesrooster</a>
                            <a class="{{ request()->is('profile') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user"></i>Profile</a>
                        </div>
                    </div>
                    <div class="menu-top">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button>
                                <i class="fa-solid fa-right-from-bracket"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @yield('content')
    </body>
</html>
