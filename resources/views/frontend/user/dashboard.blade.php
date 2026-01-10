@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

<style>
    /* Mobile App Container */
    .app-container {
        min-height: 100vh;
        background: linear-gradient(180deg, #f0f4ff 0%, #ffffff 100%);
        padding-bottom: 100px;
        margin: -1rem;
        margin-bottom: 0;
    }

    /* App Header */
    .app-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 20px 60px;
        padding-top: calc(20px + env(safe-area-inset-top, 0px));
        border-radius: 0 0 32px 32px;
        color: white;
        position: relative;
        margin: 0;
        margin-bottom: -40px;
    }

    @media (max-width: 767px) {
        .app-header {
            border-radius: 0 0 24px 24px;
            margin-left: 0;
            margin-right: 0;
        }
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .header-greeting {
        flex: 1;
        margin-left: 16px;
    }

    .greeting-text {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .user-name {
        font-size: 1.25rem;
        font-weight: 700;
    }

    .header-time {
        text-align: right;
    }

    .time-display {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .date-display {
        font-size: 0.75rem;
        opacity: 0.8;
    }

    /* Stats Cards - Horizontal Scroll */
    .stats-scroll {
        padding: 0 16px;
        margin-bottom: 24px;
        position: relative;
        z-index: 10;
    }

    .stats-container {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        padding: 4px;
    }

    .stats-container::-webkit-scrollbar {
        display: none;
    }

    .stat-card {
        flex: 0 0 auto;
        width: 140px;
        background: white;
        border-radius: 20px;
        padding: 20px 16px;
        text-align: center;
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        scroll-snap-align: start;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .stat-card.total::before { background: linear-gradient(90deg, #667eea, #764ba2); }
    .stat-card.ready::before { background: linear-gradient(90deg, #11998e, #38ef7d); }
    .stat-card.pending::before { background: linear-gradient(90deg, #f093fb, #f5576c); }
    .stat-card.delivered::before { background: linear-gradient(90deg, #4facfe, #00f2fe); }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 1.5rem;
    }

    .stat-card.total .stat-icon { background: rgba(102, 126, 234, 0.1); color: #667eea; }
    .stat-card.ready .stat-icon { background: rgba(17, 153, 142, 0.1); color: #11998e; }
    .stat-card.pending .stat-icon { background: rgba(245, 87, 108, 0.1); color: #f5576c; }
    .stat-card.delivered .stat-icon { background: rgba(79, 172, 254, 0.1); color: #4facfe; }

    .stat-number {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #666;
        font-weight: 500;
    }

    /* Quick Actions Section */
    .section-title {
        padding: 0 20px;
        margin-bottom: 16px;
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a2e;
    }

    /* Menu Grid */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        padding: 0 16px;
    }

    .menu-card {
        background: white;
        border-radius: 24px;
        padding: 24px 16px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        text-decoration: none;
        color: inherit;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 140px;
        position: relative;
        overflow: hidden;
    }

    .menu-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .menu-card:active {
        transform: scale(0.96);
    }

    .menu-card:active::after {
        opacity: 1;
    }

    .menu-card.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        grid-column: span 2;
        flex-direction: row;
        justify-content: flex-start;
        padding: 24px 28px;
        min-height: 100px;
    }

    .menu-card.primary .menu-icon-wrap {
        background: rgba(255,255,255,0.2);
        margin-right: 20px;
        margin-bottom: 0;
    }

    .menu-card.primary .menu-icon {
        color: white;
    }

    .menu-card.primary .menu-label {
        color: white;
        text-align: left;
    }

    .menu-card.primary .menu-sublabel {
        color: rgba(255,255,255,0.8);
    }

    .menu-icon-wrap {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }

    .menu-icon {
        font-size: 1.75rem;
        color: #667eea;
    }

    .menu-label {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }

    .menu-sublabel {
        font-size: 0.75rem;
        color: #888;
        margin-top: 4px;
    }

    .menu-card.logout {
        background: #fff5f5;
    }

    .menu-card.logout .menu-icon-wrap {
        background: rgba(229, 62, 62, 0.1);
    }

    .menu-card.logout .menu-icon {
        color: #e53e3e;
    }

    /* Badge */
    .badge-count {
        position: absolute;
        top: -4px;
        right: -4px;
        background: #f5576c;
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        min-width: 18px;
        height: 18px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
    }

    /* Info Banner Carousel */
    .info-banner-carousel {
        margin: 24px 16px 0;
    }

    @media (min-width: 768px) {
        .info-banner-carousel {
            max-width: 600px;
            margin: 24px auto 0;
        }
    }

    .carousel-container {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    }

    .carousel-track {
        display: flex;
        transition: transform 0.4s ease-in-out;
    }

    .carousel-slide {
        min-width: 100%;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .carousel-slide.development {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .carousel-slide.app-coming {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .carousel-slide.phone-view {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .carousel-slide-icon {
        width: 44px;
        height: 44px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .carousel-slide-icon i {
        font-size: 1.5rem;
        color: white;
    }

    .carousel-slide-content {
        flex: 1;
    }

    .carousel-slide-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: white;
        margin: 0 0 4px 0;
    }

    .carousel-slide-text {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.9);
        margin: 0;
    }

    .carousel-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        padding: 12px 0 8px;
        background: rgba(0,0,0,0.03);
    }

    .carousel-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(102, 126, 234, 0.3);
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        padding: 0;
    }

    .carousel-dot.active {
        background: #667eea;
        width: 24px;
        border-radius: 4px;
    }

    /* Responsive */
    @media (min-width: 576px) {
        .menu-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .menu-card.primary {
            grid-column: span 1;
            flex-direction: column;
            justify-content: center;
        }

        .menu-card.primary .menu-icon-wrap {
            margin-right: 0;
            margin-bottom: 12px;
        }

        .menu-card.primary .menu-label {
            text-align: center;
        }

        .stat-card {
            width: 160px;
        }
    }

    @media (min-width: 768px) {
        .app-container {
            padding-bottom: 40px;
        }

        .menu-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
</style>

@section('content')
<div class="app-container">
    <!-- App Header -->
    <div class="app-header">
        <div class="header-top">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="header-greeting">
                <div class="greeting-text" id="greeting">{{ __('Welcome back') }}</div>
                <div class="user-name">{{ auth()->user()->name }}</div>
            </div>
            <div class="header-time">
                <div class="time-display" id="time">--:--</div>
                <div class="date-display" id="dates"></div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-scroll">
        <div class="stats-container">
            <div class="stat-card total">
                <div class="stat-icon">
                    <i class="ni ni-box"></i>
                </div>
                <div class="stat-number">{{ $stats['total_parcels'] ?? 0 }}</div>
                <div class="stat-label">{{ __('Total Parcels') }}</div>
            </div>
            <div class="stat-card ready">
                <div class="stat-icon">
                    <i class="ni ni-check-circle"></i>
                </div>
                <div class="stat-number">{{ $stats['ready_to_collect'] ?? 0 }}</div>
                <div class="stat-label">{{ __('Ready') }}</div>
            </div>
            <div class="stat-card pending">
                <div class="stat-icon">
                    <i class="ni ni-clock"></i>
                </div>
                <div class="stat-number">{{ $stats['pending_parcels'] ?? 0 }}</div>
                <div class="stat-label">{{ __('Pending') }}</div>
            </div>
            <div class="stat-card delivered">
                <div class="stat-icon">
                    <i class="ni ni-check-circle-fill"></i>
                </div>
                <div class="stat-number">{{ $stats['delivered_parcels'] ?? 0 }}</div>
                <div class="stat-label">{{ __('Delivered') }}</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="section-title">{{ __('Quick Actions') }}</div>
    <div class="menu-grid">
        <a href="{{ route('frontend.user.parcel.create') }}" class="menu-card primary">
            <div class="menu-icon-wrap">
                <i class="icon ni ni-plus menu-icon"></i>
            </div>
            <div>
                <h5 class="menu-label">{{ __('Add New Parcel') }}</h5>
                <div class="menu-sublabel">{{ __('Register your shipment') }}</div>
            </div>
        </a>

        <a href="{{ route('frontend.user.parcel.index') }}" class="menu-card">
            <div class="menu-icon-wrap" style="position: relative;">
                <i class="icon ni ni-list-round menu-icon"></i>
                @if(($stats['pending_parcels'] ?? 0) > 0)
                    <span class="badge-count">{{ $stats['pending_parcels'] }}</span>
                @endif
            </div>
            <h5 class="menu-label">{{ __('My Parcels') }}</h5>
            <div class="menu-sublabel">{{ __('View all parcels') }}</div>
        </a>

        <a href="{{ route('frontend.user.pickup.index') }}" class="menu-card">
            <div class="menu-icon-wrap" style="position: relative;">
                <i class="icon ni ni-package menu-icon"></i>
                @if(($stats['pending_pickups'] ?? 0) > 0)
                    <span class="badge-count">{{ $stats['pending_pickups'] }}</span>
                @endif
            </div>
            <h5 class="menu-label">{{ __('Pickups') }}</h5>
            <div class="menu-sublabel">{{ __('Track pickups') }}</div>
        </a>

        <a href="{{ route('frontend.user.account') }}" class="menu-card">
            <div class="menu-icon-wrap">
                <i class="icon ni ni-setting menu-icon"></i>
            </div>
            <h5 class="menu-label">{{ __('Settings') }}</h5>
            <div class="menu-sublabel">{{ __('Account settings') }}</div>
        </a>

        <a href="{{ route('frontend.auth.logout') }}" class="menu-card logout">
            <div class="menu-icon-wrap">
                <i class="icon ni ni-signout menu-icon"></i>
            </div>
            <h5 class="menu-label">{{ __('Log Out') }}</h5>
            <div class="menu-sublabel">{{ __('Sign out safely') }}</div>
        </a>
    </div>

    <!-- Info Banner Carousel -->
    <div class="info-banner-carousel" id="infoBannerCarousel">
        <div class="carousel-container">
                        <div class="carousel-track" id="carouselTrack">
                <div class="carousel-slide development">
                    <div class="carousel-slide-icon">
                        <i class="ni ni-setting-alt"></i>
                    </div>
                    <div class="carousel-slide-content">
                        <h6 class="carousel-slide-title">{{ __('Under Development') }}</h6>
                        <p class="carousel-slide-text">{{ __('This page is still being improved. Some features may change.') }}</p>
                    </div>
                </div>
                <div class="carousel-slide app-coming">
                    <div class="carousel-slide-icon">
                        <i class="ni ni-mobile"></i>
                    </div>
                    <div class="carousel-slide-content">
                        <h6 class="carousel-slide-title">{{ __('Mobile App Coming Soon!') }}</h6>
                        <p class="carousel-slide-text">{{ __('Stay tuned for our iOS and Android apps. Coming to App Store & Play Store!') }}</p>
                    </div>
                </div>
                <div class="carousel-slide phone-view">
                    <div class="carousel-slide-icon">
                        <i class="ni ni-mobile"></i>
                    </div>
                    <div class="carousel-slide-content">
                        <h6 class="carousel-slide-title">{{ __('Optimized for Mobile') }}</h6>
                        <p class="carousel-slide-text">{{ __('This platform is designed for phone view. For best experience, use on your mobile device.') }}</p>
                    </div>
                </div>
            </div>
            <div class="carousel-dots">
                <button class="carousel-dot active" onclick="goToSlide(0)" aria-label="Slide 1"></button>
                <button class="carousel-dot" onclick="goToSlide(1)" aria-label="Slide 2"></button>
                <button class="carousel-dot" onclick="goToSlide(2)" aria-label="Slide 3"></button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('after-script')
<script type="text/javascript">
    function updateTime() {
        var d = new Date();
        var hour = d.getHours();
        var minute = d.getMinutes();

        // Greeting based on time
        var greeting = hour < 12 ? '{{ __("Good Morning") }}' :
                       hour < 17 ? '{{ __("Good Afternoon") }}' :
                       '{{ __("Good Evening") }}';

        document.getElementById("greeting").innerHTML = greeting;

        // Format time
        hour = hour < 10 ? "0" + hour : hour;
        minute = minute < 10 ? "0" + minute : minute;
        document.getElementById("time").innerHTML = hour + ":" + minute;

        // Format date
        var options = { weekday: 'short', day: 'numeric', month: 'short' };
        document.getElementById("dates").innerHTML = d.toLocaleDateString(undefined, options);
    }

    updateTime();
    setInterval(updateTime, 1000);

    // Info Banner Carousel
    var currentSlide = 0;
    var totalSlides = 3;
    var autoSlideInterval;

    function goToSlide(index) {
        currentSlide = index;
        var track = document.getElementById('carouselTrack');
        track.style.transform = 'translateX(-' + (index * 100) + '%)';

        // Update dots
        var dots = document.querySelectorAll('.carousel-dot');
        dots.forEach(function(dot, i) {
            dot.classList.toggle('active', i === index);
        });

        // Reset auto-slide timer
        resetAutoSlide();
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        goToSlide(currentSlide);
    }

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(nextSlide, 5000);
    }

    // Start auto-slide
    resetAutoSlide();

    // Touch swipe support
    var carouselTrack = document.getElementById('carouselTrack');
    var touchStartX = 0;
    var touchEndX = 0;

    carouselTrack.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, false);

    carouselTrack.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);

    function handleSwipe() {
        var diff = touchStartX - touchEndX;
        if (Math.abs(diff) > 50) {
            if (diff > 0 && currentSlide < totalSlides - 1) {
                goToSlide(currentSlide + 1);
            } else if (diff < 0 && currentSlide > 0) {
                goToSlide(currentSlide - 1);
            }
        }
    }
</script>
@endpush
