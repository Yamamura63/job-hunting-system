<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            アカウント情報
        </h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('ユーザ名')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('メールアドレス')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-end">
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('保存') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400">{{ __('保存しました。') }}</p>
                @endif
            </div>

            <div class="m-2 ml-5">
                <button type="button" onclick="openPasswordModal()" class="hover:text-sky-600 hover:underline">
                    パスワードを変更➡
                </button>
            </div>
        </div>
    </form>

    <!-- パスワード変更モーダル -->
    <div id="passwordModal"
        class="{{ $errors->updatePassword->any() ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="relative w-full max-w-xl mx-4 bg-white rounded-xl shadow-lg p-6">

            <button type="button" onclick="closePasswordModal()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl">
                ×
            </button>

            @include('profile.partials.update-password-form')

        </div>
    </div>


</section>

<script>
    function openPasswordModal() {
        document.getElementById('passwordModal').classList.remove('hidden');
    }

    function closePasswordModal() {
        document.getElementById('passwordModal').classList.add('hidden');
    }

    // モーダルの外側をクリックしたら閉じる
    document.getElementById('passwordModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closePasswordModal();
        }
    });
</script>
