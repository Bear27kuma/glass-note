<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans text-xl">
    <div id="app">
        <header class="bg-blue-900 py-6">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div>
                    <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <nav class="space-x-4 text-gray-300 text-sm sm:text-base">
                    @guest
                        <a class="no-underline hover:underline" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                            <a class="no-underline hover:underline" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @else
                        <span>{{ Auth::user()->name }}</span>

                        <a href="{{ route('logout') }}"
                           class="no-underline hover:underline"
                           onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    @endguest
                </nav>
            </div>
        </header>

        {{--3 Columns Layout--}}
        <div class="bg-gray-300 grid sm:grid-cols-12 note-height sm:p-24">
            <div class="sm:col-span-2">
                <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-l-lg sm:shadow-sm sm:shadow-lg">
                    <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-tl-lg">
                        左カラム
                    </header>
                    <div class="w-full p-6">
                        <p class="text-gray-700">
                            You are in the left column!
                        </p>
                    </div>
                </section>
            </div>
            <div class="sm:col-span-4">
                <section class="flex flex-col break-words bg-white sm:border-1 sm:shadow-sm sm:shadow-lg">
                    <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8">
                        Notes List
                    </header>
                    <div class="w-full p-3 overflow-scroll">
                        <ul class="flex flex-col">
                            @foreach($notes as $note)
                                <li class="flex flex-row mb-2 border-gray-400">
                                    <a href="/edit/{{ $note['id'] }}"
                                       class="w-full flex justify-between items-center p-4 transition duration-500 shadow ease-in-out transform hover:-translate-y-1 hover:shadow-lg select-note cursor-pointer bg-white rounded-md">
                                        <div class="flex flex-col">
                                            <p class="mb-2">{{ $note['content'] }}</p>
                                            <span class="text-gray-400 text-sm">{{ $note['updated_at'] }}</span>
                                        </div>
                                        <button class="flex justify-end">
                                            <svg width="12" fill="currentColor" height="12" class="hover:text-gray-800 dark:hover:text-white dark:text-gray-200 text-gray-500" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1363 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45l166-166q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z">
                                                </path>
                                            </svg>
                                        </button>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
            </div>
            <div class="sm:col-span-6 ">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
