@extends('frontend.layouts.app')

@section('title', __('Setup PWA'))

<style>
    .pwa-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px 16px 100px;
    }

    .pwa-header {
        text-align: center;
        margin-bottom: 28px;
    }

    .pwa-header h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 6px;
    }

    .pwa-header p {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* Platform Tabs */
    .platform-tabs {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-bottom: 28px;
    }

    .platform-tab {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 16px 28px;
        border-radius: 16px;
        background: var(--bg-card);
        box-shadow: var(--shadow);
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s ease;
        text-decoration: none;
        color: var(--text-secondary);
    }

    .platform-tab:hover {
        text-decoration: none;
        color: var(--text-secondary);
    }

    .platform-tab:active {
        transform: scale(0.97);
    }

    .platform-tab.active {
        border-color: var(--accent-color);
        color: var(--accent-color);
        background: var(--accent-light);
    }

    .platform-tab svg {
        width: 36px;
        height: 36px;
    }

    .platform-tab .tab-label {
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* Steps */
    .steps-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .step-card {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        background: var(--bg-card);
        border-radius: 16px;
        padding: 16px;
        box-shadow: var(--shadow);
    }

    .step-num {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent-color) 0%, var(--gradient-end) 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .step-content {
        flex: 1;
    }

    .step-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 4px;
    }

    .step-desc {
        font-size: 0.78rem;
        color: var(--text-muted);
        margin: 0;
        line-height: 1.5;
    }

    .step-icon-hint {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: var(--badge-bg);
        border-radius: 8px;
        padding: 4px 8px;
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 8px;
    }

    .step-icon-hint svg {
        width: 16px;
        height: 16px;
    }

    /* Tip box */
    .pwa-tip {
        margin-top: 24px;
        background: rgba(0, 198, 167, 0.08);
        border-radius: 16px;
        padding: 16px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .pwa-tip-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: rgba(0, 198, 167, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #00c6a7;
        font-size: 1.1rem;
    }

    .pwa-tip p {
        font-size: 0.78rem;
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.5;
    }
</style>

@section('content')
<div class="pwa-container">

    <div class="pwa-header">
        <h4>{{ __('Install Our App') }}</h4>
        <p>{{ __('Add to your home screen for a faster experience') }}</p>
    </div>

    <!-- Platform Tabs -->
    <div class="platform-tabs">
        <div class="platform-tab active" id="tab-ios" onclick="switchTab('ios')">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
            </svg>
            <span class="tab-label">iPhone</span>
        </div>
        <div class="platform-tab" id="tab-android" onclick="switchTab('android')">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.6 9.48l1.84-3.18c.16-.31.04-.69-.26-.85-.29-.15-.65-.06-.83.22l-1.88 3.24a11.463 11.463 0 00-8.94 0L5.65 5.67c-.19-.29-.54-.38-.84-.2-.28.18-.37.54-.22.83L6.4 9.48A10.78 10.78 0 002 18h20a10.78 10.78 0 00-4.4-8.52zM7 15.25a1.25 1.25 0 110-2.5 1.25 1.25 0 010 2.5zm10 0a1.25 1.25 0 110-2.5 1.25 1.25 0 010 2.5z"/>
            </svg>
            <span class="tab-label">Android</span>
        </div>
    </div>

    <!-- iOS Instructions -->
    <div id="instructions-ios" class="steps-list">
        <div class="step-card">
            <div class="step-num">1</div>
            <div class="step-content">
                <p class="step-title">{{ __('Open in Safari') }}</p>
                <p class="step-desc">{{ __('Make sure you are using the Safari browser. This will not work in Chrome or other browsers on iPhone.') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">2</div>
            <div class="step-content">
                <p class="step-title">{{ __('Tap the Share Button') }}</p>
                <p class="step-desc">{{ __('Look for the share icon at the bottom of the screen (square with an arrow pointing up).') }}</p>
                <div class="step-icon-hint">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 5l-1.42 1.42-1.59-1.59V16h-1.98V4.83L9.42 6.42 8 5l4-4 4 4zm4 5v11c0 1.1-.9 2-2 2H6c-1.11 0-2-.9-2-2V10c0-1.11.89-2 2-2h3v2H6v11h12V10h-3V8h3c1.1 0 2 .89 2 2z"/></svg>
                    {{ __('Share icon') }}
                </div>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">3</div>
            <div class="step-content">
                <p class="step-title">{{ __('Tap "Add to Home Screen"') }}</p>
                <p class="step-desc">{{ __('Scroll down in the share menu and look for "Add to Home Screen". Tap on it.') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">4</div>
            <div class="step-content">
                <p class="step-title">{{ __('Tap "Add"') }}</p>
                <p class="step-desc">{{ __('You can rename the app if you want, then tap "Add" at the top right corner to confirm.') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">5</div>
            <div class="step-content">
                <p class="step-title">{{ __('Done!') }}</p>
                <p class="step-desc">{{ __('The app icon will now appear on your home screen. Open it anytime for quick access.') }}</p>
            </div>
        </div>
    </div>

    <!-- Android Instructions -->
    <div id="instructions-android" class="steps-list" style="display: none;">
        <div class="step-card">
            <div class="step-num">1</div>
            <div class="step-content">
                <p class="step-title">{{ __('Open in Chrome') }}</p>
                <p class="step-desc">{{ __('Make sure you are using Google Chrome browser for the best experience.') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">2</div>
            <div class="step-content">
                <p class="step-title">{{ __('Tap the Menu Button') }}</p>
                <p class="step-desc">{{ __('Tap the three dots (⋮) at the top right corner of Chrome.') }}</p>
                <div class="step-icon-hint">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                    {{ __('Menu icon') }}
                </div>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">3</div>
            <div class="step-content">
                <p class="step-title">{{ __('Tap "Add to Home Screen"') }}</p>
                <p class="step-desc">{{ __('Find and tap "Add to Home Screen" or "Install App" from the menu.') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">4</div>
            <div class="step-content">
                <p class="step-title">{{ __('Tap "Add" or "Install"') }}</p>
                <p class="step-desc">{{ __('A popup will appear. Tap "Add" or "Install" to confirm the installation.') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">5</div>
            <div class="step-content">
                <p class="step-title">{{ __('Done!') }}</p>
                <p class="step-desc">{{ __('The app icon will now appear on your home screen. Open it anytime for quick access.') }}</p>
            </div>
        </div>
    </div>

    <!-- Tip -->
    <div class="pwa-tip">
        <div class="pwa-tip-icon"><i class="ni ni-info"></i></div>
        <p>{{ __('Once installed, the app will open in full screen just like a native app. You will also receive push notifications.') }}</p>
    </div>

</div>
@endsection

@push('after-script')
<script>
    function switchTab(platform) {
        document.getElementById('tab-ios').classList.toggle('active', platform === 'ios');
        document.getElementById('tab-android').classList.toggle('active', platform === 'android');
        document.getElementById('instructions-ios').style.display = platform === 'ios' ? '' : 'none';
        document.getElementById('instructions-android').style.display = platform === 'android' ? '' : 'none';
    }

    // Auto-detect platform
    (function() {
        var ua = navigator.userAgent || '';
        if (/android/i.test(ua)) {
            switchTab('android');
        }
    })();
</script>
@endpush
