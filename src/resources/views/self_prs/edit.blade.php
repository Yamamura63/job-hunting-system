@extends('layouts.app')

@section('title', '自己PR - 編集')

@section('content')

    <h1 class="text-4xl p-3">自己PR編集</h1>
    <div class="p-8">
        <div class="mx-auto max-w-6xl rounded-lg bg-white p-8 shadow flex justify-center">
            <form id="self-pr-form" class="w-full max-w-2xl">
                <label class="text-lg font-bold">タイトル名</label><br>
                <input type="text" id="title" required class="w-full m-2 border border-gray-500 rounded"><br>

                <div class="flex justify-between items-baseline">
                    <label class="text-lg font-bold">本文</label>
                    <div class="flex items-center mt-3">
                        <p>文字数：<span id="count">0</span> /</p>
                        <select id="target_length" class="border-b border-gray-500">
                            <option value="200">200文字</option>
                            <option value="300">300文字</option>
                            <option value="400">400文字</option>
                            <option value="500">500文字</option>
                            <option value="600">600文字</option>
                            <option value="700">700文字</option>
                            <option value="800">800文字</option>
                        </select>
                    </div>
                </div>

                <p id="error" class="text-red-500"></p>
                <textarea id="body" rows="6" required class="resize-none overflow-y-auto m-2 border rounded w-full"></textarea>
                <br>
                <button type="submit"
                    class="cursor-pointer text-lg text-white bg-blue-400 rounded pt-2 pb-2 pl-4 pr-4">✐更新</button>
            </form>
        </div>
    </div>

    <a href="{{ route('selfPr') }}" class="border-b">
        ✕ 保存せずに終了
    </a>

    <script type="module">
        const pathParts = window.location.pathname.split('/').filter(Boolean);
        const id = pathParts[pathParts.length - 2];
        const form = document.getElementById('self-pr-form');
        const title = document.getElementById('title');
        const body = document.getElementById('body');
        const count = document.getElementById('count');
        const target = document.getElementById('target_length');
        const error = document.getElementById('error');

        async function loadSelfPr() {
            try {
                const selfPr = await window.indexedDBService.getData('self_prs', id);

                if (!selfPr) {
                    alert('自己PRが見つかりません');
                    window.location.href = "{{ route('selfPr') }}";
                    return;
                }

                title.value = selfPr.title || '';
                body.value = selfPr.body || '';
                target.value = selfPr.target_length || 200;
                checkLength();
            } catch (error) {
                console.error('自己PRの読み込みに失敗しました', error);
                alert('自己PRの読み込みに失敗しました');
            }
        }

        function checkLength() {
            const length = body.value.length;
            count.textContent = length;

            if (length > target.value) {
                error.textContent = `目標文字数を${length - target.value}文字超えています`;
            } else {
                error.textContent = '';
            }
        }

        body.addEventListener('input', checkLength);
        target.addEventListener('change', checkLength);

        form.addEventListener('submit', async event => {
            event.preventDefault();

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            try {
                await window.indexedDBService.updateData('self_prs', id, {
                    title: title.value,
                    body: body.value,
                    target_length: Number(target.value)
                });

                window.location.href = "{{ route('selfPr') }}";
            } catch (error) {
                console.error('自己PRの更新に失敗しました', error);
                alert('自己PRの更新に失敗しました');
            }
        });

        loadSelfPr();
    </script>

@endsection
