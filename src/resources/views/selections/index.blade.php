@extends('layouts.app')

@section('title', '選考一覧')

@section('content')
    <div class="sticky top-0 z-10 bg-gray-100 px-6 pt-5 pb-3">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">選考一覧</h1>
            <a href="{{ route('selection.create') }}" class="shrink-0 px-4 py-2 bg-blue-500 text-white rounded">
                ＋ 選考予定を追加
            </a>
        </div>

        {{-- 検索・絞り込み・並べ替え --}}
        <div class="mt-4 flex flex-wrap items-center gap-4">
            {{-- 検索 --}}
            <form action="{{ route('selection') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="search" name="searchS" value="{{ request('searchS') }}" placeholder="企業名を検索"
                    class="w-full sm:w-auto border rounded px-3 py-1">
                {{-- 他の条件を維持 --}}
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <button type="submit" class="px-3 py-1 bg-gray-500 text-white rounded">
                    検索
                </button>
            </form>

            {{-- 状況で絞り込み --}}
            <form action="{{ route('selection') }}" method="GET" class="flex flex-wrap items-center gap-2">
                {{-- 他の条件を維持 --}}
                <input type="hidden" name="searchS" value="{{ request('searchS') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">

                <label for="status">状況：</label>
                <select name="status" id="status" class="border rounded px-2 py-1" onchange="this.form.submit()">
                    <option value="" @selected(request('status') === null)>
                        すべて
                    </option>
                    <option value="noFinish" @selected(request('status') === 'noFinish')>
                        未終了
                    </option>
                    <option value="finish" @selected(request('status') === 'finish')>
                        終了・結果未発表
                    </option>
                    <option value="result" @selected(request('status') === 'result')>
                        結果発表済み
                    </option>
                </select>
            </form>

            {{-- 並べ替え --}}
            <form action="{{ route('selection') }}" method="GET" class="flex flex-wrap items-center gap-2">
                {{-- 他の条件を維持 --}}
                <input type="hidden" name="searchS" value="{{ request('searchS') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">

                <label for="sort">並べ替え：</label>
                <select name="sort" id="sort" class="border rounded px-2 py-1" onchange="this.form.submit()">
                    <option value="new" @selected(request('sort', 'new') === 'new')>
                        開催日時が遅い順
                    </option>
                    <option value="old" @selected(request('sort') === 'old')>
                        開催日時が早い順
                    </option>
                    <option value="company_asc" @selected(request('sort') === 'company_asc')>
                        企業名 昇順
                    </option>
                    <option value="company_desc" @selected(request('sort') === 'company_desc')>
                        企業名 降順
                    </option>
                </select>
            </form>

        </div>

    </div>


    @if ($selections->isEmpty())
        <p class="px-6 mt-5">選考予定が登録されていません。</p>
    @else
        <div class="mx-auto max-w-6xl rounded-lg p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3  gap-6 items-start">
                @foreach ($selections as $selection)
                    <div class="bg-white rounded-lg shadow p-6">

                        {{-- 上段 --}}
                        <div class="flex justify-between items-start">
                            <div class="w-full">

                                {{-- 企業名・編集削除 --}}
                                <div class="flex justify-between items-start border-b mb-2">
                                    <p class="text-xl font-bold truncate">
                                        {{ $selection->company->name }}：{{ $selection->step }}
                                    </p>

                                    {{-- 編集・削除 --}}
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('selection.edit', $selection->id) }}"
                                            class="cursor-pointer hover:text-emerald-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 21h8M15 5l4 4m2.174-2.188a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('selection.destroy', $selection) }}" method="POST"
                                            onsubmit="return confirm('削除しますか？')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="cursor-pointer hover:text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zm-6.287 10.713Q11 16.425 11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17t.713-.288m4 0Q15 16.426 15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17t.713-.288M7 6v13z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <p>
                                    <strong>選考日時：</strong>
                                    @if ($selection->selection_datetime)
                                        {{ \Carbon\Carbon::parse($selection->selection_datetime)->format('Y/m/d H:i') }}
                                    @else
                                        未定
                                    @endif
                                </p>

                                <p>
                                    <strong>状況：</strong>
                                    @if ($selection->status === 'noFinish')
                                        未終了
                                    @elseif ($selection->status === 'finish')
                                        終了
                                    @elseif ($selection->status === 'result')
                                        結果発表済み
                                    @endif
                                </p>

                            </div>
                        </div>

                        {{-- 詳細 --}}
                        <details class="mt-4 group">
                            <summary class="cursor-pointer font-semibold list-none">
                                <span
                                    class="group-open:hidden cursor-pointer font-semibold text-blue-500 hover:text-blue-800 hover:underline">▼
                                    詳細を見る</span>
                            </summary>

                            <div class="mt-3 space-y-2">
                                <p>
                                    <strong>服装：</strong><br>
                                    {{ $selection->clothing ?: 'なし' }}
                                </p>

                                <p>
                                    <strong>持ち物：</strong><br>
                                    {{ $selection->items ?: 'なし' }}
                                </p>

                                <p>
                                    <strong>開催場所：</strong><br>
                                    {{ $selection->place ?: 'なし' }}
                                </p>

                                <p>
                                    <strong>最寄り駅：</strong><br>
                                    {{ $selection->station ?: 'なし' }}
                                </p>

                                <p>
                                    <strong>交通費支給：</strong>
                                    @if ($selection->carfare)
                                        あり
                                    @else
                                        なし
                                    @endif
                                </p>

                                <p>
                                    <strong>自費交通費：</strong>
                                    {{ $selection->carfare_price ?? 'なし' }}円
                                </p>

                                <div>
                                    <strong>メモ：</strong>
                                    <p>
                                        {{ $selection->free_memo ?: 'なし' }}
                                    </p>
                                </div>

                                <p>
                                    <strong>結果連絡期間：</strong><br>
                                    {{ $selection->result_period ?: 'なし' }}
                                </p>
                            </div>

                            <button type="button"
                                class="mt-4 cursor-pointer font-semibold text-blue-500 hover:text-blue-800 hover:underline"
                                onclick="this.closest('details').removeAttribute('open')">
                                ▲ 閉じる
                            </button>
                        </details>

                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
