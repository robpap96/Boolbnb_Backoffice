<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BoolBnB @yield('page-title')</title>

    <!-- Fontawesome 6 cdn -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css' integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==' crossorigin='anonymous' referrerpolicy='no-referrer' />

    {{-- Axios CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.3/axios.min.js" integrity="sha512-wS6VWtjvRcylhyoArkahZUkzZFeKB7ch/MHukprGSh1XIidNvHG1rxPhyFnL73M0FC1YXPIXLRDAoOyRJNni/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Favicons --}}
    @include('layouts.favicons')

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="main-dashboard-header navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ env("APP_FRONTEND") }}">
                    <div class="logo_boolbnb d-flex align-items-center">
                        <img class="d-sm-none d-inline" src="{{ Vite::asset('resources/img/favicon/android-chrome-512x512.png') }}" alt="boolbnb-logo" style="width: 40px">
                        <h2 style="color:#ff5a5f;" class="m-0 d-none d-sm-inline m-text-cursive">BoolBnB</h2>
                    </div>
                </a>

                <button class="button-small-profile navbar-toggler rounded-pill p-0 " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <div class="drop d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 7px 13px;">
                        <i class="fa-solid fa-bars me-1"></i>
                        <span class="ms-2 me-2">{{ Auth::user()->name ?: 'Admin'}}</span>
                        <img class="rounded-pill" src="https://a0.muscache.com/defaults/user_pic-50x50.png?v=3" alt="" style="width: 30px; height: 30px;">
                    </div>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto ml-auto" id="profile-account-button" >
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Accesso') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Registrazione') }}</a>
                        </li>
                        @endif
                        @else
                        <div class="d-none d-md-block btn-group rounded-pill ms-md-3" style="border: 1px solid #ced4da;">
                                {{-- Menu aperto da md in poi --}}
                                <div class="d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 7px 13px;">
                                    <i class="fa-solid fa-bars me-1"></i>
                                    <span class="ms-2 me-2">{{ Auth::user()->name ?: 'Admin'}}</span>
                                    <img class="rounded-pill" src="https://a0.muscache.com/defaults/user_pic-50x50.png?v=3" alt="" style="width: 30px; height: 30px;">
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end mt-2">
                                    <a class="dropdown-item" href="{{ env("APP_FRONTEND") }}">Homepage</a>
                                    <a class="dropdown-item" href="{{ route('admin.apartments.index') }}">{{__('I miei appartamenti')}}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Esci') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </ul>

                            </div>
                            {{-- Menu aperto fino a md --}}
                            <div class="d-md-none">
                                <a class="dropdown-item text-end" href="{{ env("APP_FRONTEND") }}">Homepage</a>
                                <a class="dropdown-item text-end" href="{{ route('admin.apartments.index') }}">{{__('I miei appartamenti')}}</a>
                                <a class="dropdown-item text-end" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Esci') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main id="dashboard-columns">
            <div class="container row m-auto">
                {{-- Left column --}}
                <aside class="col-md-12 col-lg-3 left-column p-2">
                    <ul class="nav flex-column">
                        <li class="d-flex align-items-center nav-item {{ str_contains(Route::currentRouteName(), 'admin.apartments') ? 'bg-color-red' : '' }}">
                            <a class="nav-link text-dark w-100 d-flex align-items-center" href="{{route('admin.apartments.index')}}">
                                <i class="fa-solid fa-house-user fa-lg fa-fw me-2"></i>
                                <span class="tab-name">I miei appartamenti</span>
                            </a>
                            <a href="{{ route('admin.apartments.create') }}" id="add-apartment-btn" data-toggle="tooltip" title="Aggiungi un nuovo appartamento!" class="text-dark h-100 px-2 {{ Route::currentRouteName() == 'admin.apartments.create' ? 'd-none' : 'd-block'}}"><i class="fa-solid fa-plus"></i></a>
                        </li>
                        @if ( isset($apartments) && !$apartments->isEmpty() || str_contains(Route::currentRouteName(), 'admin.sponsors') || str_contains(Route::currentRouteName(), 'admin.messages') )
                            <li class="nav-item {{ str_contains(Route::currentRouteName(), 'admin.sponsors') ? 'bg-color-red' : '' }}">
                                <a class="nav-link text-dark d-flex align-items-center" href="{{route('admin.sponsors.index')}}">
                                    <i class="fa-solid fa-bullhorn fa-lg fa-fw me-2"></i>
                                    <span class="tab-name">Sponsorizza il tuo appartamento </span>
                                </a>
                            </li>
                        @endif
                        @if ( isset($apartments) && !$apartments->isEmpty() || str_contains(Route::currentRouteName(), 'admin.sponsors') || str_contains(Route::currentRouteName(), 'admin.messages') )
                            <li class="nav-item {{ str_contains(Route::currentRouteName(), 'admin.messages') ? 'bg-color-red' : '' }}">
                                <a class="nav-link text-dark d-flex align-items-center" href="{{route('admin.messages.index')}}">
                                    <i class="fa-solid fa-comments-dollar fa-lg fa-fw me-2"></i>
                                    <span class="tab-name">Messaggi</span>
                                </a>
                            </li>    
                        @endif
                    </ul>
                </aside>
        
                {{-- Right column --}}
                <section class="col-md-12 col-lg-9 right-column p-2">
                    @yield('content')
                </section>
            </div>
        </main>
    </div>
</body>

</html>
