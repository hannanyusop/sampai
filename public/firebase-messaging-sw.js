// Firebase config is injected via query string during registration
// Parse config from URL search params
const params = new URL(location.href).searchParams;

importScripts('https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: params.get('apiKey'),
    projectId: params.get('projectId'),
    messagingSenderId: params.get('messagingSenderId'),
    appId: params.get('appId'),
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    const title = payload.notification?.title || 'NUJ Express';
    const link = payload.data?.link || '/';
    const options = {
        body: payload.notification?.body || '',
        icon: '/images/logo.png',
        badge: '/images/favicon.png',
        data: { link: link },
    };

    self.registration.showNotification(title, options);
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    const link = event.notification.data?.link || '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then((windowClients) => {
            // Focus existing window if one is open
            for (const client of windowClients) {
                if (client.url === link && 'focus' in client) {
                    return client.focus();
                }
            }
            // Otherwise open a new window
            if (clients.openWindow) {
                return clients.openWindow(link);
            }
        })
    );
});
