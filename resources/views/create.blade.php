@extends('layouts.app')

@section('content')
    <main class="sm:container">
        <div class="w-full">
            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-r-lg sm:shadow-sm sm:shadow-lg">
                <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-tr-lg">
                    Create a new note
                </header>
                {{--route('store')と記述すると、自動的に/storeに書き換えられる--}}
                <form class="w-full my-6 px-6 sm:my-8 sm:px-8" action="{{ route('store') }}" method="POST">
                    {{--なりすまし送信防止の対策として@csrfをつける（Cross Site Request Forgeries）--}}
                    {{--他人がなりすましてログインし、データを送信する攻撃手法。そのためLaravelのformではcsrfトークンを発行する--}}
                    @csrf
                    <div class="flex flex-wrap">
                        <label for="note" class="text-gray-700 w-full">
                            <textarea id="note" name="content" class="form-input w-full mb-6 sm:mb-8 px-4 py-2 text-2xl text-gray-700 placeholder-gray-400 rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-4 focus:ring-purple-600 focus:border-transparent {{ $errors->has('content') ? "border-4 border-red-600" : "" }}" rows="10" placeholder="Enter your content here..."></textarea>
                        </label>
                    </div>
                    {{--バリデーションエラーが発生した場合にエラー文を表示させる--}}
                    @error('content')
                        <div class="p-4 mb-6 sm:mb-8 bg-red-200 border-red-600 border-l-4 text-red-600" role="alert">
                            <p class="font-bold">Error</p>
                            <p>Note content is required.</p>
                        </div>
                    @enderror
                    <div class="flex flex-wrap mb-6 sm:mb-8">
                        {{--foreachでDBから取得したタグを一覧表示する--}}
                        @foreach($tags as $tag)
                            <div class="flex item-center flex-wrap mr-4 ">
                                {{--nameがtags[]と配列になっているのは、ループ処理で複数のタグが設定されることを想定して、配列形式で送信する--}}
                                <input type="checkbox" name="tags[]" id="{{ $tag['id'] }}" value="{{ $tag['id'] }}" class="form-checkbox h-6 w-6 rounded-full border-2 border-gray-300 text-indigo-600 focus:outline-none focus:ring-0 focus:border-gray-300">
                                <label class="text-gray-700 font-normal ml-1" for="{{ $tag['id'] }}">{{ $tag['name'] }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="text" class="appearance-none rounded-lg border-2 border-gray-300 mb-6 sm:mb-8 py-2 px-4 w-1/2 text-2xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-purple-600 focus:border-transparent" name="new_tag" placeholder="Add a new tag...">
                    <button type="submit" class="w-full px-4 py-2 text-2xl text-white text-center font-semibold bg-indigo-600 hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-offset-2 rounded-lg focus:ring-indigo-500 focus:ring-offset-indigo-200 transition ease-in duration-200">Save</button>
                </form>
            </section>
        </div>
    </main>
@endsection
