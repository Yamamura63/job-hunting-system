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
<div class="grid grid-cols-3 gap-6">

@foreach($selfPrs as $selfPr)

<div class="relative bg-white rounded-lg shadow p-6">
    <button
        type="button"
        onclick="copyPr(@js($selfPr->body))"
        class="absolute top-3 right-3 cursor-pointer"
    >
        <svg 
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 16h8M8 12h8m-6-8h6a2 2 0 012 2v12a2 2 0 01-2 2H8a2 2 0 01-2-2V6a2 2 0 012-2h2"
            />
        </svg>
    </button>


    <p class="text-xl font-bold border-b inline-block mb-3">
        {{ $selfPr->title }}
    </p>

    <p>
        {{ Str::limit($selfPr->body, 100) }}
    </p>

</div>

@endforeach

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
</script>
@endsection