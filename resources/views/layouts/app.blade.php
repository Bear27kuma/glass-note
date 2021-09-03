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
    @yield('javascript')
    
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-pink-300 via-purple-300 to-indigo-400 w-full h-full antialiased leading-none font-sans text-xl relative">
    <div id="app">
        <header class="bg-white py-6 backdrop-filter backdrop-blur-lg bg-opacity-30">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div>
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800 no-underline">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <nav class="space-x-4 text-gray-800 font-semibold text-lg">
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
        <div class="grid sm:grid-cols-12 lg:p-24 sm:p-8 p-3 w-full h-full">
            <div class="md:col-span-2 sm:col-span-5">
                <section class="flex flex-col break-words bg-white backdrop-filter backdrop-blur-md bg-opacity-20 sm:border-1 md:rounded-l-lg sm:rounded-tl-lg sm:rounded-tr-none rounded-t-lg shadow-2xl col-height">
                    <header class="font-semibold bg-gray-200 backdrop-filter backdrop-blur-md bg-opacity-30 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-tl-lg sm:rounded-tr-none rounded-t-lg">
                        Tags List
                    </header>
                    <div class="w-full p-3 pt-6 flex flex-wrap justify-around ">
                        <a href="/" class="w-full mb-6 px-2 py-1 text-white font-semibold text-center bg-indigo-600 border-2 border-indigo-600 rounded-md transition ease-in duration-200 focus:outline-none hover:border-indigo-800 hover:bg-indigo-800">All</a>
                        @foreach($tags as $tag)
                            <a href="/?tag={{ $tag['id'] }}" class="mb-3 px-2 py-1 text-indigo-600 font-semibold border-2 border-indigo-600 rounded-md transition ease-in duration-200 hover:bg-indigo-600 hover:text-white">{{ $tag['name'] }}</a>
                        @endforeach
                    </div>
                </section>
            </div>
            <div class="md:col-span-4 sm:col-span-7">
                <section class="flex flex-col break-words bg-white backdrop-filter backdrop-blur-md bg-opacity-20 sm:border-1 shadow-2xl md:rounded-br-lg md:rounded-tr-none sm:rounded-tr-lg col-height-list">
                    <header class="font-semibold bg-gray-200 backdrop-filter backdrop-blur-md bg-opacity-30 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 md:rounded-tr-none sm:rounded-tr-lg rounded-tr-none">
                        Notes List
                    </header>
                    <div class="w-full md:p-6 px-3  h-full overflow-scroll">
                        <ul class="flex flex-col">
                            {{--ノートの内容は配列で渡されるため、ループ処理で表示させる--}}
                            @foreach($notes as $note)
                                <li class="flex flex-row mb-2">
                                    <a href="/edit/{{ $note['id'] }}"
                                       class="w-full flex justify-between items-center p-4 transition duration-500 shadow ease-in-out transform hover:-translate-y-1 hover:shadow-lg select-note cursor-pointer bg-white backdrop-filter backdrop-blur-md bg-opacity-50 rounded-md">
                                        <div class="flex flex-col">
                                            <p class="mb-2 font-medium">{{ $note['content'] }}</p>
                                            <span class="text-gray-700 text-sm font-normal">{{ $note['updated_at'] }}</span>
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
            <div class="md:col-span-6 sm:col-span-12">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
