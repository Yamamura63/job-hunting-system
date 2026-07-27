@extends('layouts.app')

@section('title', '自己PR一覧')

@section('content')

    <div class="flex justify-between items-center mt-5 mb-5 ml-6 mr-9 gap-2 shrink-0">
        <h1 class="text-3xl font-bold">自己PR一覧</h1>

        <a href="{{ route('selfPr.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
            ＋ 自己PRを追加
        </a>
    </div>

    <div id="empty-message" class="hidden ml-6">
        <p>自己PRが登録されていません。</p>
    </div>

    <div id="self-pr-list" class="mx-auto max-w-6xl rounded-lg p-8 flex justify-center">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start w-full">
        </div>

    </div>

    <script type="module">
        import {
            getAllData,
            deleteData
        } from '/build/assets/app.js';

        const list = document.querySelector('#self-pr-list > div');
        const emptyMessage = document.getElementById('empty-message');

        async function loadSelfPrs() {

            try {
                const selfPrs = await window.indexedDBService.getAllData('self_prs');

                list.innerHTML = '';

                if (selfPrs.length === 0) {
                    emptyMessage.classList.remove('hidden');
                    return;
                }

                emptyMessage.classList.add('hidden');

                selfPrs.forEach(selfPr => {

                    const card = document.createElement('div');

                    card.className =
                        'bg-white rounded-lg shadow p-6';

                    card.innerHTML = `
                    <div class="flex justify-between items-start">

                        <p class="text-xl font-bold border-b inline-block mb-3 w-64 truncate"
                            title="${escapeHtml(selfPr.title)}">
                            ${escapeHtml(selfPr.title)}
                        </p>

                        <div class="flex items-center gap-2 shrink-0 ml-3">

                            <button
                                type="button"
                                class="copy-button cursor-pointer hover:text-blue-500"
                                data-body="${encodeURIComponent(selfPr.body)}">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24">

                                    <g fill="none"
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2">

                                        <path d="M7 9.667A2.667 2.667 0 0 1 9.667 7h8.666A2.667 2.667 0 0 1 21 9.667v8.666A2.667 2.667 0 0 1 18.333 21H9.667A2.667 2.667 0 0 1 7 18.333z"/>

                                        <path d="M4.012 16.737A2 2 0 0 1 3 15V5c0-1.1.9-2 2-2h10c.75 0 1.158.385 1.5 1"/>

                                    </g>
                                </svg>
                            </button>

                            <a href="/selfPr/${selfPr.id}/edit"
                                class="cursor-pointer hover:text-emerald-500">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24">

                                    <path fill="none"
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 21h8M15 5l4 4m2.174-2.188a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>

                                </svg>
                            </a>

                            <button
                                type="button"
                                class="delete-button cursor-pointer hover:text-red-500"
                                data-id="${selfPr.id}">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24">

                                    <path fill="currentColor"
                                        d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zM17 6H7v13h10z"/>

                                </svg>
                            </button>

                        </div>
                    </div>

                    <p id="body-${selfPr.id}" class="line-clamp-3">
                        ${escapeHtml(selfPr.body)}
                    </p>

                    <button
                        id="button-${selfPr.id}"
                        type="button"
                        class="hidden text-blue-500">
                        もっと見る
                    </button>
                `;

                    list.appendChild(card);

                    const body = card.querySelector(`#body-${selfPr.id}`);
                    const moreButton = card.querySelector(`#button-${selfPr.id}`);

                    setTimeout(() => {
                        if (body.scrollHeight > body.clientHeight) {
                            moreButton.classList.remove('hidden');
                        }
                    }, 0);

                    moreButton.addEventListener('click', () => {

                        body.classList.toggle('line-clamp-3');

                        moreButton.textContent =
                            body.classList.contains('line-clamp-3') ?
                            'もっと見る' :
                            '閉じる';

                    });
                });

                document.querySelectorAll('.copy-button').forEach(button => {

                    button.addEventListener('click', () => {

                        const text = decodeURIComponent(
                            button.dataset.body
                        );

                        navigator.clipboard.writeText(text)
                            .then(() => {
                                alert('コピーしました');
                            })
                            .catch(() => {
                                alert('コピーに失敗しました');
                            });

                    });

                });

                document.querySelectorAll('.delete-button').forEach(button => {

                    button.addEventListener('click', async () => {

                        if (!confirm('この自己PRを削除しますか？')) {
                            return;
                        }

                        await window.indexedDBService.deleteData(
                            'self_prs',
                            button.dataset.id
                        );

                        await loadSelfPrs();

                    });

                });

            } catch (error) {

                console.error(
                    '自己PRの読み込みに失敗しました',
                    error
                );

            }
        }

        function escapeHtml(text) {

            const div = document.createElement('div');

            div.textContent = text;

            return div.innerHTML;
        }

        loadSelfPrs();
    </script>

@endsection
