<x-guest-layout welcome="また会いましたね。">
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('パスワードの再設定を行います。メールアドレスを入力してください。') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('メールアドレス')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end">
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="underline mt-6 p-3 text-sm text-gray-600 hover:text-sky-500">
                    思い出しましたか？
                </a>
            @endif

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('リセット用リンクを表示') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
