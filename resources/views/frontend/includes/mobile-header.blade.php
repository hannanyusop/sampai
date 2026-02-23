<div class="mobile-app-header">
    <div class="mobile-header-content">
        @if(!request()->routeIs('frontend.user.dashboard'))
            <a href="{{ route('frontend.user.dashboard') }}" class="mobile-back-btn">
                <i class="ni ni-arrow-left"></i>
            </a>
        @endif
        <h1 class="mobile-header-title">@yield('title', 'Page')</h1>
        <div class="mobile-header-action">
            @yield('header-action')
        </div>
    </div>
</div>

<style>
    .mobile-app-header {
        display: none;
    }

    @media (max-width: 767px) {
        .mobile-app-header {
            display: block;
            background: linear-gradient(135deg, var(--accent-color, #667eea) 0%, var(--gradient-end, #764ba2) 100%);
            padding: 16px 20px;
            padding-top: calc(16px + env(safe-area-inset-top, 0px));
            color: white;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .mobile-header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 40px;
        }

        .mobile-back-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 1.25rem;
            transition: background 0.2s;
        }

        .mobile-back-btn:hover {
            background: rgba(255,255,255,0.25);
            color: white;
            text-decoration: none;
        }

        .mobile-header-title {
            flex: 1;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            padding: 0 12px;
        }

        .mobile-header-action {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-header-action:empty {
            visibility: hidden;
        }

        .mobile-header-action a,
        .mobile-header-action button {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 1.25rem;
            border: none;
            cursor: pointer;
        }
    }
</style>
