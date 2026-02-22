<!DOCTYPE html>
<html lang="zxx" class="js">

<style>
    .menu-card {
        text-align: center;
        padding: 2em;
        border-radius: 10px;
        background-color: #f8f9fa;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        display: flex;
        justify-content: center;
        margin: 0.5em;
        width: 10em;
        height: 10em;
    }

    .menu-card:hover {
        background-color: #f1f1f1;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    .menu-icon {
        font-size: 3em;
    }
    .menu-label {
        font-size: 1em;
        margin-top: 1em;
    }
</style>

@include('backend.includes.header1')

<body class="nk-body npc-invest bg-lighter ">

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
    <!-- wrap @s -->
    <div class="nk-wrap ">
        <!-- main header @s -->
        <div class="nk-header nk-header-fluid is-theme">
            <div class="container-xl wide-lg">
                <div class="nk-header-wrap">
                    <div class="nk-menu-trigger mr-sm-2 d-lg-none">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-header-brand">
                        <a href="{{ route(homeRoute()) }}" class="logo-link">
                            <img class="logo-light logo-img" src="{{ asset('images/logo.png') }}"  alt="logo">
                            <img class="logo-dark logo-img" src="{{ asset('images/logo.png') }}" alt="logo-dark">
                        </a>
                    </div><!-- .nk-header-brand -->
                    @include('backend.includes.menu')
                    @include('backend.includes.topbar')
                </div><!-- .nk-header-wrap -->
            </div><!-- .container-fliud -->
        </div>
        <div class="nk-content nk-content-lg nk-content-fluid">
            @include('includes.partials.messages')
            @include('includes.partials.logged-in-as')
            @yield('content')
        </div>
        @include('backend.includes.footer')
    </div>
</div>
{{--<script src="{{ asset('assets/js/charts/gd-general.js') }}?ver=1.4.0"></script>--}}

</body>

</html>
