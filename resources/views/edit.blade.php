@extends('layouts.app')

@section('javascript')
    <script src="/js/confirm.js"></script>
@endsection

@section('content')
    <main class="sm:container">
        <div class="w-full">
            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-r-lg sm:shadow-sm sm:shadow-lg">
                <header class="relative font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-tr-lg">
                    Edit a note
                    {{--<form action="{{ route('destroy') }}" method="POST" id="delete-form">--}}
                    {{--    @csrf--}}
                    {{--    --}}{{--削除機能も同様にどのノートを削除するのかをidで示すためinputのhiddenを設置--}}
                    {{--    <input type="hidden" name="note_id" value="{{ $edit_note[0]['id'] }}" />--}}
                    {{--    --}}
                    {{--</form>--}}
                    <button class="absolute top-3 right-6 sm:right-8 px-4 py-2 text-lg text-white font-bold text-center font-semibold bg-red-600 hover:bg-red-800 focus:outline-none rounded-lg transition ease-in duration-200" onclick="popUpModule.showPopUp(event);">Delete</button>
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
                                <input type="checkbox" name="tags[]" id="{{ $tag['id'] }}" value="{{ $tag['id'] }}" {{ in_array($tag['id'], $include_tags) ? 'checked' : '' }} class="form-checkbox h-6 w-6 rounded-full border-2 border-gray-300 text-indigo-600 focus:outline-none focus:ring-0 focus:border-gray-300">
                                <label class="text-gray-700 font-normal ml-1" for="{{ $tag['id'] }}">{{ $tag['name'] }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="text" class="appearance-none rounded-lg border-2 border-gray-300 mb-6 sm:mb-8 py-2 px-4 w-1/2 text-2xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-purple-600 focus:border-transparent" name="new_tag" placeholder="Add a new tag...">
                    <button type="submit" class="w-full px-4 py-2 text-2xl text-white text-center font-semibold bg-indigo-600 hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-offset-2 rounded-lg focus:ring-indigo-500 focus:ring-offset-indigo-200 transition ease-in duration-200">Update</button>
                </form>
            </section>
        </div>
    </main>
    <div class="popup-cover hidden items-center justify-center" id="popup">
        <div class="shadow-lg rounded-2xl p-4 bg-white dark:bg-gray-800 w-80 m-auto">
            <div class="w-full h-full text-center">
                <div class="flex h-full flex-col justify-between">
                    <svg width="40" height="40" class="mt-4 w-12 h-12 m-auto text-indigo-500" fill="currentColor" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                        <path d="M704 1376v-704q0-14-9-23t-23-9h-64q-14 0-23 9t-9 23v704q0 14 9 23t23 9h64q14 0 23-9t9-23zm256 0v-704q0-14-9-23t-23-9h-64q-14 0-23 9t-9 23v704q0 14 9 23t23 9h64q14 0 23-9t9-23zm256 0v-704q0-14-9-23t-23-9h-64q-14 0-23 9t-9 23v704q0 14 9 23t23 9h64q14 0 23-9t9-23zm-544-992h448l-48-117q-7-9-17-11h-317q-10 2-17 11zm928 32v64q0 14-9 23t-23 9h-96v948q0 83-47 143.5t-113 60.5h-832q-66 0-113-58.5t-47-141.5v-952h-96q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h309l70-167q15-37 54-63t79-26h320q40 0 79 26t54 63l70 167h309q14 0 23 9t9 23z">
                        </path>
                    </svg>
                    <p class="text-gray-800 dark:text-gray-200 text-2xl font-bold mt-4">
                        Remove card
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 text-lg py-2 px-6">
                        Are you sure you want to delete this note ?
                    </p>
                    <div class="flex flex-col items-center justify-between gap-4 w-full mt-8">
                        <form action="{{ route('destroy') }}" method="POST" id="delete-form" class="w-full" onsubmit="popUpModule.clickDelete();">
                            @csrf
                            {{--削除機能も同様にどのノートを削除するのかをidで示すためinputのhiddenを設置--}}
                            <input type="hidden" name="note_id" value="{{ $edit_note[0]['id'] }}" />
                            <button type="submit" class="py-2 px-4  bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-xl font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg">
                                Delete
                            </button>
                        </form>
                        <button type="button" class="py-2 px-4 bg-white hover:bg-gray-100 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-indigo-500 text-white w-full transition ease-in duration-200 text-center text-xl font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" onclick="popUpModule.clickCancel();">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
