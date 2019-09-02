<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-200 text-gray-800 antialiased">
    <div id="app">
        <nav class="bg-white">
            <div class="container px-4 lg:px-10 mx-auto">
                <div class="flex justify-between items-center py-2">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ mix('images/logo.svg') }}" alt="Birdboard Logo">
                    </a>


                    <div>
                        <!-- Right Side Of Navbar -->
                        <ul class="flex items-center text-sm text-gray-700">
                            <!-- Authentication Links -->
                            @guest
                            <li class="">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="ml-5">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                            @else
                            <li class="flex">
                                <dropdown width="100%">

                                    <template #trigger>
                                        <button class="flex items-center p-2">
                                            <img src="{{ auth()->user()->gravatar }}" class="rounded-full w-8 h-8"
                                                alt="">

                                            <span class="ml-2">{{ auth()->user()->name }}</span>
                                        </button>

                                    </template>

                                    <template #default>
                                        <a class="dropdown__item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </template>
                                </dropdown>
                    

                            </li>

                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-4 container px-4 lg:px-10 mx-auto">
            @yield('content')
        </main>
    </div>
</body>

</html>