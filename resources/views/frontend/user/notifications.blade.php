@php $extend = (auth()->user()->type == 'user')? 'frontend.layouts.app' :  'backend.layouts.app'; @endphp

@extends($extend)

@section('title', __('Notification Settings'))

@section('content')
<style>
    .notif-page {
        min-height: 100vh;
        background: var(--bg-primary);
        padding-bottom: 100px;
    }

    .notif-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 20px 36px;
        position: relative;
    }

    .notif-header-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: rgba(255,255,255,0.85);
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 12px;
    }

    .notif-header-back:hover { color: white; text-decoration: none; }

    .notif-header-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: white;
    }

    .notif-header-subtitle {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.7);
        margin-top: 2px;
    }

    .notif-sections {
        padding: 0 16px;
        margin-top: -20px;
        position: relative;
        z-index: 1;
    }

    .section-group { margin-bottom: 16px; }

    .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 0 4px;
        margin-bottom: 6px;
    }

    .info-card {
        background: var(--bg-card);
        border-radius: 14px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .info-row {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
    }

    .info-row:last-child { border-bottom: none; }

    .info-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .info-icon.purple { background: rgba(102, 126, 234, 0.1); color: #667eea; }
    .info-icon.green { background: rgba(17, 153, 142, 0.1); color: #11998e; }
    .info-icon.blue { background: rgba(79, 172, 254, 0.1); color: #4facfe; }
    .info-icon.orange { background: rgba(255, 154, 0, 0.1); color: #ff9a00; }

    .info-details { flex: 1; min-width: 0; }

    .info-label {
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .info-value {
        font-size: 0.9rem;
        color: var(--text-primary);
        font-weight: 500;
    }

    .link-row {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
        cursor: pointer;
        transition: background 0.15s;
        text-decoration: none;
        color: inherit;
    }

    .link-row:last-child { border-bottom: none; }
    .link-row:hover { background: var(--bg-secondary); text-decoration: none; color: inherit; }

    .link-row .link-title { font-size: 0.9rem; font-weight: 600; color: var(--text-primary); }
    .link-row .link-subtitle { font-size: 0.75rem; color: var(--text-muted); }
    .link-arrow { color: var(--text-muted); font-size: 1rem; margin-left: auto; flex-shrink: 0; }

    .notif-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    .notif-status-dot.active { background: #11998e; }
    .notif-status-dot.inactive { background: var(--text-muted); }
    .notif-status-dot.blocked { background: #e53e3e; }

    .notif-feedback {
        font-size: 0.75rem;
        margin-left: auto;
        padding: 2px 8px;
        border-radius: 6px;
        white-space: nowrap;
    }
    .notif-feedback.success { background: rgba(17, 153, 142, 0.1); color: #11998e; }
    .notif-feedback.error { background: rgba(229, 62, 62, 0.1); color: #e53e3e; }

    @media (min-width: 768px) {
        .notif-page { padding-top: 20px; }
        .notif-sections { max-width: 480px; margin-left: auto; margin-right: auto; }
        .notif-header { max-width: 480px; margin: 0 auto; border-radius: 0 0 20px 20px; }
    }
</style>

<div class="notif-page">
    <div class="notif-header">
        <a href="{{ route('frontend.user.account') }}" class="notif-header-back">
            <i class="ni ni-chevron-left"></i> {{ __('Account') }}
        </a>
        <div class="notif-header-title">{{ __('Notifications') }}</div>
        <div class="notif-header-subtitle">{{ __('Manage your push notification settings') }}</div>
    </div>

    <div class="notif-sections">
        <!-- Status -->
        <div class="section-group">
            <div class="section-label">{{ __('Status') }}</div>
            <div class="info-card">
                <div class="info-row">
                    <div class="info-icon green"><i class="ni ni-bell"></i></div>
                    <div class="info-details">
                        <div class="info-label">{{ __('Push Notification Status') }}</div>
                        <div class="info-value" id="notifStatusText">
                            <span class="notif-status-dot inactive" id="notifStatusDot"></span>
                            <span id="notifStatusLabel">{{ __('Checking...') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="section-group">
            <div class="section-label">{{ __('Actions') }}</div>
            <div class="info-card">
                <a href="javascript:void(0)" class="link-row" onclick="reregisterFcm()">
                    <div class="info-icon blue"><i class="ni ni-reload"></i></div>
                    <div class="info-details">
                        <div class="link-title">{{ __('Re-register') }}</div>
                        <div class="link-subtitle">{{ __('Request permission and register token') }}</div>
                    </div>
                    <span class="notif-feedback" id="reregisterFeedback" style="display:none"></span>
                    <div class="link-arrow"><i class="ni ni-chevron-right"></i></div>
                </a>
                <a href="javascript:void(0)" class="link-row" onclick="revokeFcm()">
                    <div class="info-icon orange"><i class="ni ni-cross-circle"></i></div>
                    <div class="info-details">
                        <div class="link-title">{{ __('Revoke') }}</div>
                        <div class="link-subtitle">{{ __('Remove push notification token') }}</div>
                    </div>
                    <span class="notif-feedback" id="revokeFeedback" style="display:none"></span>
                    <div class="link-arrow"><i class="ni ni-chevron-right"></i></div>
                </a>
                <a href="javascript:void(0)" class="link-row" onclick="testFcmNotification()">
                    <div class="info-icon purple"><i class="ni ni-send"></i></div>
                    <div class="info-details">
                        <div class="link-title">{{ __('Test Notification') }}</div>
                        <div class="link-subtitle">{{ __('Send a test push notification') }}</div>
                    </div>
                    <span class="notif-feedback" id="testFeedback" style="display:none"></span>
                    <div class="link-arrow"><i class="ni ni-chevron-right"></i></div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    var hasServerToken = {{ $logged_in_user->fcm_token ? 'true' : 'false' }};

    function refreshNotificationStatus() {
        var dot = document.getElementById('notifStatusDot');
        var label = document.getElementById('notifStatusLabel');
        var permission = typeof Notification !== 'undefined' ? Notification.permission : 'unsupported';

        if (permission === 'denied') {
            dot.className = 'notif-status-dot blocked';
            label.textContent = '{{ __("Blocked by browser") }}';
        } else if (permission === 'granted' && hasServerToken) {
            dot.className = 'notif-status-dot active';
            label.textContent = '{{ __("Active") }}';
        } else {
            dot.className = 'notif-status-dot inactive';
            label.textContent = '{{ __("Not registered") }}';
        }
    }

    function showFeedback(id, success, text) {
        var el = document.getElementById(id);
        el.textContent = text;
        el.className = 'notif-feedback ' + (success ? 'success' : 'error');
        el.style.display = '';
        setTimeout(function() { el.style.display = 'none'; }, 3000);
    }

    function reregisterFcm() {
        if (typeof window.registerFcm !== 'function') {
            showFeedback('reregisterFeedback', false, '{{ __("FCM not available") }}');
            return;
        }
        showFeedback('reregisterFeedback', true, '{{ __("Registering...") }}');
        window.registerFcm().then(function() {
            hasServerToken = true;
            refreshNotificationStatus();
            showFeedback('reregisterFeedback', true, '{{ __("Done") }}');
        }).catch(function(err) {
            refreshNotificationStatus();
            showFeedback('reregisterFeedback', false, err.message || '{{ __("Failed") }}');
        });
    }

    function revokeFcm() {
        showFeedback('revokeFeedback', true, '{{ __("Revoking...") }}');
        fetch('{{ route("fcm.token.destroy") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        }).then(function(r) { return r.json(); }).then(function(data) {
            hasServerToken = false;
            refreshNotificationStatus();
            showFeedback('revokeFeedback', true, data.message || '{{ __("Revoked") }}');
        }).catch(function() {
            showFeedback('revokeFeedback', false, '{{ __("Failed") }}');
        });
    }

    function testFcmNotification() {
        showFeedback('testFeedback', true, '{{ __("Sending...") }}');
        fetch('{{ route("fcm.test-notification") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        }).then(function(r) {
            if (!r.ok) return r.json().then(function(d) { throw new Error(d.message); });
            return r.json();
        }).then(function(data) {
            showFeedback('testFeedback', true, data.message || '{{ __("Sent") }}');
        }).catch(function(err) {
            showFeedback('testFeedback', false, err.message || '{{ __("Failed") }}');
        });
    }

    refreshNotificationStatus();
</script>
@endsection
