<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="author" content="@yield('meta_author', 'Hannan Yusop')">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@@page-discription">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    @yield('meta')
    @stack('before-styles')
    <link rel="stylesheet" href={{ asset('assets/css/dashlite.css') }}?ver=1.4.0">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css') }}?ver=1.4.0">
    @livewireStyles
    @stack('after-styles')
</head>
