@extends('layouts.app')

@section('title', '企業一覧')

@section('content')

    {{-- Laravelから初期データをJavaScriptへ渡す --}}
    <script>
        const initialCompanies = @json($companies);
    </script>

    {{-- ページタイトル・追加ボタン --}}
    <div class="sticky top-0 z-10 bg-gray-100 px-6 pt-5 pb-3">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">企業一覧</h1>

            <a href="{{ route('company.create') }}" class="shrink-0 px-4 py-2 bg-blue-500 text-white rounded">
                ＋ 企業を追加
            </a>
        </div>

        {{-- 検索・並べ替え --}}
        <div class="mt-4 flex flex-wrap items-center gap-4">

            {{-- 検索 --}}
            <div class="flex items-center gap-2">
                <input
                    type="search"
                    id="search"
                    placeholder="企業名を検索"
                    class="border rounded px-3 py-1">

                <button
                    type="button"
                    id="search-button"
                    class="px-3 py-1 bg-gray-500 text-white rounded">
                    検索
                </button>
            </div>

            {{-- 並べ替え --}}
            <div class="flex items-center gap-2">
                <label for="sort">並べ替え：</label>

                <select
                    id="sort"
                    class="border rounded pr-7 px-2 py-1">
                    <option value="">登録が新しい順</option>
                    <option value="high">志望度が高い順</option>
                    <option value="low">志望度が低い順</option>
                </select>
            </div>

        </div>
    </div>


    {{-- 企業一覧 --}}
    <div id="company-list">

        {{-- JavaScriptでIndexedDBから企業を読み込んで表示 --}}
        <p id="loading-message" class="px-6 mt-5">
            企業情報を読み込んでいます...
        </p>

    </div>


    {{-- 企業カードのテンプレート --}}
    <template id="company-card-template">

        <div class="bg-white rounded-lg shadow p-6">

            {{-- 上段 --}}
            <div class="flex justify-between items-start">

                <div class="w-full">

                    {{-- 企業名・編集・削除 --}}
                    <div class="flex justify-between items-start border-b mb-2 w-full">

                        <p class="company-name text-xl font-bold inline-block min-w-0 truncate">
                        </p>

                        <div class="flex items-center gap-2 shrink-0 ml-2">

                            {{-- 編集 --}}
                            <a
                                href="#"
                                class="edit-link cursor-pointer hover:text-emerald-500">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24">

                                    <path
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 21h8M15 5l4 4m2.174-2.188a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />

                                </svg>

                            </a>


                            {{-- 削除 --}}
                            <button
                                type="button"
                                class="delete-button cursor-pointer hover:text-red-500">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24">

                                    <path
                                        fill="currentColor"
                                        d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zm-6.287 10.713Q11 16.425 11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17t.713-.288m4 0Q15 16.426 15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17t.713-.288M7 6v13z" />

                                </svg>

                            </button>

                        </div>

                    </div>


                    {{-- 基本情報 --}}

                    <p>
                        <strong>志望度：</strong>
                        <span class="company-level"></span>
                    </p>

                    <p>
                        <strong>給与：</strong>
                        <span class="company-salary"></span> 万円
                    </p>

                    <p>
                        <strong>勤務時間：</strong>
                        <span class="company-working-time"></span>
                    </p>

                    <p>
                        <strong>SES度：</strong>
                        <span class="company-ses-level"></span>
                    </p>


                    {{-- URL --}}
                    <div class="company-urls">
                    </div>

                </div>

            </div>


            {{-- アコーディオン --}}
            <details class="mt-4 group">

                <summary class="cursor-pointer font-semibold list-none">

                    <span
                        class="group-open:hidden cursor-pointer font-semibold text-blue-500 hover:text-blue-800 hover:underline">
                        ▼ 詳細を見る
                    </span>

                </summary>


                <div class="mt-3 space-y-2">

                    {{-- 所在地 --}}
                    <p>
                        <strong>所在地：</strong><br>
                        <span class="company-address"></span>
                    </p>


                    {{-- 業種 --}}
                    <p>
                        <strong>業種：</strong><br>
                        <span class="company-industry"></span>
                    </p>


                    {{-- 給与内訳 --}}
                    <p>
                        <strong>給与内訳：</strong><br>
                        基本給 <span class="company-basic-salary"></span> 万円 /
                        その他 <span class="company-other-salary"></span> 万円
                    </p>


                    {{-- 休憩時間 --}}
                    <p>
                        <strong>休憩時間：</strong><br>
                        <span class="company-break-time"></span> 時間
                    </p>


                    {{-- 研修期間 --}}
                    <p>
                        <strong>研修期間：</strong><br>
                        <span class="company-training-period"></span>
                    </p>


                    {{-- 福利厚生メモ --}}
                    <div>
                        <strong>福利厚生メモ</strong>

                        <p class="company-benefits-memo">
                        </p>
                    </div>


                    {{-- メモ --}}
                    <div>
                        <strong>メモ</strong>

                        <p class="company-free-memo">
                        </p>
                    </div>


                    {{-- 閉じる --}}
                    <button
                        type="button"
                        class="mt-4 cursor-pointer font-semibold text-blue-500 hover:text-blue-800 hover:underline close-details">
                        ▲ 閉じる
                    </button>

                </div>

            </details>

        </div>

    </template>


    {{-- IndexedDB用JavaScript --}}
    @vite('resources/js/companies-index.js')

@endsection
