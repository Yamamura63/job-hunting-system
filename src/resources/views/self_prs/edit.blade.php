@extends('layouts.app')

@section('title', '自己PR - 編集')

@section('content')
<h1 class="text-4xl p-3">自己PR編集</h1>
<div class="p-8">
    <div class="mx-auto max-w-6xl rounded-lg bg-white p-8 shadow flex justify-center">
        <form method="POST" action="{{ route('selfPr.update', $selfPr->id) }}" class="w-full max-w-2xl">
            @csrf
            @method("PUT")
            <label class="text-lg font-bold">タイトル名</label><br>
            <input type="text" name="title" required class="w-full m-2 border border-gray-500 rounded"
                value="{{ old('title', $selfPr->title) }}">
            <br>

            <div class="flex justify-between items-baseline">
                <label class="text-lg font-bold">本文</label>
                
                <div class="flex items-center mt-3">
                    <p>文字数：
                    <span id="count">0</span> / </p>
                    <select name="target_length" class="border-b border-gray-500">
                        <option value="200">200文字</option>
                        <option value="300">300文字</option>
                        <option value="400">400文字</option>
                        <option value="500">500文字</option>
                        <option value="600">600文字</option>
                        <option value="700">700文字</option>
                        <option value="800">800文字</option>
                    </select>
                </div>
            </div>
            <p id="error" class="text-red-500"></p>
            <textarea id="body" name="body" rows="6" required
                class="resize-none overflow-y-auto m-2 border rounded w-full">{{ old('body', $selfPr->body) }}</textarea>
            <br>
            <button type="submit" class="cursor-pointer text-lg text-white bg-blue-400 rounded pt-2 pb-2 pl-4 pr-4">✐更新</button>
        </form>
    </div>
</div>
<a href="{{ route('selfPr') }}" class="border-b">
        ✕ 保存せずに終了
    </a>

<script>
    const body = document.getElementById('body');
    const count = document.getElementById('count');
    const target = document.querySelector('[name="target_length"]');
    const error = document.getElementById('error');

    function checkLength() {
        const length = body.value.length;

        count.textContent = length;

        if (length > target.value) {
            error.textContent =
                `目標文字数を${length - target.value}文字超えています`;
        } else {
            error.textContent = '';
        }
    }

    body.addEventListener('input', checkLength);
    target.addEventListener('change', checkLength);
    checkLength();
</script>

@endsection