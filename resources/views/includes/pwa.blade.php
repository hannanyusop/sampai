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
