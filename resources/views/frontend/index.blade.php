@extends('frontend.layouts.landing')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .gradient-text {
        background: linear-gradient(135deg, #00c6a7 0%, #1ed5b9 50%, #6ee7c2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .gradient-bg {
        background: linear-gradient(135deg, #00c6a7 0%, #1ed5b9 50%, #6ee7c2 100%);
    }

    .gradient-border {
        position: relative;
        background: white;
        border-radius: 20px;
    }

    .gradient-border::before {
        content: '';
        position: absolute;
        inset: 0;
        padding: 2px;
        border-radius: 20px;
        background: linear-gradient(135deg, #00c6a7 0%, #1ed5b9 50%, #6ee7c2 100%);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
    }

    /* Hero */
    .hero-section {
        min-height: 100vh;
        background: #fafffe;
        display: flex;
        align-items: center;
        padding: 120px 0 80px;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -200px;
        right: -200px;
        width: 600px;
        height: 600px;
        background: linear-gradient(135deg, rgba(0, 198, 167, 0.08) 0%, rgba(110, 231, 194, 0.05) 100%);
        border-radius: 50%;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, rgba(0, 198, 167, 0.05) 0%, rgba(110, 231, 194, 0.03) 100%);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: linear-gradient(135deg, rgba(0, 198, 167, 0.1) 0%, rgba(110, 231, 194, 0.1) 100%);
        border-radius: 100px;
        font-size: 14px;
        font-weight: 600;
        color: #00c6a7;
        margin-bottom: 24px;
    }

    .hero-title {
        font-size: 56px;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1.1;
        margin-bottom: 24px;
        letter-spacing: -1px;
    }

    .hero-subtitle {
        font-size: 18px;
        color: #6b7280;
        line-height: 1.7;
        margin-bottom: 40px;
        max-width: 480px;
    }

    .hero-buttons {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .btn-gradient {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 32px;
        background: linear-gradient(135deg, #00c6a7 0%, #1ed5b9 100%);
        color: white;
        font-size: 16px;
        font-weight: 600;
        border-radius: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 10px 40px rgba(0, 198, 167, 0.3);
    }

    .btn-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 50px rgba(0, 198, 167, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-light {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 32px;
        background: white;
        color: #1a1a2e;
        font-size: 16px;
        font-weight: 600;
        border-radius: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid #e5e7eb;
    }

    .btn-light:hover {
        border-color: #00c6a7;
        color: #00c6a7;
        text-decoration: none;
    }

    .hero-image {
        position: relative;
        z-index: 2;
    }

    .hero-image-wrapper {
        position: relative;
        padding: 40px;
    }

    .hero-image-wrapper img {
        max-width: 100%;
        height: auto;
        filter: drop-shadow(0 20px 40px rgba(0, 198, 167, 0.15));
    }

    .floating-badge {
        position: absolute;
        background: white;
        padding: 16px 24px;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 12px;
        animation: floatBadge 4s ease-in-out infinite;
    }

    .floating-badge.top {
        top: 20px;
        right: 0;
    }

    .floating-badge.bottom {
        bottom: 40px;
        left: 0;
        animation-delay: 2s;
    }

    .floating-badge-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .floating-badge-icon.green {
        background: linear-gradient(135deg, rgba(0, 198, 167, 0.15) 0%, rgba(110, 231, 194, 0.15) 100%);
        color: #00c6a7;
    }

    .floating-badge h6 {
        font-size: 14px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .floating-badge span {
        font-size: 12px;
        color: #9ca3af;
    }

    @keyframes floatBadge {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }

    /* Stats */
    .stats-section {
        padding: 80px 0;
        background: white;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }

    .stat-card {
        text-align: center;
        padding: 32px 24px;
        border-radius: 20px;
        background: linear-gradient(135deg, #fafffe 0%, #f0fdf9 100%);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 198, 167, 0.1);
    }

    .stat-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 20px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        background: linear-gradient(135deg, #00c6a7 0%, #1ed5b9 100%);
        color: white;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
    }

    /* Process */
    .process-section {
        padding: 100px 0;
        background: #fafffe;
    }

    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-tag {
        display: inline-block;
        padding: 8px 20px;
        background: linear-gradient(135deg, rgba(0, 198, 167, 0.1) 0%, rgba(110, 231, 194, 0.1) 100%);
        border-radius: 100px;
        font-size: 13px;
        font-weight: 700;
        color: #00c6a7;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 42px;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 16px;
        letter-spacing: -0.5px;
    }

    .section-desc {
        font-size: 18px;
        color: #6b7280;
        max-width: 500px;
        margin: 0 auto;
    }

    .process-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        position: relative;
    }

    .process-grid::before {
        content: '';
        position: absolute;
        top: 60px;
        left: 15%;
        right: 15%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #00c6a7, #1ed5b9, #6ee7c2, transparent);
        opacity: 0.3;
    }

    .process-card {
        text-align: center;
        padding: 40px 24px;
        background: white;
        border-radius: 24px;
        position: relative;
        transition: all 0.3s ease;
    }

    .process-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0, 198, 167, 0.12);
    }

    .process-number {
        width: 48px;
        height: 48px;
        margin: 0 auto 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00c6a7 0%, #1ed5b9 100%);
        color: white;
        font-size: 18px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
    }

    .process-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 20px;
        border-radius: 20px;
        background: linear-gradient(135deg, #fafffe 0%, #f0fdf9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #00c6a7;
    }

    .process-card h4 {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 12px;
    }

    .process-card p {
        font-size: 14px;
        color: #6b7280;
        line-height: 1.6;
        margin: 0;
    }

    /* Features */
    .features-section {
        padding: 100px 0;
        background: white;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .feature-card {
        padding: 36px;
        background: #fafffe;
        border-radius: 24px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .feature-card:hover {
        background: white;
        border-color: rgba(0, 198, 167, 0.2);
        box-shadow: 0 20px 40px rgba(0, 198, 167, 0.08);
        transform: translateY(-5px);
    }

    .feature-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #00c6a7 0%, #1ed5b9 100%);
        color: white;
    }

    .feature-card h4 {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 12px;
    }

    .feature-card p {
        font-size: 15px;
        color: #6b7280;
        line-height: 1.6;
        margin: 0;
    }

    /* Locations */
    .locations-section {
        padding: 100px 0;
        background: #fafffe;
    }

    .location-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        max-width: 800px;
        margin: 0 auto;
    }

    .location-card {
        padding: 40px;
        background: white;
        border-radius: 24px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid #f0fdf9;
    }

    .location-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 198, 167, 0.1);
    }

    .location-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00c6a7 0%, #1ed5b9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: white;
    }

    .location-card h4 {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 8px;
    }

    .location-card .type {
        font-size: 14px;
        color: #9ca3af;
        margin-bottom: 24px;
    }

    .btn-whatsapp {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        background: #25d366;
        color: white;
        font-size: 15px;
        font-weight: 600;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-whatsapp:hover {
        background: #1fb855;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    /* CTA */
    .cta-section {
        padding: 100px 0;
        background: linear-gradient(135deg, #00c6a7 0%, #1ed5b9 50%, #6ee7c2 100%);
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .cta-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .cta-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .cta-title {
        font-size: 42px;
        font-weight: 800;
        color: white;
        margin-bottom: 16px;
    }

    .cta-desc {
        font-size: 18px;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 32px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-white {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 18px 36px;
        background: white;
        color: #00c6a7;
        font-size: 16px;
        font-weight: 700;
        border-radius: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .btn-white:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        color: #00c6a7;
        text-decoration: none;
    }

    /* Track */
    .track-section {
        padding: 80px 0;
        background: white;
        text-align: center;
    }

    .track-section h2 {
        font-size: 32px;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 16px;
    }

    .track-section p {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 24px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .hero-title {
            font-size: 46px;
        }
    }

    @media (max-width: 991px) {
        .hero-section {
            padding: 100px 0 60px;
        }
        .hero-title {
            font-size: 38px;
        }
        .hero-image {
            margin-top: 50px;
        }
        .floating-badge {
            display: none;
        }
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .process-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .process-grid::before {
            display: none;
        }
        .features-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .section-title {
            font-size: 32px;
        }
    }

    @media (max-width: 767px) {
        .hero-section {
            padding: 90px 0 50px;
            min-height: auto;
        }
        .hero-section::before,
        .hero-section::after {
            display: none;
        }
        .hero-title {
            font-size: 28px;
            margin-bottom: 16px;
        }
        .hero-subtitle {
            font-size: 15px;
            margin-bottom: 28px;
        }
        .hero-tag {
            font-size: 12px;
            padding: 8px 14px;
            margin-bottom: 16px;
        }
        .hero-buttons {
            flex-direction: column;
            gap: 12px;
        }
        .hero-buttons a {
            width: 100%;
            justify-content: center;
            padding: 14px 24px;
            font-size: 15px;
        }
        .hero-image-wrapper {
            padding: 20px;
        }
        .hero-image-wrapper img {
            max-width: 180px;
            margin: 0 auto;
            display: block;
        }

        .stats-section {
            padding: 50px 0;
        }
        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .stat-card {
            padding: 20px 12px;
            border-radius: 16px;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
            border-radius: 12px;
            margin-bottom: 14px;
        }
        .stat-value {
            font-size: 24px;
            margin-bottom: 4px;
        }
        .stat-label {
            font-size: 12px;
        }

        .process-section,
        .features-section,
        .locations-section {
            padding: 60px 0;
        }
        .section-header {
            margin-bottom: 40px;
        }
        .section-tag {
            font-size: 11px;
            padding: 6px 14px;
            margin-bottom: 14px;
        }
        .section-title {
            font-size: 24px;
            margin-bottom: 12px;
        }
        .section-desc {
            font-size: 15px;
        }

        .process-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .process-card {
            padding: 28px 20px;
            border-radius: 16px;
        }
        .process-number {
            width: 40px;
            height: 40px;
            font-size: 16px;
            margin-bottom: 16px;
        }
        .process-icon {
            width: 60px;
            height: 60px;
            font-size: 24px;
            border-radius: 16px;
            margin-bottom: 14px;
        }
        .process-card h4 {
            font-size: 16px;
            margin-bottom: 8px;
        }
        .process-card p {
            font-size: 13px;
        }

        .features-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }
        .feature-card {
            padding: 24px 20px;
            border-radius: 16px;
        }
        .feature-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
            border-radius: 12px;
            margin-bottom: 16px;
        }
        .feature-card h4 {
            font-size: 16px;
            margin-bottom: 8px;
        }
        .feature-card p {
            font-size: 14px;
        }

        .location-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .location-card {
            padding: 28px 20px;
            border-radius: 16px;
        }
        .location-icon {
            width: 64px;
            height: 64px;
            font-size: 26px;
            margin-bottom: 18px;
        }
        .location-card h4 {
            font-size: 18px;
            margin-bottom: 6px;
        }
        .location-card .type {
            font-size: 13px;
            margin-bottom: 18px;
        }
        .btn-whatsapp {
            padding: 12px 22px;
            font-size: 14px;
            border-radius: 10px;
        }

        .cta-section {
            padding: 60px 0;
        }
        .cta-section::before,
        .cta-section::after {
            display: none;
        }
        .cta-title {
            font-size: 22px;
            margin-bottom: 12px;
        }
        .cta-desc {
            font-size: 15px;
            margin-bottom: 24px;
        }
        .btn-white {
            padding: 14px 28px;
            font-size: 15px;
            border-radius: 10px;
        }

        .track-section {
            padding: 50px 0;
        }
        .track-section h2 {
            font-size: 22px;
            margin-bottom: 12px;
        }
        .track-section p {
            font-size: 14px;
            margin-bottom: 20px;
        }
    }

    @media (max-width: 375px) {
        .hero-title {
            font-size: 24px;
        }
        .hero-subtitle {
            font-size: 14px;
        }
        .stat-value {
            font-size: 20px;
        }
        .section-title {
            font-size: 22px;
        }
        .cta-title {
            font-size: 20px;
        }
    }
</style>

<!-- Hero -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <div class="hero-tag">
                        <i class="fas fa-bolt"></i>
                        Fast & Reliable Service
                    </div>
                    <h1 class="hero-title">
                        Parcel Tracking<br>
                        <span class="gradient-text">Made Simple</span>
                    </h1>
                    <p class="hero-subtitle">
                        Track your parcels in real-time with NUJ Express. Fast delivery, instant notifications, and seamless management for sellers and customers.
                    </p>
                    <div class="hero-buttons">
                        @if(!auth()->user())
                            <a href="{{ route('frontend.auth.login') }}" class="btn-gradient">
                                <i class="fas fa-arrow-right"></i>
                                Get Started
                            </a>
                            @if(registrationEnabled())
                                <a href="{{ route('frontend.auth.register') }}" class="btn-light">
                                    <i class="fas fa-user-plus"></i>
                                    Create Account
                                </a>
                            @endif
                        @else
                            <a href="{{ route(homeRoute()) }}" class="btn-gradient">
                                <i class="fas fa-th-large"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('frontend.auth.logout') }}" class="btn-light">
                                <i class="fas fa-sign-out-alt"></i>
                                Log Out
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <div class="hero-image-wrapper">
                        <img src="{{ asset('images/logo.png') }}" alt="NUJ Express">
                        <div class="floating-badge top">
                            <div class="floating-badge-icon green">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h6>Delivered</h6>
                                <span>Just now</span>
                            </div>
                        </div>
                        <div class="floating-badge bottom">
                            <div class="floating-badge-icon green">
                                <i class="fas fa-box"></i>
                            </div>
                            <div>
                                <h6>Ready for Pickup</h6>
                                <span>3 parcels</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-value">10K+</div>
                <div class="stat-label">Parcels Handled</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stat-value">500+</div>
                <div class="stat-label">Active Sellers</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="stat-value">2</div>
                <div class="stat-label">Locations</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">24/7</div>
                <div class="stat-label">Online Tracking</div>
            </div>
        </div>
    </div>
</section>

<!-- Process -->
<section class="process-section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">How It Works</div>
            <h2 class="section-title">Simple Process</h2>
            <p class="section-desc">From arrival to pickup in 4 easy steps</p>
        </div>
        <div class="process-grid">
            <div class="process-card">
                <div class="process-number">1</div>
                <div class="process-icon">
                    <i class="fas fa-plane-arrival"></i>
                </div>
                <h4>Parcel Arrives</h4>
                <p>Your parcel arrives at our collection point</p>
            </div>
            <div class="process-card">
                <div class="process-number">2</div>
                <div class="process-icon">
                    <i class="fas fa-barcode"></i>
                </div>
                <h4>Scan & Log</h4>
                <p>We scan and log into our system</p>
            </div>
            <div class="process-card">
                <div class="process-number">3</div>
                <div class="process-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <h4>Get Notified</h4>
                <p>Receive instant SMS notification</p>
            </div>
            <div class="process-card">
                <div class="process-number">4</div>
                <div class="process-icon">
                    <i class="fas fa-hand-holding-box"></i>
                </div>
                <h4>Collect</h4>
                <p>Pick up at your nearest location</p>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features-section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">Features</div>
            <h2 class="section-title">Everything You Need</h2>
            <p class="section-desc">Powerful tools for seamless parcel management</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-satellite-dish"></i>
                </div>
                <h4>Real-Time Tracking</h4>
                <p>Track your parcels 24/7 with live status updates and instant visibility.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h4>SMS Alerts</h4>
                <p>Automatic notifications keep customers informed instantly.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <h4>Seller Dashboard</h4>
                <p>Manage all orders in one place with powerful analytics.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-file-upload"></i>
                </div>
                <h4>Bulk Import</h4>
                <p>Upload hundreds of orders at once using Excel templates.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h4>Analytics</h4>
                <p>Detailed reports on deliveries and performance metrics.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>Secure</h4>
                <p>Full accountability with digital proof of delivery.</p>
            </div>
        </div>
    </div>
</section>

<!-- Locations -->
<section class="locations-section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">Locations</div>
            <h2 class="section-title">Pickup Points</h2>
            <p class="section-desc">Convenient locations to collect your parcels</p>
        </div>
        <div class="location-grid">
            <div class="location-card">
                <div class="location-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h4>Lambak Branch</h4>
                <p class="type">Main Collection Point</p>
                <a href="https://wa.me/6738921454" class="btn-whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    +673 892 1454
                </a>
            </div>
            <div class="location-card">
                <div class="location-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h4>Kilanas Branch</h4>
                <p class="type">Secondary Collection Point</p>
                <a href="https://wa.me/6738815404" class="btn-whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    +673 881 5404
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Ready to get started?</h2>
            <p class="cta-desc">Join hundreds of sellers who trust NUJ Express for reliable parcel management.</p>
            @if(!auth()->user())
                @if(registrationEnabled())
                    <a href="{{ route('frontend.auth.register') }}" class="btn-white">
                        <i class="fas fa-rocket"></i>
                        Start Free
                    </a>
                @else
                    <a href="{{ route('frontend.auth.login') }}" class="btn-white">
                        <i class="fas fa-arrow-right"></i>
                        Login Now
                    </a>
                @endif
            @else
                <a href="{{ route(homeRoute()) }}" class="btn-white">
                    <i class="fas fa-th-large"></i>
                    Go to Dashboard
                </a>
            @endif
        </div>
    </div>
</section>

@if(trackEnabled())
<!-- Track -->
<section class="track-section">
    <div class="container">
        <h2>Track Your Parcel</h2>
        <p>Enter your tracking number to check status instantly</p>
        <a href="{{ route('frontend.track') }}" class="btn-gradient">
            <i class="fas fa-search"></i>
            Track Now
        </a>
    </div>
</section>
@endif

@endsection
