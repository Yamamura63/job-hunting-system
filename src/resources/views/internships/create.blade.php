@extends('layouts.app')

@section('title', 'インターンシップ・選考 - 登録')

@section('content')
    <h1 class="text-4xl p-3">インターンシップ・選考登録</h1>
    <div class="p-8">
        <div class="mx-auto max-w-6xl rounded-lg bg-white p-8 shadow flex justify-center">
            <form method="POST" action="{{ route('company.store') }}" class="w-full max-w-2xl">
                @csrf
                <div class="m-3">
                    <label class="text-lg font-bold">インターンシップ名</label>
                    <input type="text" name="name" required class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">開催企業名</label>
                    <select name="company_id" class="border rounded">
                        <option value="">会社を選択してください</option>

                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">開催時間</label><br>
                    <div class="ml-4">
                        <div class="flex items-center">
                            <input type="time" name="start_time" value="{{ old('start', '09:00') }}" class="rounded">
                            <p class="p-4">～</p>
                            <input type="time" name="end_time" value="{{ old('end', '18:00') }}" class="rounded">
                        </div>
                        <label class="text-base">休憩時間：</label>
                        <input type="number" name="break_time" class="m-2 border border-gray-500 rounded">時間
                    </div>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">開催場所</label><br>
                    <input type="text" name="address" class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">最寄り駅</label><br>
                    <input type="text" name="industry" class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">内容</label>
                    <textarea name="free_memo" rows="10" class="w-full resize-none m-2 border rounded"></textarea>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">URL</label>
                    <div class="flex gap-3 mt-3">
                        <input type="text" name="urlname" placeholder="マイナビなど"
                            class="border rounded p-2">
                        <input type="url" name="url" placeholder="https://"
                            class="border rounded p-2 flex-1">
                    </div>
                    <div id="url-list">
                    </div>
                    <button type="button" id="add-url"
                        class="mt-2 p-2 text-white bg-sky-400 hover:bg-sky-300 rounded">
                        ＋ URLを追加
                    </button>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">参加メモ</label>
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
