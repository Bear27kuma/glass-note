@extends('layouts.app')

@section('content')
    <main class="sm:container">
        <div class="w-full">
            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-r-lg sm:shadow-sm sm:shadow-lg">
                <header class="relative font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-tr-lg">
                    Edit a note
                    <form action="{{ route('destroy') }}" method="POST">
                        @csrf
                        {{--削除機能も同様にどのノートを削除するのかをidで示すためinputのhiddenを設置--}}
                        <input type="hidden" name="note_id" value="{{ $edit_note[0]['id'] }}" />
                        <button class="absolute top-3 right-6 sm:right-8 px-4 py-2 text-lg text-white font-bold text-center font-semibold bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-offset-2 rounded-lg focus:ring-indigo-500 focus:ring-offset-indigo-200 transition ease-in duration-200" type="submit">Delete</button>
                    </form>
                </header>
                <form class="w-full my-6 px-6 sm:my-8 sm:px-8" action="{{ route('update') }}" method="POST">
                    @csrf
                    {{--どのノートを編集しているかを示すため、inputのhiddenでノートのidを埋め込んでおく → コントローラー側でどのノートをupdateさせるかが理解できる--}}
                    <input type="hidden" name="note_id" value="{{ $edit_note[0]['id'] }}" />
                    <div class="flex flex-wrap">
                        <label for="note" class="text-gray-700 w-full">
                            <textarea id="note" name="content" class="form-input w-full mb-6 sm:mb-8 px-4 py-2 text-2xl text-gray-700 placeholder-gray-400 rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-4 focus:ring-purple-600 focus:border-transparent {{ $errors->has('content') ? "border-4 border-red-600" : "" }}" rows="10" placeholder="Enter your content here...">{{ $edit_note[0]['content'] }}</textarea>
                        </label>
                    </div>
                    @error('content')
                    <div class="p-4 mb-6 sm:mb-8 bg-red-200 border-red-600 border-l-4 text-red-600" role="alert">
                        <p class="font-bold">Error</p>
                        <p>Note content is required.</p>
                    </div>
                    @enderror
                    <div class="flex flex-wrap mb-6 sm:mb-8">
                        @foreach($tags as $tag)
                            <div class="flex item-center mr-4 checkbox">
                                {{--三項演算子で紐づいているタグだけチェックを入れる処理を記述する--}}
                                {{--もし$include_tagsにループで回っているタグのidが含まれれば、checkedをつける--}}
                                <input type="checkbox" name="tags[]" id="{{ $tag['id'] }}" value="{{ $tag['id'] }}" {{ in_array($tag['id'], $include_tags) ? 'checked' : '' }} class="h-6 w-6 border border-gray-100 rounded-md focus:outline-none"/>
                                <label class="text-gray-700 font-normal ml-1" for="{{ $tag['id'] }}">{{ $tag['name'] }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="text" class="appearance-none rounded-lg border-2 border-gray-300 mb-6 sm:mb-8 py-2 px-4 w-1/2 text-2xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-purple-600 focus:border-transparent" name="new_tag" placeholder="Add a new tag...">
                    <button type="submit" class="w-full px-4 py-2 text-2xl text-white text-center font-semibold bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-offset-2 rounded-lg focus:ring-indigo-500 focus:ring-offset-indigo-200 transition ease-in duration-200">Update</button>
                </form>
            </section>
        </div>
    </main>
@endsection
