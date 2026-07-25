@extends('layouts.app')

@section('title', 'マイページ')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="flex justify-between items-center mb-5 gap-2 shrink-0">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">自己PR</h2>
                        <a href="{{ route('self-prs.index') }}" class="ml-3 hover:text-sky-600 hover:underline">
                            一覧➡
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 items-start">
                    @foreach ($recentSelfPrs as $selfPr)
                        <div class="p-3 border rounded-md">
                            <h3 class="font-bold">{{ $selfPr->title }}</h3>
                            <p>{{ Str::limit($selfPr->body, 100) }}</p>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

@endsection
