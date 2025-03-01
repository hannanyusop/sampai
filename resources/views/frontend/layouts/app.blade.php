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
            <div class="nk-content">
                <div class="nk-content-inner p-3">
                    <div class="nk-content-body">
                        @include('includes.partials.messages')
                        @include('includes.partials.logged-in-as')
                        <div class="mb-5">
                            @yield('content')
                        </div>


                        <div class="fixed-bottom  p-3"> <!-- Applies fixed positioning at bottom for mobile only -->
                            <a href="{{ route('frontend.user.dashboard') }}" class="btn btn-secondary btn-md btn-block">
                                Back To Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@livewireScripts
@stack('after-script')
</html>
