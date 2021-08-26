@extends('layouts.app')

@section('content')
    <main class="sm:container">
        <div class="w-full">
            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-r-lg sm:shadow-sm sm:shadow-lg">
                <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-tr-lg">
                    Create a new note
                </header>
                <form class="w-full my-6 px-6 sm:my-8 sm:px-8" action="{{ route('store') }}" method="POST">
                    @csrf
                    <div class="flex flex-wrap">
                        <label for="note" class="text-gray-700 w-full">
                            <textarea id="note" name="content" class="form-input w-full mb-6 sm:mb-8 px-4 py-2 text-2xl text-gray-700 placeholder-gray-400 rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-4 focus:ring-purple-600 focus:border-transparent" rows="10" placeholder="Enter your content here..."></textarea>
                        </label>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 text-2xl text-white text-center font-semibold bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-offset-2 rounded-lg focus:ring-indigo-500 focus:ring-offset-indigo-200 transition ease-in duration-200">Save</button>
                </form>
            </section>
        </div>
    </main>
@endsection
