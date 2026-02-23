@extends('frontend.layouts.app')

@section('title', __('Setup Notifications'))

<style>
    .notif-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px 16px 100px;
    }

    .notif-header {
        text-align: center;
        margin-bottom: 28px;
    }

    .notif-header h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 6px;
    }

    .notif-header p {
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
        border-color: #4facfe;
        color: #4facfe;
        background: rgba(79, 172, 254, 0.08);
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
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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

    /* Important note */
    .notif-important {
        margin-top: 14px;
        background: rgba(245, 87, 108, 0.08);
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .notif-important-icon {
        color: #f5576c;
        font-size: 1rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .notif-important p {
        font-size: 0.76rem;
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.5;
    }

    /* Tip box */
    .notif-tip {
        margin-top: 24px;
        background: rgba(79, 172, 254, 0.08);
        border-radius: 16px;
        padding: 16px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .notif-tip-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: rgba(79, 172, 254, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #4facfe;
        font-size: 1.1rem;
    }

    .notif-tip p {
        font-size: 0.78rem;
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.5;
    }

    /* Enable button */
    .notif-enable-btn {
        display: block;
        width: 100%;
        margin-top: 24px;
        padding: 14px;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        border: none;
        border-radius: 14px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
        box-shadow: 0 4px 16px rgba(79, 172, 254, 0.3);
        transition: transform 0.15s ease;
    }

    .notif-enable-btn:active {
        transform: scale(0.97);
    }
</style>

@section('content')
<div class="notif-container">

    <div class="notif-header">
        <h4>{{ __('Enable Notifications') }}</h4>
        <p>{{ __('Get notified when your parcel status changes') }}</p>
    </div>

    <!-- Enable Button -->
    <button class="notif-enable-btn" id="enable-notif-btn" onclick="enableNotifications()">
        <i class="ni ni-bell" style="margin-right: 6px;"></i> {{ __('Enable Notifications Now') }}
    </button>

    <div style="text-align: center; margin: 16px 0 24px; font-size: 0.78rem; color: var(--text-muted);">
        {{ __('If the button above doesn\'t work, follow the manual steps below.') }}
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
        <div class="notif-important">
            <i class="ni ni-alert notif-important-icon"></i>
            <p>{{ __('iPhone notifications only work if you have installed the app to your home screen (PWA). Please install the app first before enabling notifications.') }}</p>
        </div>

        <div class="step-card">
            <div class="step-num">1</div>
            <div class="step-content">
                <p class="step-title">{{ __('Install the App First') }}</p>
                <p class="step-desc">{{ __('If you haven\'t already, add this app to your home screen using Safari. Go to Dashboard > Setup PWA for the guide.') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">2</div>
            <div class="step-content">
                <p class="step-title">{{ __('Open the App from Home Screen') }}</p>
                <p class="step-desc">{{ __('Open the app from your home screen icon (not from Safari). Notifications only work when opened as an installed app.') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">3</div>
            <div class="step-content">
                <p class="step-title">{{ __('Tap "Enable" on the Banner') }}</p>
                <p class="step-desc">{{ __('When you open the app, you will see a green banner at the top asking to enable notifications. Tap "Enable".') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">4</div>
            <div class="step-content">
                <p class="step-title">{{ __('Allow Notifications') }}</p>
                <p class="step-desc">{{ __('A popup will appear asking for permission. Tap "Allow" to receive notifications.') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">5</div>
            <div class="step-content">
                <p class="step-title">{{ __('If Blocked, Reset in Settings') }}</p>
                <p class="step-desc">{{ __('If you accidentally blocked notifications, go to:') }}</p>
                <div class="step-icon-hint" style="margin-top: 8px;">
                    {{ __('Settings > Apps > NUJ Express > Notifications > Allow') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Android Instructions -->
    <div id="instructions-android" class="steps-list" style="display: none;">
        <div class="step-card">
            <div class="step-num">1</div>
            <div class="step-content">
                <p class="step-title">{{ __('Open the Website in Chrome') }}</p>
                <p class="step-desc">{{ __('Open this website using Google Chrome for the best notification support.') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">2</div>
            <div class="step-content">
                <p class="step-title">{{ __('Tap "Enable" on the Banner') }}</p>
                <p class="step-desc">{{ __('You will see a green banner at the top of the page asking to enable notifications. Tap "Enable".') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">3</div>
            <div class="step-content">
                <p class="step-title">{{ __('Allow Notifications') }}</p>
                <p class="step-desc">{{ __('Chrome will show a popup asking "Allow notifications?". Tap "Allow".') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">4</div>
            <div class="step-content">
                <p class="step-title">{{ __('Done!') }}</p>
                <p class="step-desc">{{ __('You will now receive push notifications when your parcel status changes, pickups are scheduled, and more.') }}</p>
            </div>
        </div>

        <div class="step-card">
            <div class="step-num">5</div>
            <div class="step-content">
                <p class="step-title">{{ __('If Blocked, Reset in Chrome') }}</p>
                <p class="step-desc">{{ __('If you accidentally blocked notifications:') }}</p>
                <div class="step-icon-hint" style="margin-top: 8px;">
                    {{ __('Tap the lock icon (🔒) in the address bar > Notifications > Allow') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Tip -->
    <div class="notif-tip">
        <div class="notif-tip-icon"><i class="ni ni-info"></i></div>
        <p>{{ __('You will receive notifications for parcel status updates, pickup reminders, and important announcements. Make sure to keep notifications enabled for the best experience.') }}</p>
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

    function enableNotifications() {
        if (window.registerFcm) {
            window.registerFcm();
        } else if ('Notification' in window) {
            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted' && window.registerFcm) {
                    window.registerFcm();
                }
            });
        }
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
