const CACHE_NAME = 'nuj-express-v2';
const STATIC_ASSETS = [
    '/',
    '/assets/css/dashlite.css',
    '/assets/css/theme.css',
    '/assets/js/bundle.js',
    '/assets/js/scripts.js',
    '/images/favicon.png',
    '/images/logo.png'
];

// Install - cache static assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(STATIC_ASSETS))
            .then(() => self.skipWaiting())
    );
});

// Activate - clean old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys.filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))
            )
        ).then(() => self.clients.claim())
    );
});

// Push notifications
self.addEventListener('push', event => {
    let data = {};
    try {
        data = event.data?.json() || {};
    } catch (e) {
        data = {};
    }

    const title = data.notification?.title || 'NUJ Express';
    const options = {
        body: data.notification?.body || '',
        icon: '/images/logo.png',
        badge: '/images/favicon.png',
        data: data.data || {},
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

// Handle notification click
self.addEventListener('notificationclick', event => {
    event.notification.close();
    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(clientList => {
            if (clientList.length > 0) {
                return clientList[0].focus();
            }
            return clients.openWindow('/');
        })
    );
});

// Fetch - network first for HTML/API, cache first for static assets
self.addEventListener('fetch', event => {
    const { request } = event;

    // Skip non-GET requests
    if (request.method !== 'GET') return;

    // Skip cross-origin requests
    if (!request.url.startsWith(self.location.origin)) return;

    // Network-first for HTML pages and API calls
    if (request.headers.get('accept')?.includes('text/html') ||
        request.url.includes('/api/')) {
        event.respondWith(
            fetch(request)
                .then(response => {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
                    return response;
                })
                .catch(() => caches.match(request))
        );
        return;
    }

    // Cache-first for static assets
    event.respondWith(
        caches.match(request)
            .then(cached => cached || fetch(request).then(response => {
                const clone = response.clone();
                caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
                return response;
            }))
    );
});
