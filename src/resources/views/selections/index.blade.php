@extends('layouts.app')

@section('title', '選考一覧')

@section('content')
    <div class="flex justify-between items-center mt-5 mb-5 ml-6 mr-9 gap-2 shrink-0">
        <h1 class="text-3xl font-bold">選考一覧</h1>

        <a href="{{ route('selection.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
            ＋ 選考予定を追加
        </a>
    </div>

    @if ($selections->isEmpty())
        <p>選考予定が登録されていません。</p>
    @else
        <div class="mx-auto max-w-6xl rounded-lg p-8">
            <div class="grid grid-cols-3 gap-6">
                @foreach ($selections as $selection)
                    <div class="bg-white rounded-lg shadow p-6">

                        {{-- 上段 --}}
                        <div class="flex justify-between items-start">
                            <div class="w-full">

                                {{-- 企業名・編集削除 --}}
                                <div class="flex justify-between items-start border-b mb-2">
                                    <p class="text-xl font-bold truncate">
                                        {{ $selection->company->name }}
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

                                {{-- 日程 --}}
                                <p>
                                    <strong>日程：</strong>

                                    @if ($selection->start_datetime)
                                        {{ \Carbon\Carbon::parse($selection->start_datetime)->format('Y/m/d H:i') }}
                                    @endif

                                    @if ($selection->end_datetime)
                                        ～ {{ \Carbon\Carbon::parse($selection->end_datetime)->format('Y/m/d H:i') }}
                                    @endif
                                </p>

                                {{-- URL --}}
                                @if ($selection->url)
                                    <div>
                                        <strong>URL：</strong>
                                        <a href="{{ $selection->url }}" target="_blank"
                                            class="text-blue-500 underline">
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
                                    @if ($selection->applied)
                                        <span class="text-green-600">応募済み</span>
                                    @else
                                        <span>未応募</span>
                                    @endif
                                </p>

                                <p>
                                    <strong>参加状況：</strong>
                                    @if ($selection->joined)
                                        <span class="text-green-600">参加済み</span>
                                    @else
                                        <span>未参加</span>
                                    @endif
                                </p>

                            </div>
                        </div>

                        {{-- 詳細 --}}
                        <details class="mt-4">
                            <summary class="cursor-pointer font-semibold">
                                詳細を見る
                            </summary>

                            <div class="mt-3 space-y-2">

                                <p>
                                    <strong>開催場所：</strong><br>
                                    {{ $selection->place ?: 'なし' }}
                                </p>

                                <p>
                                    <strong>最寄り駅：</strong><br>
                                    {{ $selection->station ?: 'なし' }}
                                </p>

                                <div>
                                    <strong>内容：</strong>
                                    <p>
                                        {{ $selection->content ?: 'なし' }}
                                    </p>
                                </div>

                                <p>
                                    <strong>交通費支給：</strong>
                                    @if ($selection->carfare)
                                        あり
                                    @else
                                        なし
                                    @endif
                                </p>

                                <p>
                                    <strong>自費交通費：</strong><br>
                                    {{ $selection->carfare_price ?? 'なし' }}
                                </p>

                                <div>
                                    <strong>参加後メモ：</strong>
                                    <p>
                                        {{ $selection->joined_memo ?: 'なし' }}
                                    </p>
                                </div>

                            </div>
                        </details>

                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
