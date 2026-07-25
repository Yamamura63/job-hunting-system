<x-guest-layout welcome="登録しましょう。">
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        登録されているメールアドレスを確認しました。
    </div>

    <div class="mt-4">
        <a href="{{ route('password.reset', [
            'token' => $token,
            'email' => $email,
        ]) }}"
            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md">
            パスワード再設定画面へ
        </a>
    </div>
</x-guest-layout>
