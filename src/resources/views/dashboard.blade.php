@extends('layouts.app')

@section('title', 'マイページ')

@section('content')

    <div class="mx-auto rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 items-start">
            <div class="bg-white rounded-xl m-2 p-5">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="text-5xl">
                        <title xmlns="">company</title>
                        <path fill="currentColor"
                            d="M18 15h-2v2h2m0-6h-2v2h2m2 6h-8v-2h2v-2h-2v-2h2v-2h-2V9h8M10 7H8V5h2m0 6H8V9h2m0 6H8v-2h2m0 6H8v-2h2M6 7H4V5h2m0 6H4V9h2m0 6H4v-2h2m0 6H4v-2h2m6-10V3H2v18h20V7z" />
                    </svg>
                    <a href="{{ route('company') }}" class="text-2xl ml-2 hover:underline" title="一覧を見る">気になる企業</a>
                </div>
                <p class="text-3xl font-bold text-right">{{ $companyCount }}社</p>
            </div>

            <div class="bg-white rounded-xl m-2 p-5">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 2048 2048"
                        class="text-5xl">
                        <title xmlns="">company-directory</title>
                        <path fill="currentColor"
                            d="M1920 0v2048H256v-254H128v-128h128v-257H128v-128h128V769H128V641h128V385H128V257h128V0zm-128 128H384v1792h1408zm-128 384h-640V384h640zm0 256h-640V640h640zm-960 892q-39 0-73-14t-60-40t-40-60t-15-74q0-39 14-73t40-59t60-41t74-15q39 0 73 15t59 40t41 60t15 73q0 39-15 73t-40 60t-60 40t-73 15m0-256q-29 0-48 19t-20 49q0 29 19 48t49 20q29 0 48-19t20-49q0-29-19-48t-49-20m0-640q-39 0-73-14t-60-40t-40-60t-15-74q0-39 14-73t40-59t60-41t74-15q39 0 73 15t59 40t41 60t15 73q0 39-15 73t-40 60t-60 40t-73 15m0-256q-29 0-48 19t-20 49q0 29 19 48t49 20q29 0 48-19t20-49q0-29-19-48t-49-20m960 900h-640v-128h640zm0 256h-640v-128h640z" />
                    </svg>
                    <a href="{{ route('internship') }}" class="text-2xl ml-2 hover:underline" title="一覧を見る">インターンシップ</a>
                </div>
                <p class="text-3xl font-bold text-right">{{ $internshipCount }}件</p>
            </div>

            <div class="bg-white rounded-xl m-2 p-5">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48"
                        class="text-5xl">
                        <title xmlns="">full-selection</title>
                        <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                            <path d="M34 5H8a3 3 0 0 0-3 3v26a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3Z" />
                            <path stroke-linecap="round"
                                d="M44 13.002V42a2 2 0 0 1-2 2H13.003M13 20.486l6 5.525l10-10.292" />
                        </g>
                    </svg>
                    <a href="{{ route('selection', ['status' => 'noFinish']) }}" class="text-2xl ml-2 hover:underline" title="一覧を見る"">選考中</a>
                </div>
                <p class="text-3xl font-bold text-right">{{ $selectionCount }}件</p>
            </div>
        </div>
    </div>
    <div class="m-6 p-6 bg-white rounded-xl">
        <div class="flex items-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="text-5xl">
                <title xmlns="">star-fall-outline</title>
                <g fill="none">
                    <path fill="currentColor" fill-rule="evenodd"
                        d="m15.014 3.185l.278.352c.14.177.219.276.283.345l.06.058l.072.014c.089.013.21.021.43.035l.438.027c.682.043 1.28.08 1.735.18c.482.104 1.006.32 1.284.88c.275.552.141 1.102-.054 1.556c-.186.434-.505.952-.872 1.548l-.03.049l-.204.33a6 6 0 0 0-.225.382a1 1 0 0 0-.036.084v.016q0 .018.01.08c.018.096.05.221.107.441l.1.381l.014.055c.18.69.336 1.286.39 1.758c.056.487.032 1.062-.399 1.51c-.44.458-1.017.488-1.502.43c-.461-.055-1.04-.216-1.703-.399l-.425-.118a6 6 0 0 0-.42-.108l-.066-.01l-.061.03c-.08.044-.18.111-.365.234l-.367.245c-.572.381-1.072.715-1.493.912c-.442.206-1 .358-1.562.06c-.358-.19-.568-.485-.699-.8c-2.273.959-4.13 2.606-4.773 4.5a.75.75 0 0 1-1.451-.123c-.94-5.884.816-9.433 3.34-11.367c.175-.396.507-.66.836-.854c.401-.236.957-.458 1.593-.712l.054-.022l.353-.141a6 6 0 0 0 .398-.167l.064-.037l.039-.073c.04-.086.083-.205.161-.417l.135-.367l.02-.054c.244-.662.455-1.236.68-1.65c.231-.426.586-.89 1.212-.99c.625-.1 1.108.23 1.46.562c.343.323.723.803 1.16 1.355M7.16 8.46c-1.423 1.371-2.52 3.59-2.402 7.108c1.168-1.468 2.874-2.616 4.699-3.332q-.029-.373-.053-.795l-.028-.45a7 7 0 0 0-.036-.451a1 1 0 0 0-.02-.096l-.008-.01l-.052-.058a6 6 0 0 0-.333-.293l-.34-.286c-.535-.452-1-.845-1.312-1.199a3 3 0 0 1-.115-.138m3.873 4.38a.75.75 0 0 0-.053-.408c-.03-.296-.054-.667-.083-1.14l-.024-.393l-.005-.084c-.02-.344-.042-.71-.205-1.039c-.165-.33-.444-.566-.705-.785l-.063-.053l-.296-.25c-.591-.5-.968-.821-1.199-1.082a1 1 0 0 1-.175-.25l.002-.003a.9.9 0 0 1 .218-.161c.29-.171.737-.352 1.443-.634l.353-.141l.077-.03c.308-.122.65-.258.909-.527c.255-.265.382-.613.498-.932l.03-.08l.134-.367c.27-.732.444-1.2.61-1.505a1.2 1.2 0 0 1 .134-.208c.037.022.099.067.192.155c.253.238.564.628 1.048 1.24l.243.306l.052.067c.21.266.44.558.764.73c.33.175.698.197 1.029.216l.082.005l.38.024c.759.047 1.239.08 1.568.15a.9.9 0 0 1 .257.086l.002.001v.012a1 1 0 0 1-.088.28c-.138.321-.396.744-.802 1.404l-.203.33l-.044.07c-.179.29-.371.6-.424.966c-.053.363.04.717.129 1.051l.021.082l.1.38c.198.761.325 1.251.365 1.604c.019.161.013.247.006.289a1 1 0 0 1-.24-.008c-.333-.04-.8-.167-1.536-.371l-.368-.102l-.08-.023c-.32-.09-.677-.19-1.045-.131s-.676.266-.95.45l-.07.047l-.318.212c-.636.424-1.04.691-1.344.833a1 1 0 0 1-.224.083a1 1 0 0 1-.085-.276zm.064.368l.013.001zm.05.019l.008.007q0 .002-.008-.007m6.153-.978l.004-.01zm.033-.037q.011-.007.013-.005zM12.67 2.735l-.01.006zm-.07.015q-.01 0-.01-.003z"
                        clip-rule="evenodd" />
                    <path stroke="currentColor" stroke-linejoin="round"
                        d="M10.28 16s.634 1.39 1.414 1.87c.78.477 2.306.41 2.306.41s-1.39.633-1.87 1.413c-.478.78-.41 2.307-.41 2.307s-.634-1.39-1.414-1.87C9.527 19.654 8 19.72 8 19.72s1.39-.633 1.87-1.413c.478-.78.41-2.307.41-2.307Zm8.2-1s-.422.927-.942 1.246S16 16.52 16 16.52s.927.422 1.246.942S17.52 19 17.52 19s.422-.927.942-1.246S20 17.48 20 17.48s-.927-.422-1.246-.942S18.48 15 18.48 15Z" />
                </g>
            </svg>
            <h2 class="text-5xl font-semibold">直近の予定</h2>
        </div>
        @forelse ($upcomingEvents as $event)
            <div class="border-b">
                <p>
                    {{ \Carbon\Carbon::parse($event['datetime'])->format('n/j H:i') }}
                </p>

                <p>
                    {{ $event['company'] }}
                </p>

                <p>
                    {{ $event['name'] }}
                </p>

                <p>
                    {{ $event['place'] ?: '登録なし' }}
                </p>
            </div>

        @empty

            <p>直近の予定はありません。</p>
        @endforelse
    </div>
@endsection
