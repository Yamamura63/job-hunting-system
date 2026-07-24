@extends('layouts.app')

@section('title', '企業 - 登録')

@section('content')
    <h1 class="text-4xl p-3">企業登録</h1>
    <div class="p-8">
        <div class="mx-auto max-w-6xl rounded-lg bg-white p-4 sm:p-8 shadow flex justify-center">
            <form method="POST" action="{{ route('company.store') }}" class="w-full max-w-2xl">
                @csrf
                <div class="m-3">
                    <label class="text-lg font-bold">企業名</label>
                    <input type="text" name="name" required class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">志望度</label>
                    <div class="rate-form">
                        <input id="star5" type="radio" name="level" value="5" class="hidden">
                        <label for="star5">★</label>
                        <input id="star4" type="radio" name="level" value="4" class="hidden">
                        <label for="star4">★</label>
                        <input id="star3" type="radio" name="level" value="3" class="hidden"
                            {{ old('rate', 3) == 3 ? 'checked' : '' }}>
                        <label for="star3">★</label>
                        <input id="star2" type="radio" name="level" value="2" class="hidden">
                        <label for="star2">★</label>
                        <input id="star1" type="radio" name="level" value="1" class="hidden">
                        <label for="star1">★</label>
                    </div>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">本社所在地</label><br>
                    <input type="text" name="address" class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">業種</label><br>
                    <input type="text" name="industry" class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">給与</label>
                    <div class="flex items-center">
                        <p class="text-lg">合計：</p>
                        <input type="hidden" name="salary" id="salary">
                        <span id="salaryText" class="ml-2 text-xl"></span>
                        <p class="text-xl">万円</p>
                    </div>
                    <div class="ml-4 flex flex-wrap items-center gap-x-2 gap-y-1">
                        <label class="text-base whitespace-nowrap">基本給：</label>
                        <input type="number" id="kihon" name="basic_salary" min="0"
                            class="w-20 min-w-0 box-border m-1 text-right border border-gray-500 rounded">
                        <p class="text-xs whitespace-nowrap">万円</p>

                        <label class="text-base whitespace-nowrap ml-2">その他：</label>
                        <input type="number" id="other" name="other_salary" min="0"
                            class="w-20 min-w-0 box-border m-1 text-right border border-gray-500 rounded">
                        <p class="text-xs whitespace-nowrap">万円</p>
                    </div>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">勤務時間</label><br>
                    <div class="ml-4">
                        <div class="flex items-center">
                            <input type="time" name="start_time" value="{{ old('start', '09:00') }}" class="rounded">
                            <p class="p-4">～</p>
                            <input type="time" name="end_time" value="{{ old('end', '18:00') }}" class="rounded">
                        </div>
                        <label class="text-base">休憩時間：</label>
                        <input type="number" name="break_time" class="m-2 w-20 border border-gray-500 rounded">時間
                    </div>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">研修期間</label><br>
                    <div class="flex flex-wrap items-center gap-1">
                        <input type="number" id="training_year" name="training_year" min="0"
                            class="w-20 min-w-0 box-border m-2 border border-gray-500 rounded">
                        <span class="whitespace-nowrap">年</span>

                        <input type="number" id="training_month" name="training_month" min="0" max="11"
                            class="w-20 min-w-0 box-border m-2 border border-gray-500 rounded">
                        <span class="whitespace-nowrap">か月</span>
                    </div>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">SES度</label><br>
                    <div class="flex items-center gap-2">
                        <input id="no" type="radio" name="ses_level" value="なし">
                        <label for="no">なし</label>
                        <input id="low" type="radio" name="ses_level" value="低">
                        <label for="low">低</label>
                        <input id="high" type="radio" name="ses_level" value="高">
                        <label for="high">高</label>
                        <input id="miss" type="radio" name="ses_level" value="不明" checked>
                        <label for="miss">不明</label>
                    </div>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">URL</label>
                    <div class="flex flex-col sm:flex-row gap-3 mt-3 min-w-0">
                        <input type="text" name="urls[0][memo]" placeholder="詳細（公式HP・採用ページ）"
                            class="w-full sm:w-1/3 min-w-0 box-border border rounded p-2">

                        <input type="url" name="urls[0][url]" placeholder="https://"
                            class="w-full sm:flex-1 min-w-0 box-border border rounded p-2">

                        <button type="button" class="p-2 invisible hidden sm:block">
                            削除
                        </button>
                    </div>
                    <div id="url-list">
                    </div>
                    <button type="button" id="add-url"
                        class="mt-2 p-2 text-white bg-sky-400 hover:bg-sky-300 rounded">
                        ＋ URLを追加
                    </button>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">福利厚生メモ</label>
                    <textarea name="benefits_memo" rows="6" class="w-full resize-none m-2 border rounded"></textarea>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">メモ</label>
                    <textarea name="free_memo" rows="6" class="w-full resize-none m-2 border rounded"></textarea>
                </div>

                <button type="submit"
                    class="cursor-pointer text-lg text-white bg-blue-400 hover:bg-blue-300 rounded pt-2 pb-2 pl-4 pr-4">✐登録</button>
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


        const urlList = document.getElementById('url-list');
        const addButton = document.getElementById('add-url');

        let index = 1;

        function addUrlRow() {
            const row = document.createElement('div');

            row.innerHTML = `
    <div class="flex flex-col sm:flex-row gap-3 mt-3 min-w-0">
        <input
            type="text"
            name="urls[${index}][memo]"
            placeholder="詳細（公式HP・採用ページなど）"
            class="w-full sm:w-1/3 min-w-0 box-border border rounded p-2">

        <input
            type="url"
            name="urls[${index}][url]"
            placeholder="https://"
            class="w-full sm:flex-1 min-w-0 box-border border rounded p-2">

        <button type="button" class="delete-url p-2 text-white bg-slate-400 rounded">
            削除
        </button>
    </div>
`;

            urlList.appendChild(row);

            row.querySelector('.delete-url').addEventListener('click', () => {
                row.remove();
            });

            index++;
        }

        addButton.addEventListener('click', addUrlRow);
    </script>

@endsection
