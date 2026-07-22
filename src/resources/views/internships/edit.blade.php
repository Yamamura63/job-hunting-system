@extends('layouts.app')

@section('title', 'インターンシップ・選考 - 編集')

@section('content')
    <h1 class="text-4xl p-3">インターンシップ・選考編集</h1>

    <div class="p-8">
        <div class="mx-auto max-w-6xl rounded-lg bg-white p-8 shadow flex justify-center">

            <form method="POST" action="{{ route('internship.update', $internship) }}" class="w-full max-w-2xl">
                @csrf
                @method('PUT')

                {{-- インターンシップ名 --}}
                <div class="m-3">
                    <label class="text-lg font-bold">インターンシップ名</label>
                    <input
                        type="text"
                        name="name"
                        required
                        class="w-full m-2 border border-gray-500 rounded"
                        value="{{ old('name', $internship->name) }}"
                    >
                </div>

                {{-- 開催企業 --}}
                <div class="m-3">
                    <label class="text-lg font-bold">開催企業名</label>

                    <select name="company_id" class="border rounded">
                        <option value="">会社を選択してください</option>

                        @foreach ($companies as $company)
                            <option
                                value="{{ $company->id }}"
                                {{ old('company_id', $internship->company_id) == $company->id ? 'selected' : '' }}
                            >
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 開催時間 --}}
                <div class="m-3">
                    <label class="text-lg font-bold">開催時間</label><br>

                    <div class="ml-4">
                        <div class="flex items-center">

                            <input
                                type="datetime-local"
                                name="start_datetime"
                                value="{{ old('start_datetime', $internship->start_datetime ? \Carbon\Carbon::parse($internship->start_datetime)->format('Y-m-d\TH:i') : '') }}"
                                class="rounded"
                            >

                            <p class="p-4">～</p>

                            <input
                                type="datetime-local"
                                name="end_datetime"
                                value="{{ old('end_datetime', $internship->end_datetime ? \Carbon\Carbon::parse($internship->end_datetime)->format('Y-m-d\TH:i') : '') }}"
                                class="rounded"
                            >

                        </div>

                        <label class="text-base">休憩時間：</label>

                        <input
                            type="number"
                            name="break_time"
                            value="{{ old('break_time', $internship->break_time) }}"
                            class="m-2 border border-gray-500 rounded"
                        >時間
                    </div>
                </div>

                {{-- 開催場所 --}}
                <div class="m-3">
                    <label class="text-lg font-bold">開催場所</label><br>

                    <input
                        type="text"
                        name="place"
                        value="{{ old('place', $internship->place) }}"
                        class="w-full m-2 border border-gray-500 rounded"
                    >
                </div>

                {{-- 最寄り駅 --}}
                <div class="m-3">
                    <label class="text-lg font-bold">最寄り駅</label><br>

                    <input
                        type="text"
                        name="station"
                        value="{{ old('station', $internship->station) }}"
                        class="w-full m-2 border border-gray-500 rounded"
                    >
                </div>

                {{-- 内容 --}}
                <div class="m-3">
                    <label class="text-lg font-bold">内容</label>

                    <textarea
                        name="content"
                        rows="10"
                        class="w-full resize-none m-2 border rounded"
                    >{{ old('content', $internship->content) }}</textarea>
                </div>

                {{-- 交通費支給 --}}
                <div class="m-3">
                    <label class="text-lg font-bold">交通費支給</label>

                    <label>
                        <input
                            type="radio"
                            name="carfare"
                            value="1"
                            {{ old('carfare', $internship->carfare) == 1 ? 'checked' : '' }}
                        >
                        有
                    </label>

                    <label>
                        <input
                            type="radio"
                            name="carfare"
                            value="0"
                            {{ old('carfare', $internship->carfare) == 0 ? 'checked' : '' }}
                        >
                        無
                    </label>
                </div>

                {{-- 自費交通費 --}}
                <div class="m-3">
                    <label class="text-lg font-bold">自費交通費</label>

                    <input
                        type="number"
                        name="carfare_price"
                        value="{{ old('carfare_price', $internship->carfare_price) }}"
                        class="m-2 border border-gray-500 rounded"
                    >円
                </div>

                {{-- 昼食 --}}
                <div class="m-3">
                    <label class="text-lg font-bold">昼食有無</label>

                    <label>
                        <input
                            type="radio"
                            name="lunch"
                            value="1"
                            {{ old('lunch', $internship->lunch) == 1 ? 'checked' : '' }}
                        >
                        有
                    </label>

                    <label>
                        <input
                            type="radio"
                            name="lunch"
                            value="0"
                            {{ old('lunch', $internship->lunch) == 0 ? 'checked' : '' }}
                        >
                        無
                    </label>
                </div>

                {{-- 詳細URL --}}
                <div class="m-3">
                    <label class="text-lg font-bold">詳細URL</label>

                    <input
                        type="url"
                        name="url"
                        value="{{ old('url', $internship->url) }}"
                        placeholder="https://"
                        class="border rounded p-2 flex-1"
                    >
                </div>

                {{-- 応募済み --}}
                <div class="m-3">
                    <input
                        type="checkbox"
                        id="applied"
                        name="applied"
                        value="1"
                        {{ old('applied', $internship->applied) ? 'checked' : '' }}
                    >

                    <label for="applied" class="text-lg font-bold">
                        応募済み
                    </label>
                </div>

                {{-- 参加済み --}}
                <div class="m-3">
                    <input
                        type="checkbox"
                        id="joined"
                        name="joined"
                        value="1"
                        {{ old('joined', $internship->joined) ? 'checked' : '' }}
                    >

                    <label for="joined" class="text-lg font-bold">
                        参加済み
                    </label>
                </div>

                {{-- 参加メモ --}}
                <div class="m-3">
                    <label class="text-lg font-bold">参加メモ</label>

                    <textarea
                        name="joined_memo"
                        rows="4"
                        class="w-full resize-none m-2 border rounded"
                    >{{ old('joined_memo', $internship->joined_memo) }}</textarea>
                </div>

                {{-- 更新ボタン --}}
                <button
                    type="submit"
                    class="cursor-pointer text-lg text-white bg-blue-400 hover:bg-blue-300 border rounded pt-2 pb-2 pl-4 pr-4"
                >
                    ✐更新
                </button>

            </form>
        </div>
    </div>

    <a href="{{ route('internship') }}" class="border-b">
        ← 一覧に戻る
    </a>
@endsection
