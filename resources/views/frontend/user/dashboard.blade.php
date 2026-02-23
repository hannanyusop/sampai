@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

<style>
    .app-container {
        min-height: 100vh;
        background: var(--bg-primary);
        padding-bottom: 100px;
        margin: -1rem;
        margin-bottom: 0;
    }

    /* Header */
    .app-header {
        background: linear-gradient(135deg, var(--accent-color) 0%, var(--gradient-end) 100%);
        padding: 24px 20px 56px;
        padding-top: calc(24px + env(safe-area-inset-top, 0px));
        color: white;
        position: relative;
        margin-bottom: -36px;
    }

    .header-row {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .header-info { flex: 1; }
    .greeting { font-size: 0.8rem; opacity: 0.85; }
    .user-name { font-size: 1.15rem; font-weight: 700; }
    .header-time { text-align: right; }
    .time-val { font-size: 1.3rem; font-weight: 700; }
    .date-val { font-size: 0.7rem; opacity: 0.8; }

    /* Stats */
    .stats-row {
        display: flex;
        gap: 10px;
        padding: 0 16px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        position: relative;
        z-index: 10;
        padding-bottom: 4px;
    }
    .stats-row::-webkit-scrollbar { display: none; }

    .stat {
        flex: 0 0 auto;
        width: 120px;
        background: var(--bg-card);
        border-radius: 16px;
        padding: 16px 14px;
        text-align: center;
        box-shadow: var(--shadow-lg);
        scroll-snap-align: start;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 1.25rem;
    }

    .stat.total .stat-icon { background: var(--accent-light); color: var(--accent-color); }
    .stat.ready .stat-icon { background: rgba(17, 153, 142, 0.1); color: #11998e; }
    .stat.pending .stat-icon { background: rgba(245, 87, 108, 0.1); color: #f5576c; }
    .stat.delivered .stat-icon { background: rgba(79, 172, 254, 0.1); color: #4facfe; }

    .stat-num {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-lbl {
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Section Title */
    .sec-title {
        padding: 24px 20px 12px;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    /* Menu Grid */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        padding: 0 16px;
    }

    .m-card {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 20px 14px;
        text-align: center;
        box-shadow: var(--shadow);
        text-decoration: none;
        color: inherit;
        transition: transform 0.15s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 120px;
        position: relative;
    }

    .m-card:hover { text-decoration: none; color: inherit; }
    .m-card:active { transform: scale(0.97); }

    .m-card.hero {
        background: linear-gradient(135deg, var(--accent-color) 0%, var(--gradient-end) 100%);
        grid-column: span 2;
        flex-direction: row;
        justify-content: flex-start;
        padding: 20px 24px;
        min-height: 80px;
        gap: 16px;
    }

    .m-card.hero .m-icon { background: rgba(255,255,255,0.2); }
    .m-card.hero .m-icon i { color: white; }
    .m-card.hero .m-label { color: white; text-align: left; }
    .m-card.hero .m-sub { color: rgba(255,255,255,0.8); }

    .m-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: var(--accent-light);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        flex-shrink: 0;
    }

    .m-icon i { font-size: 1.5rem; color: var(--accent-color); }

    .m-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .m-sub {
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .m-card.logout { background: var(--bg-card); }
    .m-card.logout .m-icon { background: rgba(229, 62, 62, 0.1); }
    .m-card.logout .m-icon i { color: #e53e3e; }

    /* Badge */
    .m-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #f5576c;
        color: white;
        font-size: 0.6rem;
        font-weight: 700;
        min-width: 18px;
        height: 18px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
    }

    /* Announcement */
    .announcement {
        margin: 24px 16px 0;
        background: linear-gradient(135deg, var(--accent-color) 0%, var(--gradient-end) 100%);
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.2);
    }

    .announcement-icon {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .announcement-icon i { font-size: 1.25rem; color: white; }
    .announcement h6 { font-size: 0.85rem; font-weight: 700; color: white; margin: 0 0 2px; }
    .announcement p { font-size: 0.72rem; color: rgba(255,255,255,0.85); margin: 0; }

    /* Responsive */
    @media (min-width: 576px) {
        .menu-grid { grid-template-columns: repeat(3, 1fr); }
        .m-card.hero {
            grid-column: span 1;
            flex-direction: column;
            justify-content: center;
            gap: 0;
        }
        .m-card.hero .m-icon { margin-bottom: 10px; }
        .m-card.hero .m-label { text-align: center; }
    }

    @media (min-width: 768px) {
        .app-container { padding-bottom: 40px; }
        .menu-grid { grid-template-columns: repeat(4, 1fr); }
        .announcement { max-width: 600px; margin-left: auto; margin-right: auto; }
    }
</style>

@section('content')
<div class="app-container">
    <!-- Header -->
    <div class="app-header">
        <div class="header-row">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="header-info">
                <div class="greeting" id="greeting">{{ __('Welcome back') }}</div>
                <div class="user-name">{{ auth()->user()->name }}</div>
            </div>
            <div class="header-time">
                <div class="time-val" id="time">--:--</div>
                <div class="date-val" id="dates"></div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat total">
            <div class="stat-icon"><i class="ni ni-box"></i></div>
            <div class="stat-num">{{ $stats['total_parcels'] ?? 0 }}</div>
            <div class="stat-lbl">{{ __('Total') }}</div>
        </div>
        <div class="stat ready">
            <div class="stat-icon"><i class="ni ni-check-circle"></i></div>
            <div class="stat-num">{{ $stats['ready_to_collect'] ?? 0 }}</div>
            <div class="stat-lbl">{{ __('Ready') }}</div>
        </div>
        <div class="stat pending">
            <div class="stat-icon"><i class="ni ni-clock"></i></div>
            <div class="stat-num">{{ $stats['pending_parcels'] ?? 0 }}</div>
            <div class="stat-lbl">{{ __('Pending') }}</div>
        </div>
        <div class="stat delivered">
            <div class="stat-icon"><i class="ni ni-check-circle-fill"></i></div>
            <div class="stat-num">{{ $stats['delivered_parcels'] ?? 0 }}</div>
            <div class="stat-lbl">{{ __('Delivered') }}</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="sec-title">{{ __('Quick Actions') }}</div>
    <div class="menu-grid">
        <a href="{{ route('frontend.user.parcel.create') }}" class="m-card hero">
            <div class="m-icon"><i class="icon ni ni-plus"></i></div>
            <div>
                <h5 class="m-label">{{ __('Add New Parcel') }}</h5>
                <div class="m-sub">{{ __('Register your shipment') }}</div>
            </div>
        </a>

        <a href="{{ route('frontend.user.parcel.index') }}" class="m-card">
            @if(($stats['pending_parcels'] ?? 0) > 0)
                <span class="m-badge">{{ $stats['pending_parcels'] }}</span>
            @endif
            <div class="m-icon"><i class="icon ni ni-list-round"></i></div>
            <h5 class="m-label">{{ __('My Parcels') }}</h5>
            <div class="m-sub">{{ __('View all') }}</div>
        </a>

        <a href="{{ route('frontend.user.pickup.index') }}" class="m-card">
            @if(($stats['pending_pickups'] ?? 0) > 0)
                <span class="m-badge">{{ $stats['pending_pickups'] }}</span>
            @endif
            <div class="m-icon"><i class="icon ni ni-package"></i></div>
            <h5 class="m-label">{{ __('Pickups') }}</h5>
            <div class="m-sub">{{ __('Track pickups') }}</div>
        </a>

        <a href="{{ route('frontend.user.account') }}" class="m-card">
            <div class="m-icon"><i class="icon ni ni-setting"></i></div>
            <h5 class="m-label">{{ __('Settings') }}</h5>
            <div class="m-sub">{{ __('Account') }}</div>
        </a>

        <a href="#" id="pwa-install-btn" class="m-card" style="display: none;" onclick="installPWA(event)">
            <div class="m-icon" style="background: rgba(0, 198, 167, 0.1);">
                <i class="icon ni ni-download" style="color: #00c6a7;"></i>
            </div>
            <h5 class="m-label">{{ __('Install App') }}</h5>
            <div class="m-sub">{{ __('Add to home') }}</div>
        </a>

        <a href="{{ route('frontend.auth.logout') }}" class="m-card logout">
            <div class="m-icon"><i class="icon ni ni-signout"></i></div>
            <h5 class="m-label">{{ __('Log Out') }}</h5>
            <div class="m-sub">{{ __('Sign out') }}</div>
        </a>
    </div>

    <!-- Announcement -->
    <div class="announcement">
        <div class="announcement-icon"><i class="ni ni-mobile"></i></div>
        <div>
            <h6>{{ __('Mobile App Coming Soon!') }}</h6>
            <p>{{ __('Stay tuned for our iOS and Android apps.') }}</p>
        </div>
    </div>
</div>
@endsection

@push('after-script')
<script>
    // PWA Install
    var deferredPrompt = null;
    window.addEventListener('beforeinstallprompt', function(e) {
        e.preventDefault();
        deferredPrompt = e;
        document.getElementById('pwa-install-btn').style.display = '';
    });

    function installPWA(e) {
        e.preventDefault();
        if (!deferredPrompt) return;
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then(function(r) {
            if (r.outcome === 'accepted') document.getElementById('pwa-install-btn').style.display = 'none';
            deferredPrompt = null;
        });
    }

    window.addEventListener('appinstalled', function() {
        document.getElementById('pwa-install-btn').style.display = 'none';
        deferredPrompt = null;
    });

    function updateTime() {
        var d = new Date();
        var h = d.getHours();
        var greeting = h < 12 ? '{{ __("Good Morning") }}' : h < 17 ? '{{ __("Good Afternoon") }}' : '{{ __("Good Evening") }}';
        document.getElementById("greeting").innerHTML = greeting;
        document.getElementById("time").innerHTML = (h < 10 ? "0" : "") + h + ":" + (d.getMinutes() < 10 ? "0" : "") + d.getMinutes();
        document.getElementById("dates").innerHTML = d.toLocaleDateString(undefined, { weekday: 'short', day: 'numeric', month: 'short' });
    }
    updateTime();
    setInterval(updateTime, 1000);
</script>
@endpush
