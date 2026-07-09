@extends('layouts.app')

@section('title', '企業 - 編集')

@section('content')
    <h1 class="text-4xl p-3">企業編集</h1>
    <div class="p-8">
        <div class="mx-auto max-w-6xl rounded-lg bg-white p-8 shadow flex justify-center">
            @if ($errors->any())
                <div class="text-red-500">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('company.update', $company->id) }}" class="w-full max-w-2xl">
                @csrf
                @method('PUT')
                <div class="m-3">
                    <label class="text-lg font-bold">企業名</label>
                    <input type="text" name="name" required class="w-full m-2 border border-gray-500 rounded"
                        value="{{ old('name', $company->name) }}">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">志望度</label>
                    <div class="rate-form">
                        <input id="star5" type="radio" name="level" value="5" class="hidden"
                            {{ old('level', $company->level) == 5 ? 'checked' : '' }}>
                        <label for="star5">★</label>
                        <input id="star4" type="radio" name="level" value="4" class="hidden"
                            {{ old('level', $company->level) == 4 ? 'checked' : '' }}>
                        <label for="star4">★</label>
                        <input id="star3" type="radio" name="level" value="3" class="hidden"
                            {{ old('level', $company->level) == 3 ? 'checked' : '' }}>
                        <label for="star3">★</label>
                        <input id="star2" type="radio" name="level" value="2" class="hidden"
                            {{ old('level', $company->level) == 2 ? 'checked' : '' }}>
                        <label for="star2">★</label>
                        <input id="star1" type="radio" name="level" value="1" class="hidden"
                            {{ old('level', $company->level) == 1 ? 'checked' : '' }}>
                        <label for="star1">★</label>
                    </div>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">本社所在地</label><br>
                    <input type="text" name="address" class="w-full m-2 border border-gray-500 rounded"
                        value="{{ old('address', $company->address) }}">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">業種</label><br>
                    <input type="text" name="industry" class="w-full m-2 border border-gray-500 rounded"
                        value="{{ old('industry', $company->industry) }}">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">給与</label>
                    <div class="flex items-center">
                        <p class="text-lg">合計：</p>
                        <input type="hidden" name="salary" id="salary" value="{{ old('salary', $company->salary) }}">
                        <span id="salaryText" class="ml-2 text-xl"></span>
                        <p class="text-xl">万円</p>
                    </div>
                    <div class="ml-4 flex items-center">
                        <label class="text-base">基本給：</label>
                        <input type="number" id="kihon" name="basic_salary" min="0"
                            class="m-1 text-right border border-gray-500 rounded"
                            value="{{ old('basic_salary', $company->basic_salary) }}">
                        <p class="text-xs">万円</p>
                        <label class="text-base ml-5">その他：</label>
                        <input type="number" id="other" name="other_salary" min="0"
                            class="m-1 text-right border border-gray-500 rounded"
                            value="{{ old('other_salary', $company->other_salary) }}">
                        <p class="text-xs">万円</p>
                    </div>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">勤務時間</label><br>
                    <div class="ml-4">
                        <div class="flex items-center">
                            <input type="time" name="start_time" class="rounded"
                                value="{{ old('start_time', $company->start_time ?? '09:00') }}">
                            <p class="p-4">～</p>
                            <input type="time" name="end_time" class="rounded"
                                value="{{ old('end_time', $company->end_time ?? '18:00') }}">
                        </div>
                        <label class="text-base">休憩時間：</label>
                        <input type="number" name="break_time" class="m-2 text-right border border-gray-500 rounded"
                            value="{{ old('break_time', $company->break_time) }}">時間
                    </div>
                </div>

                <div class="m-3">
                    @php
                        $trainingYear = intdiv($company->training_period ?? 0, 12);
                        $trainingMonth = ($company->training_period ?? 0) % 12;
                    @endphp

                    <label class="text-lg font-bold">研修期間</label><br>
                    <div class="flex items-center">
                        <input type="number" id="training_year" name="training_year" min="0"
                            class="w-30 m-2 text-right border border-gray-500 rounded"
                            value="{{ old('training_year', $trainingYear) }}"> 年
                        <input type="number" id="training_month" name="training_month" min="0" max="11"
                            class="w-30 m-2 text-right border border-gray-500 rounded"
                            value="{{ old('training_month', $trainingMonth) }}"> か月
                    </div>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">SES度</label><br>
                    <div class="flex items-center gap-2">
                        <input id="no" type="radio" name="ses_level" value="なし"
                            {{ old('ses_level', $company->ses_level) == 'なし' ? 'checked' : '' }}>
                        <label for="no">なし</label>
                        <input id="low" type="radio" name="ses_level" value="低"
                            {{ old('ses_level', $company->ses_level) == '低' ? 'checked' : '' }}>
                        <label for="low">低</label>
                        <input id="high" type="radio" name="ses_level" value="高"
                            {{ old('ses_level', $company->ses_level) == '高' ? 'checked' : '' }}>
                        <label for="high">高</label>
                        <input id="miss" type="radio" name="ses_level" value="不明"
                            {{ old('ses_level', $company->ses_level) == '不明' ? 'checked' : '' }}>
                        <label for="miss">不明</label>
                    </div>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">URL</label>
                    @foreach ($company->urls as $index => $url)
                        <div class="flex gap-3 mt-3">
                            <input type="text" name="urls[{{ $index }}][memo]" placeholder="詳細（公式HP・採用ページ）"
                                class="memo border rounded p-2" value="{{ old("urls.$index.memo", $url->memo) }}">
                            <input type="url" name="urls[{{ $index }}][url]" placeholder="https://"
                                class="url border rounded p-2 flex-1" value="{{ old("urls.$index.url", $url->url) }}">
                            @if ($index === 0)
                                <button type="button" class="clear-url p-2 text-slate-400 border rounded">
                                    クリア
                                </button>
                            @else
                                <button type="button" class="delete-url p-2 text-white bg-slate-400 rounded">
                                    削除
                                </button>
                            @endif
                            <input type="hidden" name="urls[{{ $index }}][id]" value="{{ $url->id }}">
                        </div>
                    @endforeach
                    <div id="url-list"> </div>
                    <button type="button" id="add-url" class="mt-2 p-2 text-white bg-sky-400 hover:bg-sky-300 rounded">
                        ＋ URLを追加
                    </button>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">福利厚生メモ</label>
                    <textarea name="benefits_memo" rows="6" class="w-full resize-none m-2 border rounded">{{ old('benefits_memo', $company->benefits_memo) }}</textarea>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">メモ</label>
                    <textarea name="free_memo" rows="6" class="w-full resize-none m-2 border rounded">{{ old('free_memo', $company->free_memo) }}</textarea>
                </div>

                <div class="flex items-center">
                    <button type="submit"
                        class="mr-2 cursor-pointer text-lg text-white bg-blue-400 hover:bg-blue-300 rounded pt-2 pb-2 pl-4 pr-4">✐更新</button>
            </form>
                    <form action="{{ route('company.destroy', $company) }}" method="POST"
                        onsubmit="return confirm('この企業を削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center cursor-pointer hover:text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zm-6.287 10.713Q11 16.425 11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17t.713-.288m4 0Q15 16.426 15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17t.713-.288M7 6v13z" />
                            </svg>
                            <span class="ml-1">削除</span>
                        </button>
                    </form>
                </div>
    </div>
    </div>
    <a href="{{ route('company') }}" class="m-3 p-2 hover:bg-slate-300 rounded">
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

        calcSalary();


        document.addEventListener('click', (e) => {
            // クリア
            if (e.target.classList.contains('clear-url')) {
                const row = e.target.closest('.flex');
                row.querySelector('.memo').value = '';
                row.querySelector('.url').value = '';
            }
            // 削除
            if (e.target.classList.contains('delete-url')) {
                e.target.closest('.flex').remove();
            }
        });

        const urlList = document.getElementById('url-list');
        const addButton = document.getElementById('add-url');

        let index = {{ $company->urls->count() }};

        function addUrlRow() {
            const row = document.createElement('div');

            row.innerHTML = `
        <div class="flex gap-3 mt-3">
            <input
                type="text"
                name="urls[${index}][memo]"
                placeholder="詳細（公式HP・採用ページなど）"
                class="border rounded p-2">

            <input
                type="url"
                name="urls[${index}][url]"
                placeholder="https://"
                class="border rounded p-2 flex-1">

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
