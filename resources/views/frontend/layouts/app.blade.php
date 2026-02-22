<!DOCTYPE html>
<html lang="eb" class="js">

@include('frontend.includes.header1')

<style>
    /* Mobile App Styles */
    @media (max-width: 767px) {
        .nk-header {
            display: none !important;
        }

        .nk-content {
            padding: 0 !important;
            margin: 0 !important;
        }

        .nk-content-inner {
            padding: 0 !important;
            margin: 0 !important;
        }

        .nk-content-body {
            padding: 0 !important;
            margin: 0 !important;
        }

        .nk-wrap {
            padding: 0 !important;
            margin: 0 !important;
        }

        .nk-main {
            padding: 0 !important;
            margin: 0 !important;
        }

        body.nk-body {
            padding-top: 0 !important;
            margin: 0 !important;
        }

        .nk-app-root {
            padding: 0 !important;
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
        background: white;
        padding: 12px 20px;
        padding-bottom: calc(12px + env(safe-area-inset-bottom, 0px));
        display: flex;
        justify-content: space-around;
        align-items: center;
        box-shadow: 0 -4px 24px rgba(0,0,0,0.08);
        border-radius: 24px 24px 0 0;
        z-index: 100;
    }

    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: #999;
        padding: 8px 16px;
        border-radius: 12px;
        transition: all 0.2s;
    }

    .nav-item:hover {
        text-decoration: none;
        color: #667eea;
    }

    .nav-item.active {
        color: #667eea;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
