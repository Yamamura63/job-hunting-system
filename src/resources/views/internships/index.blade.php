@extends('layouts.app')

@section('title', 'インターンシップ一覧')

@section('content')

    {{-- ページタイトル・追加ボタン --}}
    <div class="sticky top-0 z-10 bg-gray-100 px-6 pt-5 pb-3">

        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">インターンシップ一覧</h1>

            <a href="{{ route('internship.create') }}" class="shrink-0 px-4 py-2 bg-blue-500 text-white rounded">
                ＋ インターンシップを追加
            </a>
        </div>

        {{-- 検索・絞り込み・並べ替え --}}
        <div class="mt-4 flex flex-wrap items-center gap-4">

            {{-- 検索 --}}
            <form action="{{ route('internship') }}" method="GET" class="flex flex-wrap items-center gap-2">

                <input type="search" name="searchI" value="{{ request('searchI') }}" placeholder="企業名を検索"
                    class="w-full sm:w-auto border rounded px-3 py-1">

                {{-- 他の条件を維持 --}}
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <input type="hidden" name="applied" value="{{ request('applied') }}">
                <input type="hidden" name="joined" value="{{ request('joined') }}">

                <button type="submit" class="px-3 py-1 bg-gray-500 text-white rounded">
                    検索
                </button>
            </form>

            {{-- 応募・参加状況の絞り込み --}}
            <form action="{{ route('internship') }}" method="GET" class="flex flex-wrap items-center gap-4">

                {{-- 他の条件を維持 --}}
                <input type="hidden" name="searchI" value="{{ request('searchI') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">

                {{-- 応募済み --}}
                <label class="flex items-center gap-1 cursor-pointer">
                    <input type="checkbox" name="applied" value="1" onchange="this.form.submit()"
                        @checked(request()->has('applied'))>
                    応募済み
                </label>

                {{-- 参加済み --}}
                <label class="flex items-center gap-1 cursor-pointer">
                    <input type="checkbox" name="joined" value="1" onchange="this.form.submit()"
                        @checked(request()->has('joined'))>
                    参加済み
                </label>
            </form>

            {{-- 並べ替え --}}
            <form action="{{ route('internship') }}" method="GET" class="flex flex-wrap items-center gap-2">

                {{-- 他の条件を維持 --}}
                <input type="hidden" name="searchI" value="{{ request('searchI') }}">
                <input type="hidden" name="applied" value="{{ request('applied') }}">
                <input type="hidden" name="joined" value="{{ request('joined') }}">

                <label for="sort">並べ替え：</label>

                <select name="sort" id="sort" class="border rounded px-2 py-1" onchange="this.form.submit()">
                    <option value="new" @selected(request('sort', 'new') === 'new')>
                        開催日時が遅い順
                    </option>
                    <option value="old" @selected(request('sort') === 'old')>
                        開催日時が早い順
                    </option>
                </select>
            </form>

        </div>
    </div>

    @if ($internships->isEmpty())
        <p class="px-6 mt-5">インターンシップが登録されていません。</p>
    @else
        <div class="mx-auto max-w-6xl rounded-lg p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3  gap-6 items-start">
                @foreach ($internships as $internship)
                    <div class="bg-white rounded-lg shadow p-6">

                        {{-- 上段 --}}
                        <div class="flex justify-between items-start">
                            <div class="w-full">

                                <div class="flex justify-between items-start border-b mb-2 w-full">
                                    <p class="text-xl font-bold truncate min-w-0">
                                        {{ $internship->name }}
                                    </p>

                                    {{-- 編集・削除 --}}
                                    <div class="flex items-center gap-2 shrink-0 ml-2">
                                        <a href="{{ route('internship.edit', $internship->id) }}"
                                            class="cursor-pointer hover:text-emerald-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 21h8M15 5l4 4m2.174-2.188a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('internship.destroy', $internship) }}" method="POST"
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

                                {{-- 企業 --}}
                                <p>
                                    <strong>企業：</strong>
                                    {{ $internship->company->name ?? '企業未登録' }}
                                </p>

                                {{-- 日程 --}}
                                <p>
                                    <strong>日程：</strong>

                                    @if ($internship->start_datetime)
                                        {{ \Carbon\Carbon::parse($internship->start_datetime)->format('Y/m/d H:i') }}
                                    @endif

                                    @if ($internship->end_datetime)
                                        ～ {{ \Carbon\Carbon::parse($internship->end_datetime)->format('Y/m/d H:i') }}
                                    @endif
                                </p>

                                {{-- URL --}}
                                @if ($internship->url)
                                    <div>
                                        <strong>URL：</strong>
                                        <a href="{{ $internship->url }}" target="_blank" class="text-blue-500 underline">
                                            インターンシップ詳細ページ
                                        </a>
                                    </div>
                                @else
                                    <div>
                                        <strong>URL：</strong>
                                        <span>登録なし</span>
                                    </div>
                                @endif

                                {{-- 応募・参加状況 --}}
                                <p>
                                    <strong>応募状況：</strong>
                                    @if ($internship->applied)
                                        <span class="text-green-600">応募済み</span>
                                    @else
                                        <span>未応募</span>
                                    @endif
                                </p>

                                <p>
                                    <strong>参加状況：</strong>
                                    @if ($internship->joined)
                                        <span class="text-green-600">参加済み</span>
                                    @else
                                        <span>未参加</span>
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
                                    <strong>開催場所：</strong><br>
                                    {{ $internship->place ?: 'なし' }}
                                </p>

                                <p>
                                    <strong>最寄り駅：</strong><br>
                                    {{ $internship->station ?: 'なし' }}
                                </p>

                                <div>
                                    <strong>内容：</strong>
                                    <p>
                                        {{ $internship->content ?: 'なし' }}
                                    </p>
                                </div>

                                <p>
                                    <strong>交通費支給：</strong>
                                    @if ($internship->carfare)
                                        あり
                                    @else
                                        なし
                                    @endif
                                </p>

                                <p>
                                    <strong>自費交通費：</strong><br>
                                    {{ $internship->carfare_price ?? 'なし' }}
                                </p>

                                <p>
                                    <strong>昼食支給：</strong>
                                    @if ($internship->lunch)
                                        あり
                                    @else
                                        なし
                                    @endif
                                </p>

                                <div>
                                    <strong>参加後メモ：</strong>
                                    <p>
                                        {{ $internship->joined_memo ?: 'なし' }}
                                    </p>
                                </div>

                                <button type="button" class="mt-4 cursor-pointer font-semibold text-blue-500 hover:text-blue-800 hover:underline"
                                    onclick="this.closest('details').removeAttribute('open')">
                                    ▲ 閉じる
                                </button>
                            </div>
                        </details>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
