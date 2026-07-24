@extends('layouts.app')

@section('title', '選考 - 編集')

@section('content') <h1 class="text-4xl p-3">選考編集</h1>
    <div class="p-8">
        <div class="mx-auto max-w-6xl rounded-lg bg-white p-8 shadow flex justify-center">
            <form method="POST" action="{{ route('selection.update', $selection) }}" class="w-full max-w-2xl">
                @csrf
                @method('PUT')
                <div class="m-3">
                    <label class="text-lg font-bold">企業名 ： 選考段階</label>
                    <select name="company_id" class="m-2 border rounded">
                        <option value="">会社を選択してください</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" @selected(old('company_id', $selection->company_id) == $company->id)>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    ：
                    <input type="text" name="step" value="{{ old('step', $selection->step) }}" required
                        placeholder="ex.) 一次面接" class="m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">開催日時</label><br>
                    <input type="datetime-local" name="selection_datetime"
                        value="{{ old('selection_datetime', $selection->selection_datetime ? $selection->selection_datetime->format('Y-m-d\TH:i') : '') }}"
                        class="m-2 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">開催場所</label><br>
                    <input type="text" name="place" value="{{ old('place', $selection->place) }}"
                        class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">最寄り駅</label><br>
                    <input type="text" name="station" value="{{ old('station', $selection->station) }}"
                        class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">交通費支給</label>
                    <label>
                        <input type="radio" name="carfare" value="1" @checked(old('carfare', $selection->carfare) == '1')>
                        有
                    </label>
                    <label>
                        <input type="radio" name="carfare" value="0" @checked(old('carfare', $selection->carfare) == '0')>
                        無
                    </label>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">自費交通費</label>
                    <input type="number" name="carfare_price" value="{{ old('carfare_price', $selection->carfare_price) }}"
                        class="m-2 border border-gray-500 rounded">円
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">服装</label><br>
                    <input type="text" name="clothing" value="{{ old('clothing', $selection->clothing) }}"
                        class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">持ち物</label><br>
                    <input type="text" name="items" value="{{ old('items', $selection->items) }}"
                        class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">メモ</label>
                    <textarea name="free_memo" rows="4" class="w-full resize-none m-2 border rounded">{{ old('free_memo', $selection->free_memo) }}</textarea>
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">結果連絡期間</label><br>
                    <input type="text" name="result_period"
                        value="{{ old('result_period', $selection->result_period) }}" placeholder="2週間以内 / ○月○日頃"
                        class="w-full m-2 border border-gray-500 rounded">
                </div>

                <div class="m-3">
                    <label class="text-lg font-bold">現在状況</label><br>
                    <select name="status" class="m-2 border rounded">
                        <option value="noFinish" @selected(old('status', $selection->status) == 'noFinish')>未終了</option>
                        <option value="finish" @selected(old('status', $selection->status) == 'finish')>終了・結果未発表</option>
                        <option value="result" @selected(old('status', $selection->status) == 'result')>結果発表済み</option>
                    </select>
                </div>

                <button type="submit"
                    class="cursor-pointer text-lg text-white bg-blue-400 hover:bg-blue-300 border rounded pt-2 pb-2 pl-4 pr-4">
                    ✐更新
                </button>
            </form>
        </div>
    </div>

    <a href="{{ route('selection') }}" class="border-b">
        ← 一覧に戻る
    </a>
    ```

@endsection
