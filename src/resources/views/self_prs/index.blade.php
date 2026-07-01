@extends('layouts.app')

@section('title', '自己PR一覧')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">自己PR一覧</h1>

    <a href="{{ route('selfPr.create') }}"
        class="px-4 py-2 bg-blue-500 text-white rounded">
        ＋追加
    </a>
</div>

@if($selfPrs->isEmpty())
<p>自己PRが登録されていません。</p>
@else

<div class="mx-auto max-w-6xl rounded-lg p-8 flex justify-center">

    <div class="grid grid-cols-3 gap-6">

        @foreach($selfPrs as $selfPr)

        <div class="relative bg-white rounded-lg shadow p-6">
            <button
                type="button"
                onclick="copyPr(@js($selfPr->body))"
                class="absolute top-3 right-3 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <title xmlns="">copy</title>
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M7 9.667A2.667 2.667 0 0 1 9.667 7h8.666A2.667 2.667 0 0 1 21 9.667v8.666A2.667 2.667 0 0 1 18.333 21H9.667A2.667 2.667 0 0 1 7 18.333z" />
                        <path d="M4.012 16.737A2 2 0 0 1 3 15V5c0-1.1.9-2 2-2h10c.75 0 1.158.385 1.5 1" />
                    </g>
                </svg>
            </button>


            <p class="text-xl font-bold border-b inline-block mb-3 w-64 truncate" title="" {{ $selfPr->title }}>
                {{ $selfPr->title }}
            </p>

            <p id="body-{{ $selfPr->id }}" class="line-clamp-3">
                {{ $selfPr->body }}
            </p>
            <button id="button-{{ $selfPr->id }}" type="button" onclick="toggleBody({{ $selfPr->id }}, this)"
                class="hidden text-blue-500">
                もっと見る</button>

            <div class="flex">
                <a href="{{ route('selfPr.edit', $selfPr->id) }}" class="m-1 p-1 text-white bg-blue-400 border rounded">
                    編集
                </a>
                <a href="{{ route('selfPr.destroy', $selfPr->id) }}" class="m-1 p-1 text-white bg-red-400 border rounded">
                    編集
                </a>
            </div>

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