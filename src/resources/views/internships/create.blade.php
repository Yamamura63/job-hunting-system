@extends('layouts.app')

@section('title', 'インターンシップ・選考 - 登録')

@section('content')
    <h1 class="text-4xl p-3">インターンシップ・選考登録</h1>
    <div class="p-8">
        <div class="mx-auto max-w-6xl rounded-lg bg-white p-8 shadow flex justify-center">
            <form method="POST" action="{{ route('internship.store') }}" class="w-full max-w-2xl">
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
                            <input type="datetime-local" name="start_datetime" value="{{ old('start', '09:00') }}" class="rounded">
                            <p class="p-4">～</p>
                            <input type="datetime-local" name="end_datetime" value="{{ old('end', '18:00') }}" class="rounded">
                        </div>
                        <label class="text-base">休憩時間：</label>
                        <input type="number" name="break_time" class="m-2 border border-gray-500 rounded">時間
                    </div>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">開催場所</label><br>
                    <input type="text" name="place" class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">最寄り駅</label><br>
                    <input type="text" name="station" class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">内容</label>
                    <textarea name="content" rows="10" class="w-full resize-none m-2 border rounded"></textarea>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">交通費支給</label>
                    <label><input type="radio" name="carfare" value="1" checked>有</label>
                    <label><input type="radio" name="carfare" value="0">無</label>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">自費交通費</label>
                    <input type="number" name="carfare_price" class="m-2 border border-gray-500 rounded">円
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">昼食有無</label>
                    <label><input type="radio" name="lunch" value="1" checked>有</label>
                    <label><input type="radio" name="lunch" value="0">無</label>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">詳細URL</label>
                    <input type="url" name="url" placeholder="https://" class="border rounded p-2 flex-1">
                </div>

                <div class="m-3">
                    <input type="checkbox" id="applied" name="applied" value="1">
                    <label class="text-lg font-bold">応募済み</label>
                </div>

                <div class="m-3">
                    <input type="checkbox" id="joined" name="joined" value="1">
                    <label class="text-lg font-bold">参加済み</label>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">参加メモ</label>
                    <textarea name="joined_memo" rows="4" class="w-full resize-none m-2 border rounded"></textarea>
                </div>

                <button type="submit"
                    class="cursor-pointer text-lg text-white bg-blue-400 hover:bg-blue-300 border rounded pt-2 pb-2 pl-4 pr-4">✐登録</button>
            </form>
        </div>
    </div>
    <a href="{{ route('internship') }}" class="border-b">
        ← 一覧に戻る
    </a>

    <script>
    </script>

@endsection
