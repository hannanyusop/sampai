<!DOCTYPE html>
<html lang="eb" class="js">

@include('frontend.includes.header1')

<body class="nk-body npc-subscription has-aside ui-clean ">
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap ">
            @include('frontend.includes.topbar')
            <div class="nk-content ">
                <div class="container wide-xl">
                    <div class="nk-content-inner">
                        @include('frontend.includes.menu')
                        <div class="nk-content-body">
                            @include('includes.partials.messages')
                            @include('includes.partials.logged-in-as')
                            @yield('content')

                            @include('frontend.includes.footer')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="{{ asset('assets/js/charts/gd-general.js') }}?ver=1.4.0"></script>
</html>
