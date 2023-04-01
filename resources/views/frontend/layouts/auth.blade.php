<!doctype html>
<html lang="{{ htmlLang() }}">
<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="author" content="@yield('meta_author', 'Hannan Yusop')">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Courier service for parcel forwarding from Malaysia to Brunei.
     Fast, secure, and affordable shipping for individuals and businesses. Flexible shipping options with online tracking and insurance. Exceptional customer service. Start shipping today!">
    <meta property="og:image" content="{{ asset('images/cover.png') }}" />
    <meta property="og:image:secure_url" content="{{ asset('images/cover.png') }}" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    @yield('meta')
    @stack('before-styles')
    <link rel="stylesheet" href={{ asset('assets/css/dashlite.css') }}?ver=1.4.0">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css') }}?ver=1.4.0">
    @stack('after-styles')
</head>

<body class="nk-body npc-crypto ui-clean pg-auth">
<div class="nk-app-root">
    <div class="nk-split nk-split-page nk-split-md">
        @yield('content')
    </div><!-- .nk-split -->
</div>
@stack('before-scripts')
    <script src=".{{ asset('assets/js/bundle.js') }}?ver=1.4.0"></script>
    <script src=".{{ asset('assets/js/scripts.js') }}?ver=1.4.0"></script>
@stack('after-scripts')

</body>

</html>
