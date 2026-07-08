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
                <input id="star5" type="radio" name="rate" value="5" class="hidden">
                <label for="star5">★</label>
                <input id="star4" type="radio" name="rate" value="4" class="hidden">
                <label for="star4">★</label>
                <input id="star3" type="radio" name="rate" value="3" class="hidden" {{ old('rate', 3) == 3 ? 'checked' : '' }}>
                <label for="star3">★</label>
                <input id="star2" type="radio" name="rate" value="2" class="hidden">
                <label for="star2">★</label>
                <input id="star1" type="radio" name="rate" value="1" class="hidden">
                <label for="star1">★</label>
            </div><br>

            <label class="text-lg font-bold">本社所在地</label><br>
            <input type="text" name="address" class="w-full m-2 border border-gray-500 rounded"><br>

            <label class="text-lg font-bold">業種</label><br>
            <input type="text" name="industry" class="w-full m-2 border border-gray-500 rounded"><br>

            <label class="text-lg font-bold">給与</label><br>
            <input type="hidden" name="salary" id="salary">
            <span id="salaryText" class="text-xl"></span> 万円
            <div class="ml-4 flex items-center">
                <label class="text-base">基本給：</label>
                <input type="number" id="kihon" min="0" class="m-1 text-right border border-gray-500 rounded">
                <p class="text-xs">万円</p>
                <label class="text-base ml-5">その他：</label>
                <input type="number" id="other" min="0" class="m-1 text-right border border-gray-500 rounded">
                <p class="text-xs">万円</p>
            </div>

            <label class="text-lg font-bold">勤務時間</label><br>
            <div class="ml-4">
                <div class="flex items-center">
                    <input type="time" name="start" value="{{ old('start', '09:00') }}" class="rounded">
                    <p class="p-4">～</p>
                    <input type="time" name="end" value="{{ old('end', '18:00') }}" class="rounded">
                </div>
                <label class="text-base">休憩時間：</label>
                <input type="number" name="break" class="m-2 border border-gray-500 rounded">時間<br>
            </div>

            <label class="text-lg font-bold">研修期間</label><br>
            <div class="flex items-center">
                <input type="number" id="training_year" min="0" class="w-30 m-2 border border-gray-500 rounded"> 年
                <input type="number" id="training_month" min="0" max="11" class="w-30 m-2 border border-gray-500 rounded"> か月
            </div>

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
            <textarea id="benefits" name="body" rows="6"
                class="resize-none overflow-y-auto m-2 border rounded w-full"></textarea><br>

            <label class="text-lg font-bold">メモ</label><br>
            <p id="error" class="text-red-500"></p>
            <textarea id="free" name="body" rows="6"
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
    const kihon = document.getElementById('kihon');
    const other = document.getElementById('other');
    const salary = document.getElementById('salary'); // hidden
    const salaryText = document.getElementById('salaryText'); // 表示用

    function calcSalary() {
        const kihonValue = Number(kihon.value) || 0;
        const otherValue = Number(other.value) || 0;

        const total = kihonValue + otherValue;

        salary.value = total; // DBへ送信する値
        salaryText.textContent = total; // 画面に表示する値
    }

    kihon.addEventListener('input', calcSalary);
    other.addEventListener('input', calcSalary);


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