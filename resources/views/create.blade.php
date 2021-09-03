@extends('layouts.app')

@section('content')
    <main>
        <div class="w-full">
            <section class="w-full flex flex-col break-words bg-white backdrop-filter backdrop-blur-lg bg-opacity-20 sm:border-1 md:rounded-r-lg md:rounded-bl-none rounded-b-lg shadow-2xl">
                <header class="font-semibold bg-gray-200 backdrop-filter backdrop-blur-md bg-opacity-30 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 md:rounded-tr-lg">
                    Create a new note
                </header>
                {{--route('store')と記述すると、自動的に/storeに書き換えられる--}}
                <form class="w-full my-6 px-6 sm:my-8 sm:px-8" action="{{ route('store') }}" method="POST">
                    {{--なりすまし送信防止の対策として@csrfをつける（Cross Site Request Forgeries）--}}
                    {{--他人がなりすましてログインし、データを送信する攻撃手法。そのためLaravelのformではcsrfトークンを発行する--}}
                    @csrf
                    <div class="flex flex-wrap">
                        <label for="note" class="text-gray-700 w-full">
                            <textarea id="note" name="content" class="form-input w-full mb-6 sm:mb-8 px-4 py-2 text-2xl font-medium text-gray-700 placeholder-gray-500 bg-white backdrop-filter backdrop-blur-md bg-opacity-50 rounded-lg border-2 border-gray-500 focus:outline-none focus:ring-4 focus:ring-purple-600 focus:border-transparent {{ $errors->has('content') ? "border-4 border-red-600" : "" }}" rows="10" placeholder="Enter your content here..."></textarea>
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
                            <div class="flex item-center flex-wrap mr-4 mb-2">
                                {{--nameがtags[]と配列になっているのは、ループ処理で複数のタグが設定されることを想定して、配列形式で送信する--}}
                                <input type="checkbox" name="tags[]" id="{{ $tag['id'] }}" value="{{ $tag['id'] }}" class="form-checkbox h-6 w-6 rounded-full bg-white backdrop-filter backdrop-blur-md bg-opacity-50 border-2 border-gray-500 text-indigo-600 focus:outline-none focus:ring-0 focus:border-gray-500">
                                <label class="text-gray-700 font-medium ml-1" for="{{ $tag['id'] }}">{{ $tag['name'] }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="text" class="appearance-none rounded-lg border-2 border-gray-500 mb-6 sm:mb-8 py-2 px-4 w-1/2 bg-white backdrop-filter backdrop-blur-md bg-opacity-50 text-2xl font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-purple-600 focus:border-transparent" name="new_tag" placeholder="Add a new tag...">
                    <button type="submit" class="w-full px-4 py-2 text-2xl text-white text-center font-semibold bg-indigo-600 hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-offset-2 rounded-lg focus:ring-indigo-500 focus:ring-offset-indigo-200 transition ease-in duration-200">Save</button>
                </form>
            </section>
        </div>
    </main>
@endsection
