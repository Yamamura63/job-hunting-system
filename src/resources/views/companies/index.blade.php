@extends('layouts.app')

@section('title', '企業一覧')

@section('content')
    <div class="flex justify-between items-center mt-5 mb-5 ml-6 mr-9 gap-2 shrink-0">
        <h1 class="text-3xl font-bold">企業一覧</h1>

        <div class="flex items-center gap-4">

            {{-- 検索 --}}
            <form action="{{ route('company') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="企業名を検索"
                    class="border rounded px-3 py-1">
                {{-- 並べ替え条件を維持 --}}
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <button type="submit" class="px-3 py-1 bg-gray-500 text-white rounded">
                    検索
                </button>
            </form>

            {{-- 並べ替え --}}
            <form action="{{ route('company') }}" method="GET" class="flex items-center gap-2">
                {{-- 検索条件を維持 --}}
                <input type="hidden" name="search" value="{{ request('search') }}">
                <label for="sort">並べ替え：</label>
                <select name="sort" id="sort" class="border rounded px-2 py-1" onchange="this.form.submit()">
                    <option value="">登録が新しい順</option>
                    <option value="high" @selected(request('sort') === 'high')>志望度が高い順</option>
                    <option value="low" @selected(request('sort') === 'low')>志望度が低い順</option>
                </select>
            </form>

            <a href="{{ route('company.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
                ＋ 企業を追加
            </a>
        </div>
    </div>

    @if ($companies->isEmpty())
        <p>企業が登録されていません。</p>
    @else
        <div class="mx-auto max-w-6xl rounded-lg p-8 flex justify-center">
            <div class="grid grid-cols-3 gap-6">
                @foreach ($companies as $company)
                    <div class="bg-white rounded-lg shadow p-6">
                        {{-- 上段 --}}
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex justify-between items-start border-b mb-2">
                                    <p class="text-xl font-bold inline-block w-50 truncate">
                                        {{ $company->name }}
                                    </p>
                                    {{-- 編集・削除 --}}
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('company.edit', $company->id) }}"
                                            class="cursor-pointer hover:text-emerald-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 21h8M15 5l4 4m2.174-2.188a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('company.destroy', $company) }}" method="POST"
                                            onsubmit="return confirm('この企業を削除しますか？')">
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
                                <p><strong>志望度：</strong>
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= $company->level ? '★' : '☆' }}
                                    @endfor
                                </p>
                                <p><strong>給与：</strong> {{ $company->salary }} 万円</p>
                                <p><strong>勤務時間：</strong>
                                    {{ \Carbon\Carbon::parse($company->start_time)->format('H:i') }}
                                    ～
                                    {{ \Carbon\Carbon::parse($company->end_time)->format('H:i') }}
                                </p>
                                <p><strong>SES度：</strong>{{ $company->ses_level }}</p>
                                @forelse ($company->urls as $url)
                                    <div>
                                        <strong>URL：</strong>
                                        <a href="{{ $url->url }}" target="_blank" class="text-blue-500 underline">
                                            {{ $url->memo }}
                                        </a>
                                    </div>
                                @empty
                                    <div>
                                        <strong>URL：</strong>
                                        <span>登録なし</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- アコーディオン --}}
                        <details class="mt-4">
                            <summary class="cursor-pointer font-semibold">
                                詳細を見る
                            </summary>

                            <div class="mt-3 space-y-2">

                                <p><strong>所在地：</strong><br>
                                    {{ $company->address }}</p>

                                <p><strong>業種：</strong><br>
                                    {{ $company->industry }}</p>

                                <p>
                                    <strong>給与内訳：</strong><br>
                                    基本給 {{ $company->basic_salary }} 万円 /
                                    その他 {{ $company->other_salary }} 万円
                                </p>

                                <p><strong>休憩時間：</strong><br>
                                    {{ $company->break_time }} 時間</p>

                                <p>
                                    <strong>研修期間：</strong><br>
                                    {{ intdiv($company->training_period, 12) }}年
                                    {{ $company->training_period % 12 }}か月
                                </p>

                                <div>
                                    <strong>福利厚生メモ</strong>
                                    <p>
                                        {{ $company->benefits_memo ?: 'なし' }}
                                    </p>
                                </div>

                                <div>
                                    <strong>メモ</strong>
                                    <p>
                                        {{ $company->free_memo ?: 'なし' }}
                                    </p>
                                </div>

                            </div>
                        </details>

                    </div>
                @endforeach

            </div>
        </div>
    @endif

    <script>
        document.querySelectorAll('[id^="body-"]').forEach(body => {
            if (body.scrollHeight > body.clientHeight) {
                const id = body.id.split('-')[1];
                document.getElementById(`button-${id}`).classList.remove('hidden');
            }
        });

        function toggleBody(id, button) {
            const body = document.getElementById(`body-${id}`);

            body.classList.toggle('line-clamp-3');

            button.textContent =
                body.classList.contains('line-clamp-3') ?
                'もっと見る' :
                '閉じる';
        }
    </script>
@endsection
