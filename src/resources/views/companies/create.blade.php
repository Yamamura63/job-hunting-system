@extends('layouts.app')

@section('title', '企業 - 作成')

@section('content')
<h1 class="text-4xl p-3">企業登録</h1>
<div class="p-8">
    <div class="mx-auto max-w-6xl rounded-lg bg-white p-8 shadow flex justify-center">
        <form method="POST" action="{{ route('company.store') }}" class="w-full max-w-2xl">
            @csrf
            <label class="text-lg font-bold">企業名</label><br>
            <input type="text" name="name" required class="w-full m-2 border border-gray-500 rounded"><br>

            <label class="text-lg font-bold">志望度</label><br>
            <div class="rate-form">
                <input id="star5" type="radio" name="rate" value="5">
                <label for="star5">★</label>
                <input id="star4" type="radio" name="rate" value="4">
                <label for="star4">★</label>
                <input id="star3" type="radio" name="rate" value="3">
                <label for="star3">★</label>
                <input id="star2" type="radio" name="rate" value="2">
                <label for="star2">★</label>
                <input id="star1" type="radio" name="rate" value="1">
                <label for="star1">★</label>
            </div><br>

            <label class="text-lg font-bold">本社所在地</label><br>
            <input type="text" name="address" required class="w-full m-2 border border-gray-500 rounded"><br>

            <label class="text-lg font-bold">業種</label><br>
            <input type="text" name="industry" required class="w-full m-2 border border-gray-500 rounded"><br>

            <label class="text-lg font-bold">初任給</label><br>
            <input type="text" name="salary" required class="w-full m-2 border border-gray-500 rounded"><br>
            <div class="ml-4">
                <label class="text-base">基本給：</label>
                <input type="text" name="kihon" required class="w-full m-2 border border-gray-500 rounded"><br>
                <label class="text-base">その他：</label>
                <input type="text" name="ohter" required class="w-full m-2 border border-gray-500 rounded"><br>
            </div>

            <label class="text-lg font-bold">勤務時間</label><br>
            <div class="ml-4">
                <label class="text-base">出勤時間：</label>
                <input type="time" name="start">
                <label class="text-base">退勤時間：</label>
                <input type="time" name="end"><br>
                <label class="text-base">休憩時間：</label>
                <input type="text" name="break" required class="m-2 border border-gray-500 rounded">時間<br>
            </div>

            <label class="text-lg font-bold">研修期間</label><br>
            <input type="text" name="training" required class="w-full m-2 border border-gray-500 rounded"><br>

            <label class="text-lg font-bold">SES度</label><br>
            <div class="flex items-center gap-2">
                <input id="no" type="radio" name="ses" value="5">
                <label for="no">なし</label>
                <input id="low" type="radio" name="ses" value="4">
                <label for="low">低</label>
                <input id="high" type="radio" name="ses" value="3">
                <label for="high">高</label>
                <input id="miss" type="radio" name="ses" value="2">
                <label for="miss">不明</label>
            </div><br>

            <label class="text-lg font-bold">福利厚生メモ</label><br>
            <p id="error" class="text-red-500"></p>
            <textarea id="benefits" name="body" rows="6" required
                class="resize-none overflow-y-auto m-2 border rounded w-full"></textarea><br>

            <label class="text-lg font-bold">メモ</label><br>
            <p id="error" class="text-red-500"></p>
            <textarea id="free" name="body" rows="6" required
                class="resize-none overflow-y-auto m-2 border rounded w-full"></textarea><br>

            <br>
            <button type="submit" class="cursor-pointer text-lg text-white bg-blue-400 rounded pt-2 pb-2 pl-4 pr-4">✐登録</button>
        </form>
    </div>
</div>
<a href="{{ route('company') }}" class="border-b">
    ← 一覧に戻る
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
                `入力は${length}文字までです。`;
        } else {
            error.textContent = '';
        }
    }

    body.addEventListener('input', checkLength);
    target.addEventListener('change', checkLength);
</script>

@endsection