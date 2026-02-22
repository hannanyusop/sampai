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
