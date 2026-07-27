const CACHE_NAME = 'job-hunting-system-v3';

const urlsToCache = [
    '/login',
    '/logo.png',
    '/favicon3.ico',
    '/manifest.json',

    // ViteでビルドされたCSS・JS
    '/build/assets/app-Blws9673.css',
    '/build/assets/app-D5YadmQX.js',
];

self.addEventListener('install', event => {
    self.skipWaiting();

    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return Promise.all(
                urlsToCache.map(url => {
                    return cache.add(url).catch(error => {
                        console.error('Cache failed:', url, error);
                    });
                })
            );
        })
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => cacheName !== CACHE_NAME)
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );

    self.clients.claim();
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response;
                }

                return fetch(event.request);
            })
            .catch(() => {
                if (event.request.mode === 'navigate') {
                    return caches.match('/login');
                }
            })
    );
});
