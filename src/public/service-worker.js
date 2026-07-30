const CACHE_NAME = 'job-hunting-system-v3';

const STATIC_ASSETS = [
    '/login',
    '/manifest.json',
    '/logo.png',
    '/favicon3.ico',
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(async cache => {
            for (const url of STATIC_ASSETS) {
                try {
                    await cache.add(url);
                } catch (error) {
                    console.error('Cache failed:', url, error);
                }
            }
        })
    );

    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(name => name !== CACHE_NAME)
                    .map(name => caches.delete(name))
            );
        })
    );

    self.clients.claim();
});

self.addEventListener('fetch', event => {
    const request = event.request;

    // GET以外はService Workerで処理しない
    if (request.method !== 'GET') {
        return;
    }

    // chrome-extensionなど外部スキームは無視
    if (!request.url.startsWith(self.location.origin)) {
        return;
    }

    event.respondWith(
        caches.match(request).then(cachedResponse => {
            if (cachedResponse) {
                return cachedResponse;
            }

            return fetch(request)
                .then(response => {

                    // 正常なレスポンスだけキャッシュ
                    if (
                        response &&
                        response.status === 200 &&
                        response.type === 'basic'
                    ) {
                        const responseClone = response.clone();

                        caches.open(CACHE_NAME).then(cache => {
                            cache.put(request, responseClone)
                                .catch(error => {
                                    console.error(
                                        'Cache put failed:',
                                        request.url,
                                        error
                                    );
                                });
                        });
                    }

                    return response;
                })
                .catch(() => {
                    // オフライン時のフォールバック
                    return caches.match('/login');
                });
        })
    );
});
