@extends('layouts.app')

@section('title', '自己PR作成')

@section('content')
<form method="POST" action="{{ route('selfPr.store') }}">
    @csrf
    <label>タイトル：</label>
    <input type="text" name="title" class="border"><br>

    <label>目標文字数</label>
    <select name="target_length" class="border">
        <option value="200">200文字</option>
        <option value="300">300文字</option>
        <option value="400">400文字</option>
        <option value="500">500文字</option>
        <option value="600">600文字</option>
        <option value="700">700文字</option>
        <option value="800">800文字</option>
    </select>

    <label>本文</label>
    <p>文字数：<span id="count">0</span>文字</p>
    <p id="error" class="text-red-500"></p>

    <textarea
        id="body"
        name="body"
        class="border"></textarea>
    <br>
    <button type="submit" class="cursor-pointer text-lg text-white bg-blue-400 rounded pl-4 pr-4">作成</button>
</form>

<a href="{{ route('selfPr') }}" class="border-b">
    一覧に戻る
</a>

<script>
    const text = document.getElementById('body');
    const count = document.getElementById('count');
    const target = document.querySelector('[name="target_length"]');
    const error = document.getElementById('error');

    function checkLength() {
        const length = text.value.length;

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
</script>

@endsection