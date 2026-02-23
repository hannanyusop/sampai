<!DOCTYPE html>
<html lang="eb" class="js">

@include('frontend.includes.header1')

<style>
    /* Theme Variables */
    :root {
        --accent-color: #667eea;
        --accent-light: rgba(102, 126, 234, 0.1);
        --gradient-end: #764ba2;
        --bg-primary: #f5f6fa;
        --bg-secondary: #ffffff;
        --bg-card: #ffffff;
        --text-primary: #1a1a2e;
        --text-secondary: #666666;
        --text-muted: #999999;
        --border-color: #f2f3f5;
        --shadow: 0 4px 20px rgba(0,0,0,0.06);
        --shadow-lg: 0 8px 24px rgba(0,0,0,0.08);
        --nav-bg: #ffffff;
        --nav-shadow: 0 -4px 24px rgba(0,0,0,0.08);
        --input-bg: #fafbfc;
        --badge-bg: rgba(0,0,0,0.03);
    }

    [data-theme="dark"] {
        --bg-primary: #0f0f1a;
        --bg-secondary: #1a1a2e;
        --bg-card: #1e1e35;
        --text-primary: #e8e8f0;
        --text-secondary: #a0a0b8;
        --text-muted: #6b6b82;
        --border-color: #2a2a42;
        --shadow: 0 4px 20px rgba(0,0,0,0.2);
        --shadow-lg: 0 8px 24px rgba(0,0,0,0.3);
        --nav-bg: #1a1a2e;
        --nav-shadow: 0 -4px 24px rgba(0,0,0,0.3);
        --input-bg: #16162a;
        --badge-bg: rgba(255,255,255,0.05);
        --accent-light: rgba(102, 126, 234, 0.15);
    }

    [data-theme="dark"] body,
    [data-theme="dark"] .nk-body {
        background: var(--bg-primary) !important;
        color: var(--text-primary);
    }

    /* Mobile App Styles */
    @media (max-width: 767px) {
        .nk-header {
            display: none !important;
        }

        .nk-content,
        .nk-content-inner,
        .nk-content-body,
        .nk-wrap,
        .nk-main,
        .nk-app-root {
            padding: 0 !important;
            margin: 0 !important;
        }

        body.nk-body {
            padding-top: 0 !important;
            margin: 0 !important;
        }

        html, body {
            margin: 0 !important;
            padding: 0 !important;
        }
    }

    /* Bottom Navigation - Global */
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: var(--nav-bg);
        padding: 12px 20px;
        padding-bottom: calc(12px + env(safe-area-inset-bottom, 0px));
        display: flex;
        justify-content: space-around;
        align-items: center;
        box-shadow: var(--nav-shadow);
        border-radius: 24px 24px 0 0;
        z-index: 100;
    }

    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: var(--text-muted);
        padding: 8px 16px;
        border-radius: 12px;
        transition: all 0.2s;
    }

    .nav-item:hover {
        text-decoration: none;
        color: var(--accent-color);
    }

    .nav-item.active {
        color: var(--accent-color);
    }

    .nav-item .nav-icon {
        font-size: 1.5rem;
        margin-bottom: 4px;
    }

    .nav-item .nav-label {
        font-size: 0.7rem;
        font-weight: 600;
    }

    .nav-item.fab {
        background: linear-gradient(135deg, var(--accent-color) 0%, var(--gradient-end) 100%);
        color: white;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        margin-top: -30px;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
        padding: 0;
        justify-content: center;
    }

    .nav-item.fab:hover {
        color: white;
        transform: scale(1.05);
    }

    .nav-item.fab .nav-icon {
        font-size: 1.75rem;
        margin-bottom: 0;
    }

    /* Show bottom nav on all screen sizes including laptop */
    @media (min-width: 768px) {
        .bottom-nav {
            max-width: 500px;
            left: 50%;
            transform: translateX(-50%);
        }
    }
</style>

<body class="nk-body npc-subscription has-aside ui-clean ">

<!-- Notification Enable Banner (iOS requires user gesture) -->
@if(auth()->check())
<div id="fcm-enable-banner" style="display:none; align-items:center; justify-content:space-between; padding:12px 16px; background:#00c6a7; color:#fff; font-size:14px; gap:10px; z-index:99999; position:relative;">
    <span>Enable push notifications to stay updated.</span>
    <button onclick="window.registerFcm && window.registerFcm(); this.parentElement.style.display='none';"
        style="background:#fff; color:#00c6a7; border:none; padding:6px 16px; border-radius:6px; font-weight:600; cursor:pointer; white-space:nowrap;">
        Enable
    </button>
    <button onclick="this.parentElement.style.display='none';"
        style="background:transparent; color:#fff; border:none; cursor:pointer; font-size:18px; padding:0 4px;">&times;</button>
</div>
@endif

<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap ">
            @if(!request()->routeIs('frontend.user.dashboard'))
                @include('frontend.includes.mobile-header')
            @endif
            <div class="nk-content">
                <div class="nk-content-inner p-3">
                    <div class="nk-content-body">
{{--                        @include('includes.partials.messages')--}}
                        @include('includes.partials.logged-in-as')
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navigation -->
@auth
@if(!request()->routeIs('frontend.user.account') && !request()->routeIs('frontend.user.parcel.create'))
<nav class="bottom-nav">
    <a href="{{ route('frontend.user.dashboard') }}" class="nav-item {{ request()->routeIs('frontend.user.dashboard') ? 'active' : '' }}">
        <i class="ni ni-home nav-icon"></i>
        <span class="nav-label">{{ __('Home') }}</span>
    </a>
    <a href="{{ route('frontend.user.parcel.index') }}" class="nav-item {{ request()->routeIs('frontend.user.parcel.*') && !request()->routeIs('frontend.user.parcel.create') ? 'active' : '' }}">
        <i class="ni ni-list-round nav-icon"></i>
        <span class="nav-label">{{ __('Parcels') }}</span>
    </a>
    <a href="{{ route('frontend.user.parcel.create') }}" class="nav-item fab">
        <i class="ni ni-plus nav-icon"></i>
    </a>
    <a href="{{ route('frontend.user.pickup.index') }}" class="nav-item {{ request()->routeIs('frontend.user.pickup.*') ? 'active' : '' }}">
        <i class="ni ni-package nav-icon"></i>
        <span class="nav-label">{{ __('Pickups') }}</span>
    </a>
    <a href="{{ route('frontend.user.account') }}" class="nav-item {{ request()->routeIs('frontend.user.account') ? 'active' : '' }}">
        <i class="ni ni-user nav-icon"></i>
        <span class="nav-label">{{ __('Account') }}</span>
    </a>
</nav>
@endif
@endauth
</body>
@livewireScripts
@stack('after-script')
</html>
