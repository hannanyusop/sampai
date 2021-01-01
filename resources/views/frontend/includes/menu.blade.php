<div class="nk-aside" data-content="sideNav" data-toggle-overlay="true" data-toggle-screen="lg" data-toggle-body="true">
    <div class="nk-sidebar-menu" data-simplebar>
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
                        <a href="{{ route('frontend.user.parcel.search') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Track Parcel</span>
                        </a>
                        <a href="{{ route('frontend.user.subscribe.index') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Mine</span>
                        </a>
                        <a href="{{ route('frontend.user.subscribe.create') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Subscribe</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="nk-aside-close">
        <a href="#" class="toggle" data-target="sideNav"><em class="icon ni ni-cross"></em></a>
    </div><!-- .nk-aside-close -->
</div><!-- .nk-aside -->
