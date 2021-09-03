@extends('layouts.auth')

@section('content')
    <main class="sm:container sm:mx-auto sm:max-w-lg sm:mt-32 login-form">
        <div class="flex">
            <div class="w-full">
                <section class="flex flex-col break-words bg-white backdrop-filter backdrop-blur-xl bg-opacity-10 sm:border-1 sm:rounded-2xl sm:shadow-sm sm:shadow-lg">

                    <header class="font-bold bg-gray-700 backdrop-filter backdrop-blur-sm bg-opacity-40 text-black py-5 px-6 sm:py-6 px-3 sm:px-8 px-4 rounded-t-2xl">
                        {{ __('Login') }}
                    </header>

                    <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" method="POST"
                          action="{{ route('login') }}">
                        @csrf

                        <div class="flex flex-wrap">
                            <label for="email" class="block text-gray-700 text-md font-bold mb-2 sm:mb-4">
                                {{ __('E-Mail Address') }}:
                            </label>

                            <input id="email" type="email"
                                   class="form-input w-full text-md font-medium @error('email') border-red-500 @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap">
                            <label for="password" class="block text-gray-700 text-md font-bold mb-2 sm:mb-4">
                                {{ __('Password') }}:
                            </label>

                            <input id="password" type="password"
                                   class="form-input w-full text-md font-medium @error('password') border-red-500 @enderror" name="password"
                                   required>

                            @error('password')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <label class="inline-flex items-center font-medium text-md text-gray-700" for="remember">
                                <input type="checkbox" name="remember" id="remember" class="form-checkbox"
                                        {{ old('remember') ? 'checked' : '' }}>
                                <span class="ml-2">{{ __('Remember Me') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-md text-blue-500 hover:text-blue-700 font-medium whitespace-no-wrap no-underline hover:underline ml-auto"
                                   href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="flex flex-wrap">
                            <button type="submit"
                                    class="w-full select-none font-bold whitespace-no-wrap p-3 rounded-lg text-xl leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 sm:py-4">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('register'))
                                <p class="w-full text-center text-gray-700 my-6 text-md font-medium my-8">
                                    {{ __("Don't have an account?") }}
                                    <a class="text-blue-500 hover:text-blue-700 no-underline hover:underline"
                                       href="{{ route('register') }}">
                                        {{ __('Register') }}
                                    </a>
                                </p>
                            @endif
                        </div>
                    </form>

                </section>
            </div>
        </div>
    </main>
@endsection
