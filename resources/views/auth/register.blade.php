@extends('layouts.auth')

@section('content')
    <main class="sm:container sm:mx-auto sm:max-w-lg sm:mt-10">
        <div class="flex">
            <div class="w-full">
                <section class="flex flex-col break-words bg-white backdrop-filter backdrop-blur-xl bg-opacity-10 sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

                    <header class="font-bold bg-gray-700 backdrop-filter backdrop-blur-sm bg-opacity-40 text-black sm:py-6 py-3 sm:px-8 px-4 sm:py-6 sm:px-8 sm:rounded-t-md">
                        {{ __('Register') }}
                    </header>

                    <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" method="POST"
                          action="{{ route('register') }}">
                        @csrf

                        <div class="flex flex-wrap">
                            <label for="name" class="block text-gray-700 text-md font-bold mb-2 sm:mb-4">
                                {{ __('Name') }}:
                            </label>

                            <input id="name" type="text"
                                   class="form-input w-full text-md font-medium @error('name')  border-red-500 @enderror"
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap">
                            <label for="email" class="block text-gray-700 text-md font-bold mb-2 sm:mb-4">
                                {{ __('E-Mail Address') }}:
                            </label>

                            <input id="email" type="email"
                                   class="form-input w-full text-md font-medium @error('email') border-red-500 @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email">

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
                                   required autocomplete="new-password">

                            @error('password')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap">
                            <label for="password-confirm" class="block text-gray-700 text-md font-bold mb-2 sm:mb-4">
                                {{ __('Confirm Password') }}:
                            </label>

                            <input id="password-confirm" type="password" class="form-input w-full text-md font-bold"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="flex flex-wrap">
                            <button type="submit"
                                    class="w-full select-none font-bold whitespace-no-wrap p-3 rounded-lg text-xl leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 sm:py-4">
                                {{ __('Register') }}
                            </button>

                            <p class="w-full text-md font-medium text-center text-gray-700 my-6 sm:text-sm sm:my-8">
                                {{ __('Already have an account?') }}
                                <a class="text-blue-500 hover:text-blue-700 no-underline hover:underline"
                                   href="{{ route('login') }}">
                                    {{ __('Login') }}
                                </a>
                            </p>
                        </div>
                    </form>

                </section>
            </div>
        </div>
    </main>
@endsection
