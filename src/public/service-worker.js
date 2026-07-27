const CACHE_NAME = 'job-hunting-system-v3';

const urlsToCache = [
    '/login',
    '/manifest.json',
    '/logo.png',
    '/favicon3.ico',
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );

    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => cacheName !== CACHE_NAME)
                    .map(cacheName => caches.delete(cacheName))
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', event => {
    // GET以外は処理しない
    if (event.request.method !== 'GET') {
        return;
    }

    // 自分のサイト以外は処理しない
    if (!event.request.url.startsWith(self.location.origin)) {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then(response => {

                // 正常なレスポンスだけキャッシュする
                if (response && response.ok) {
                    const responseClone = response.clone();

                    caches.open(CACHE_NAME)
                        .then(cache => {
                            cache.put(event.request, responseClone);
                        })
                        .catch(error => {
                            console.error('Cache error:', error);
                        });
                }

                return response;
            })
            .catch(() => {
                // オフラインの場合はキャッシュを使用
                return caches.match(event.request);
            })
    );
});
