@extends('layouts.app')

@section('title', '自己PR一覧')

@section('content')
    <h1>自己PR一覧</h1>

    @if($selfPrs->isEmpty())
    <p>自己PRが登録されていません。</p>
    @else
        @foreach($selfPrs as $selfPr)
        <p>{{ $selfPr->title }}</p>
        @endforeach
    @endif
@endsection