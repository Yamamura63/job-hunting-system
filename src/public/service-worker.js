const CACHE_NAME = 'job-hunting-system-v1';

const urlsToCache = [
    '/login',
    '/logo.png',
    '/favicon3.ico',
    '/manifest.json',
];

self.addEventListener('install', event => {
    self.skipWaiting();

    event.waitUntil(
        caches.open(CACHE_NAME).then(async cache => {
            // 基本ファイルをキャッシュ
            await Promise.all(
                urlsToCache.map(url =>
                    cache.add(url).catch(error => {
                        console.error('Cache failed:', url, error);
                    })
                )
            );

            // Viteのmanifest.jsonからCSS・JSを取得
            try {
                const response = await fetch('/build/manifest.json');
                const manifest = await response.json();

                const assets = [];

                Object.values(manifest).forEach(entry => {
                    if (entry.file) {
                        assets.push('/build/' + entry.file);
                    }

                    if (entry.css) {
                        entry.css.forEach(cssFile => {
                            assets.push('/build/' + cssFile);
                        });
                    }

                    if (entry.assets) {
                        entry.assets.forEach(assetFile => {
                            assets.push('/build/' + assetFile);
                        });
                    }
                });

                await Promise.all(
                    assets.map(url =>
                        cache.add(url).catch(error => {
                            console.error('Asset cache failed:', url, error);
                        })
                    )
                );
            } catch (error) {
                console.error('Failed to cache Vite assets:', error);
            }
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
        caches.match(event.request).then(response => {
            if (response) {
                return response;
            }

            return fetch(event.request);
        })
    );
});
