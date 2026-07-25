@extends('layouts.app')

@section('title', '自己PR一覧')

@section('content')
<div class="flex justify-between items-center mt-5 mb-5 ml-6 mr-9 gap-2 shrink-0">
    <h1 class="text-3xl font-bold">自己PR一覧</h1>

    <a href="{{ route('selfPr.create') }}"
        class="px-4 py-2 bg-blue-500 text-white rounded">
        ＋ 自己PRを追加
    </a>
</div>

@if($selfPrs->isEmpty())
<p>自己PRが登録されていません。</p>
@else

<div class="mx-auto max-w-6xl rounded-lg p-8 flex justify-center">

    <div class="grid grid-cols-3 gap-6">

        @foreach($selfPrs as $selfPr)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start">
                <p class="text-xl font-bold border-b inline-block mb-3 w-64 truncate" title="{{ $selfPr->title }}">
                    {{ $selfPr->title }}
                </p>

                <div class="flex items-center gap-2 shrink-0 ml-3">
                    <button type="button" onclick="copyPr(@js($selfPr->body))"
                        class="cursor-pointer hover:text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M7 9.667A2.667 2.667 0 0 1 9.667 7h8.666A2.667 2.667 0 0 1 21 9.667v8.666A2.667 2.667 0 0 1 18.333 21H9.667A2.667 2.667 0 0 1 7 18.333z" />
                                <path d="M4.012 16.737A2 2 0 0 1 3 15V5c0-1.1.9-2 2-2h10c.75 0 1.158.385 1.5 1" />
                            </g>
                        </svg>
                    </button>

                    <a href="{{ route('selfPr.edit', $selfPr->id) }}" class="cursor-pointer hover:text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 21h8M15 5l4 4m2.174-2.188a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                        </svg>
                    </a>
                    <form action="{{ route('selfPr.destroy', $selfPr) }}" method="POST"
                        onsubmit="return confirm('この自己PRを削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cursor-pointer hover:text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zm-6.287 10.713Q11 16.425 11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17t.713-.288m4 0Q15 16.426 15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17t.713-.288M7 6v13z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <p id="body-{{ $selfPr->id }}" class="line-clamp-3">
                {{ $selfPr->body }}
            </p>
            <button id="button-{{ $selfPr->id }}" type="button" onclick="toggleBody({{ $selfPr->id }}, this)"
                class="hidden text-blue-500">
                もっと見る</button>
        </div>

        @endforeach

    </div>
</div>
@endif

<script>
    function copyPr(text) {
        navigator.clipboard.writeText(text)
            .then(() => {
                alert('コピーしました');
            })
            .catch(() => {
                alert('コピーに失敗しました');
            });
    }

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