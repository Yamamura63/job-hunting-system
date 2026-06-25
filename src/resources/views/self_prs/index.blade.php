@extends('layouts.app')

@section('title', '自己PR一覧')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">自己PR一覧</h1>

    <a href="{{ route('selfPr.create') }}"
       class="px-4 py-2 bg-blue-500 text-white rounded">
        ＋追加
    </a>
</div>

@if($selfPrs->isEmpty())
<p>自己PRが登録されていません。</p>
@else
@foreach($selfPrs as $selfPr)
    <p>{{ $selfPr->title }}</p>
    <p>{{ $selfPr->body }}</p>
@endforeach
@endif
@endsection