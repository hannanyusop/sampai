<!-- PWA -->
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#00c6a7">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="NUJ Express">
<link rel="apple-touch-icon" href="/images/logo.png">
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js');
        });
    }
</script>

<!-- Firebase Cloud Messaging -->
<script type="module">
    import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js';
    import { getMessaging, getToken, onMessage } from 'https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging.js';

    const firebaseConfig = {
        apiKey: "{{ config('services.fcm.api_key') }}",
        projectId: "{{ config('services.fcm.project_id') }}",
        messagingSenderId: "{{ config('services.fcm.sender_id') }}",
        appId: "{{ config('services.fcm.app_id') }}",
    };

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    async function registerFcm() {
        try {
            console.log('[FCM] Starting registration...');
            console.log('[FCM] Config:', firebaseConfig);

            const permission = await Notification.requestPermission();
            console.log('[FCM] Permission:', permission);
            if (permission !== 'granted') return;

            const swUrl = '/firebase-messaging-sw.js?apiKey=' + encodeURIComponent(firebaseConfig.apiKey)
                + '&projectId=' + encodeURIComponent(firebaseConfig.projectId)
                + '&messagingSenderId=' + encodeURIComponent(firebaseConfig.messagingSenderId)
                + '&appId=' + encodeURIComponent(firebaseConfig.appId);
            const registration = await navigator.serviceWorker.register(swUrl);
            console.log('[FCM] Service worker registered');

            const token = await getToken(messaging, {
                vapidKey: "{{ config('services.fcm.vapid_key', '') }}",
                serviceWorkerRegistration: registration,
            });
            console.log('[FCM] Token received:', token ? 'yes' : 'no');

            if (token) {
                const res = await fetch('/fcm/token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    },
                    body: JSON.stringify({ token: token }),
                });
                console.log('[FCM] Token save response:', res.status);
            }
        } catch (err) {
            console.error('FCM registration failed:', err);
        }
    }

    onMessage(messaging, (payload) => {
        if (payload.notification) {
            new Notification(payload.notification.title, {
                body: payload.notification.body,
                icon: '/images/logo.png',
            });
        }
    });

    // Expose globally so a button can trigger it
    window.registerFcm = registerFcm;

    @if(auth()->check())
    // Auto-register only if permission was already granted (works on all platforms)
    if (Notification.permission === 'granted') {
        registerFcm();
    }
    @endif
</script>

@if(auth()->check())
<script>
    // Show enable-notifications banner if permission not yet granted
    document.addEventListener('DOMContentLoaded', function() {
        if ('Notification' in window && Notification.permission === 'default') {
            var banner = document.getElementById('fcm-enable-banner');
            if (banner) banner.style.display = 'flex';
        }
    });
</script>
@endif

<!-- Page Loading Overlay -->
<style>
    .page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(4px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s, visibility 0.2s;
    }
    .page-loader.active {
        opacity: 1;
        visibility: visible;
    }
    .page-loader-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #e5e7eb;
        border-top-color: #00c6a7;
        border-radius: 50%;
        animation: page-spin 0.7s linear infinite;
    }
    .page-loader-text {
        margin-top: 12px;
        font-size: 14px;
        font-weight: 500;
        color: #6b7280;
    }
    @keyframes page-spin {
        to { transform: rotate(360deg); }
    }
</style>
<div class="page-loader" id="pageLoader">
    <div class="page-loader-spinner"></div>
    <div class="page-loader-text">Loading...</div>
</div>
<script>
    (function() {
        var loader = document.getElementById('pageLoader');
        document.addEventListener('click', function(e) {
            var link = e.target.closest('a');
            if (!link) return;
            var href = link.getAttribute('href');
            if (!href || href === '#' || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
            if (link.target === '_blank' || e.ctrlKey || e.metaKey || e.shiftKey) return;
            if (link.hasAttribute('download')) return;
            loader.classList.add('active');
        });
        window.addEventListener('pageshow', function() {
            loader.classList.remove('active');
        });
    })();
</script>
