<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="author" content="NUJ Express">

    <!-- OG Meta Tags -->
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
    <meta property="og:title" content="{{ env('APP_NAME') }}"/>
    <meta property="og:description" content="Track your parcels in real-time with NUJ Express" />
    <meta property="og:type" content="website" />

    <!-- Webpage Title -->
    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('landing/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/css/swiper.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/css/styles.css') }}" rel="stylesheet">

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Modern Header */
        .modern-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 16px 0;
            transition: all 0.3s ease;
            background: transparent;
        }

        .modern-header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            padding: 12px 0;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-logo img {
            height: 45px;
            width: auto;
            transition: all 0.3s ease;
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link-modern {
            padding: 10px 20px;
            font-size: 15px;
            font-weight: 500;
            color: #1a1a2e;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .nav-link-modern:hover {
            background: rgba(0, 198, 167, 0.1);
            color: #00c6a7;
            text-decoration: none;
        }

        .nav-btn {
            padding: 10px 24px;
            font-size: 15px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, #00c6a7 0%, #1ed5b9 100%);
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-left: 8px;
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 198, 167, 0.3);
            color: white;
            text-decoration: none;
        }

        /* Mobile Menu */
        .mobile-toggle {
            display: none;
            width: 44px;
            height: 44px;
            border: none;
            background: rgba(0, 198, 167, 0.1);
            border-radius: 10px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 5px;
        }

        .mobile-toggle span {
            display: block;
            width: 20px;
            height: 2px;
            background: #00c6a7;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            z-index: 999;
            padding: 100px 24px 40px;
            flex-direction: column;
            gap: 8px;
        }

        .mobile-menu.active {
            display: flex;
        }

        .mobile-menu .nav-link-modern {
            padding: 16px 20px;
            font-size: 18px;
            border-radius: 12px;
        }

        .mobile-menu .nav-btn {
            padding: 16px 24px;
            font-size: 18px;
            text-align: center;
            margin: 8px 0 0 0;
        }

        .mobile-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 44px;
            height: 44px;
            border: none;
            background: rgba(0, 198, 167, 0.1);
            border-radius: 10px;
            cursor: pointer;
            font-size: 24px;
            color: #00c6a7;
        }

        /* Modern Footer */
        .modern-footer {
            background: linear-gradient(135deg, #0a2520 0%, #0d3029 100%);
            padding: 80px 0 0;
            position: relative;
            overflow: hidden;
        }

        .modern-footer::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: rgba(0, 198, 167, 0.03);
            border-radius: 50%;
        }

        .modern-footer::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: rgba(0, 198, 167, 0.02);
            border-radius: 50%;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 60px;
            padding-bottom: 60px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            z-index: 1;
        }

        .footer-brand img {
            height: 50px;
            width: auto;
            margin-bottom: 20px;
        }

        .footer-brand p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 24px;
            max-width: 280px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .footer-social a {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .footer-social a:hover {
            background: #00c6a7;
            color: white;
            transform: translateY(-3px);
        }

        .footer-col h5 {
            color: white;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 14px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.6);
            font-size: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #00c6a7;
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 20px;
        }

        .footer-contact-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(0, 198, 167, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00c6a7;
            font-size: 16px;
            flex-shrink: 0;
        }

        .footer-contact-text h6 {
            color: white;
            font-size: 14px;
            font-weight: 600;
            margin: 0 0 4px 0;
        }

        .footer-contact-text a {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-contact-text a:hover {
            color: #00c6a7;
        }

        .footer-bottom {
            padding: 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 1;
        }

        .footer-bottom p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            margin: 0;
        }

        .footer-bottom-links {
            display: flex;
            gap: 24px;
        }

        .footer-bottom-links a {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-bottom-links a:hover {
            color: #00c6a7;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .header-nav {
                display: none;
            }

            .mobile-toggle {
                display: flex;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 40px;
            }
        }

        @media (max-width: 767px) {
            .modern-header {
                padding: 12px 0;
            }

            .modern-header.scrolled {
                padding: 10px 0;
            }

            .header-logo img {
                height: 38px;
            }

            .mobile-toggle {
                width: 40px;
                height: 40px;
            }

            .mobile-menu {
                padding: 80px 20px 30px;
            }

            .mobile-menu .nav-link-modern {
                padding: 14px 18px;
                font-size: 16px;
            }

            .mobile-menu .nav-btn {
                padding: 14px 20px;
                font-size: 16px;
            }

            .mobile-close {
                top: 16px;
                right: 16px;
                width: 40px;
                height: 40px;
            }

            .modern-footer {
                padding: 50px 0 0;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 32px;
                padding-bottom: 40px;
            }

            .footer-brand img {
                height: 40px;
                margin-bottom: 16px;
            }

            .footer-brand p {
                font-size: 14px;
                margin-bottom: 20px;
            }

            .footer-social a {
                width: 38px;
                height: 38px;
                font-size: 16px;
            }

            .footer-col h5 {
                font-size: 15px;
                margin-bottom: 16px;
            }

            .footer-links a {
                font-size: 14px;
            }

            .footer-links li {
                margin-bottom: 12px;
            }

            .footer-contact-item {
                margin-bottom: 16px;
            }

            .footer-contact-icon {
                width: 38px;
                height: 38px;
                font-size: 14px;
            }

            .footer-contact-text h6 {
                font-size: 13px;
            }

            .footer-contact-text a {
                font-size: 13px;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 12px;
                text-align: center;
                padding: 20px 0;
            }

            .footer-bottom p {
                font-size: 13px;
            }

            .footer-bottom-links {
                gap: 16px;
            }

            .footer-bottom-links a {
                font-size: 13px;
            }

            .footer-bottom-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<!-- Modern Header -->
<header class="modern-header" id="modernHeader">
    <div class="container">
        <div class="header-container">
            <a href="{{ route('frontend.index') }}" class="header-logo">
                <img src="{{ asset('images/logo.png') }}" alt="{{ env('APP_NAME') }}">
            </a>

            <nav class="header-nav">
                @if(auth()->user())
                    <a href="{{ route(homeRoute()) }}" class="nav-link-modern">Dashboard</a>
                    <a href="{{ route('frontend.auth.logout') }}" class="nav-link-modern">Log Out</a>
                @else
                    <a href="{{ route('frontend.index') }}" class="nav-link-modern">Home</a>
                    @if(trackEnabled())
                        <a href="{{ route('frontend.track') }}" class="nav-link-modern">Track</a>
                    @endif
                    <a href="{{ route('frontend.auth.login') }}" class="nav-link-modern">Login</a>
                    @if(registrationEnabled())
                        <a href="{{ route('frontend.auth.register') }}" class="nav-btn">Get Started</a>
                    @endif
                @endif
            </nav>

            <button class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <button class="mobile-close" id="mobileClose">&times;</button>
    @if(auth()->user())
        <a href="{{ route(homeRoute()) }}" class="nav-link-modern">Dashboard</a>
        <a href="{{ route('frontend.auth.logout') }}" class="nav-link-modern">Log Out</a>
    @else
        <a href="{{ route('frontend.index') }}" class="nav-link-modern">Home</a>
        @if(trackEnabled())
            <a href="{{ route('frontend.track') }}" class="nav-link-modern">Track</a>
        @endif
        <a href="{{ route('frontend.auth.login') }}" class="nav-link-modern">Login</a>
        @if(registrationEnabled())
            <a href="{{ route('frontend.auth.register') }}" class="nav-btn">Get Started</a>
        @endif
    @endif
</div>

@yield('content')

<!-- Modern Footer -->
<footer class="modern-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand -->
            <div class="footer-brand">
                <img src="{{ asset('images/logo.png') }}" alt="{{ env('APP_NAME') }}">
                <p>NUJ Express provides seamless parcel tracking and delivery management for sellers and customers in Brunei.</p>
                <div class="footer-social">
                    <a href="https://wa.me/6738921454" title="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-col">
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('frontend.index') }}">Home</a></li>
                    @if(trackEnabled())
                        <li><a href="{{ route('frontend.track') }}">Track Parcel</a></li>
                    @endif
                    @if(!auth()->user())
                        <li><a href="{{ route('frontend.auth.login') }}">Login</a></li>
                        @if(registrationEnabled())
                            <li><a href="{{ route('frontend.auth.register') }}">Register</a></li>
                        @endif
                    @else
                        <li><a href="{{ route(homeRoute()) }}">Dashboard</a></li>
                    @endif
                </ul>
            </div>

            <!-- Legal -->
            <div class="footer-col">
                <h5>Legal</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('frontend.pages.terms') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('frontend.pages.terms') }}">Terms of Service</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="footer-col">
                <h5>Contact Us</h5>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="footer-contact-text">
                        <h6>Lambak Branch</h6>
                        <a href="https://wa.me/6738921454">+673 892 1454</a>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="footer-contact-text">
                        <h6>Kilanas Branch</h6>
                        <a href="https://wa.me/6738815404">+673 881 5404</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} NUJ Express. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="{{ route('frontend.pages.terms') }}">Privacy</a>
                <a href="{{ route('frontend.pages.terms') }}">Terms</a>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('landing/js/jquery.min.js') }}"></script>
<script src="{{ asset('landing/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('landing/js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('landing/js/swiper.min.js') }}"></script>
<script src="{{ asset('landing/js/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('landing/js/morphext.min.js') }}"></script>
<script src="{{ asset('landing/js/validator.min.js') }}"></script>
<script src="{{ asset('landing/js/scripts.js') }}"></script>

<script>
    // Header scroll effect
    window.addEventListener('scroll', function() {
        const header = document.getElementById('modernHeader');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Mobile menu
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileClose = document.getElementById('mobileClose');

    mobileToggle.addEventListener('click', function() {
        mobileMenu.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    mobileClose.addEventListener('click', function() {
        mobileMenu.classList.remove('active');
        document.body.style.overflow = '';
    });

    // Close menu on link click
    mobileMenu.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function() {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });
    });
</script>
</body>
</html>
