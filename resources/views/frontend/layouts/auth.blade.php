<!doctype html>
<html lang="{{ htmlLang() }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="author" content="@yield('meta_author', 'NUJ Express')">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="NUJ Express - Fast, secure parcel tracking and delivery service in Brunei.">
    <meta property="og:image" content="{{ asset('images/cover.png') }}" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    @include('includes.pwa')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('landing/css/fontawesome-all.css') }}" rel="stylesheet">

    @yield('meta')
    @stack('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css') }}?ver=1.4.0">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css') }}?ver=1.4.0">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* Left Panel - Branding */
        .auth-brand-panel {
            width: 45%;
            background: linear-gradient(135deg, #0a2520 0%, #0d3029 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .auth-brand-panel::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: rgba(0, 198, 167, 0.08);
            border-radius: 50%;
        }

        .auth-brand-panel::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: rgba(0, 198, 167, 0.05);
            border-radius: 50%;
        }

        .auth-brand-content {
            position: relative;
            z-index: 1;
        }

        .auth-brand-logo img {
            height: 60px;
            width: auto;
            margin-bottom: 60px;
        }

        .auth-brand-title {
            font-size: 42px;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            margin-bottom: 24px;
        }

        .auth-brand-title span {
            background: linear-gradient(135deg, #00c6a7 0%, #6ee7c2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-brand-desc {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
            max-width: 400px;
        }

        .auth-brand-features {
            position: relative;
            z-index: 1;
            margin-top: 60px;
        }

        .auth-feature-item {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .auth-feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(0, 198, 167, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00c6a7;
            font-size: 20px;
        }

        .auth-feature-text h6 {
            color: white;
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 4px 0;
        }

        .auth-feature-text p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            margin: 0;
        }

        .auth-brand-footer {
            position: relative;
            z-index: 1;
        }

        .auth-brand-footer p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            margin: 0;
        }

        /* Right Panel - Form */
        .auth-form-panel {
            width: 55%;
            background: #fafffe;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
        }

        .auth-form-container {
            width: 100%;
            max-width: 440px;
        }

        .auth-form-header {
            margin-bottom: 40px;
        }

        .auth-form-header h1 {
            font-size: 32px;
            font-weight: 800;
            color: #1a1a2e;
            margin: 0 0 12px 0;
        }

        .auth-form-header p {
            font-size: 16px;
            color: #6b7280;
            margin: 0;
        }

        .auth-form-body {
            background: white;
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        }

        .form-group-modern {
            margin-bottom: 24px;
        }

        .form-label-modern {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-label-modern label {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a2e;
            margin: 0;
        }

        .form-label-modern a {
            font-size: 13px;
            color: #00c6a7;
            text-decoration: none;
            font-weight: 500;
        }

        .form-label-modern a:hover {
            text-decoration: underline;
        }

        .form-input-modern {
            width: 100%;
            padding: 14px 18px;
            font-size: 15px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            background: #fafffe;
            transition: all 0.3s ease;
            color: #1a1a2e;
        }

        .form-input-modern:focus {
            outline: none;
            border-color: #00c6a7;
            background: white;
            box-shadow: 0 0 0 4px rgba(0, 198, 167, 0.1);
        }

        .form-input-modern::placeholder {
            color: #9ca3af;
        }

        .form-check-modern {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-check-modern input[type="checkbox"],
        .form-check-modern input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #00c6a7;
            cursor: pointer;
        }

        .form-check-modern label {
            font-size: 14px;
            color: #6b7280;
            cursor: pointer;
            margin: 0;
        }

        .form-check-modern a {
            color: #00c6a7;
            text-decoration: none;
        }

        .form-check-modern a:hover {
            text-decoration: underline;
        }

        .btn-auth {
            width: 100%;
            padding: 16px 24px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, #00c6a7 0%, #1ed5b9 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 198, 167, 0.3);
        }

        .auth-form-footer {
            text-align: center;
            margin-top: 32px;
        }

        .auth-form-footer p {
            font-size: 15px;
            color: #6b7280;
            margin: 0;
        }

        .auth-form-footer a {
            color: #00c6a7;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-form-footer a:hover {
            text-decoration: underline;
        }

        .form-error {
            color: #ef4444;
            font-size: 13px;
            margin-top: 8px;
            display: block;
        }

        .alert-modern {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .alert-modern.error {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .form-note {
            font-size: 13px;
            color: #00c6a7;
            margin-top: 8px;
            display: block;
        }

        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: #fafffe;
            padding: 16px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }

        .radio-item:hover {
            border-color: rgba(0, 198, 167, 0.3);
        }

        .radio-item input:checked + .radio-label {
            color: #00c6a7;
            font-weight: 600;
        }

        .radio-label {
            font-size: 14px;
            color: #1a1a2e;
            margin: 0;
        }

        /* Tablet */
        @media (max-width: 991px) {
            .auth-wrapper {
                flex-direction: column;
            }

            .auth-brand-panel {
                width: 100%;
                padding: 40px 24px;
                min-height: auto;
            }

            .auth-brand-title {
                font-size: 28px;
            }

            .auth-brand-features {
                display: none;
            }

            .auth-form-panel {
                width: 100%;
                padding: 40px 24px;
            }

            .auth-form-body {
                padding: 28px;
            }
        }

        /* Mobile */
        @media (max-width: 767px) {
            .auth-wrapper {
                flex-direction: column;
                min-height: 100vh;
            }

            .auth-brand-panel {
                width: 100%;
                padding: 24px 20px;
                min-height: auto;
            }

            .auth-brand-panel::before,
            .auth-brand-panel::after {
                display: none;
            }

            .auth-brand-logo img {
                height: 45px;
                margin-bottom: 20px;
            }

            .auth-brand-title {
                font-size: 24px;
                margin-bottom: 12px;
            }

            .auth-brand-desc {
                font-size: 14px;
                display: none;
            }

            .auth-brand-features {
                display: none;
            }

            .auth-brand-footer {
                display: none;
            }

            .auth-form-panel {
                width: 100%;
                padding: 24px 20px 40px;
                flex: 1;
            }

            .auth-form-container {
                max-width: 100%;
            }

            .auth-form-header {
                margin-bottom: 24px;
                text-align: center;
            }

            .auth-form-header h1 {
                font-size: 24px;
                margin-bottom: 8px;
            }

            .auth-form-header p {
                font-size: 14px;
            }

            .auth-form-body {
                padding: 24px 20px;
                border-radius: 16px;
            }

            .form-group-modern {
                margin-bottom: 20px;
            }

            .form-label-modern {
                margin-bottom: 8px;
            }

            .form-label-modern label {
                font-size: 13px;
            }

            .form-label-modern a {
                font-size: 12px;
            }

            .form-input-modern {
                padding: 14px 16px;
                font-size: 16px;
                border-radius: 10px;
            }

            .radio-group {
                padding: 12px;
                gap: 8px;
            }

            .radio-item {
                padding: 12px 14px;
                border-radius: 8px;
            }

            .radio-label {
                font-size: 13px;
            }

            .form-check-modern label {
                font-size: 13px;
            }

            .form-note {
                font-size: 12px;
            }

            .btn-auth {
                padding: 16px 20px;
                font-size: 15px;
                border-radius: 10px;
            }

            .auth-form-footer {
                margin-top: 24px;
            }

            .auth-form-footer p {
                font-size: 14px;
            }

            .form-error {
                font-size: 12px;
            }

            .alert-modern {
                padding: 12px 14px;
                font-size: 13px;
                border-radius: 10px;
            }
        }

        /* Small Mobile */
        @media (max-width: 375px) {
            .auth-brand-panel {
                padding: 20px 16px;
            }

            .auth-brand-logo img {
                height: 40px;
            }

            .auth-brand-title {
                font-size: 20px;
            }

            .auth-form-panel {
                padding: 20px 16px 32px;
            }

            .auth-form-header h1 {
                font-size: 22px;
            }

            .auth-form-body {
                padding: 20px 16px;
            }

            .form-input-modern {
                padding: 12px 14px;
            }

            .btn-auth {
                padding: 14px 18px;
            }
        }
    </style>
    @stack('after-styles')
</head>

<body>
    @yield('content')

    @stack('before-scripts')
    <script src="{{ asset('assets/js/bundle.js') }}?ver=1.4.0"></script>
    <script src="{{ asset('assets/js/scripts.js') }}?ver=1.4.0"></script>
    @stack('after-scripts')
</body>
</html>
