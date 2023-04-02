<div class="nk-aside" data-content="sideNav" data-toggle-overlay="true" data-toggle-screen="lg" data-toggle-body="true">
    <div class="nk-sidebar-menu" data-simplebar>

        <div class="user-account-info between-center text-center">
            <div class="user-account-main">
                <h6 class="overline-title-alt">Date & Time</h6>
                <div class="user-balance" id="time"></div>
                <div class="user-balance-alt" id="dates"> </div>
            </div>
        </div>
        <!-- Menu -->
        <ul class="nk-menu">
            <li class="nk-menu-heading">
                <h6 class="overline-title">Menu</h6>
            </li>
            <li class="nk-menu-item">
                <a href="{{ route('frontend.user.dashboard') }}" class="nk-menu-link">
                    <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                    <span class="nk-menu-text">Dashboard</span>
                </a>
            </li>
            <li class="nk-menu-item">
                <a href="#" class="nk-menu-link">
                    <span class="nk-menu-icon"><em class="icon ni ni-tags"></em></span>
                    <span class="nk-menu-text">Parcel Management</span>
                </a>
                <ul class="nk-menu-sub">
                    <li class="nk-menu-item">
                        <a href="{{ route('frontend.user.parcel.create') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Add Parcel</span>
                        </a>
                        <a href="{{ route('frontend.user.parcel.index') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Parcel List</span>
                        </a>
                        <a href="{{ route('frontend.user.pickup.index') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Pickup List</span>
                        </a>
                    </li>
                </ul>
            </li>
{{--            <li class="nk-menu-item">--}}
{{--                <a href="{{ route('frontend.user.wallet.index') }}" class="nk-menu-link">--}}
{{--                    <span class="nk-menu-icon"><em class="icon ni ni-wallet"></em></span>--}}
{{--                    <span class="nk-menu-text">Wallet</span>--}}
{{--                </a>--}}
{{--            </li>--}}
        </ul>
    </div>
    <div class="nk-aside-close">
        <a href="#" class="toggle" data-target="sideNav"><em class="icon ni ni-cross"></em></a>
    </div><!-- .nk-aside-close -->
</div><!-- .nk-aside -->
