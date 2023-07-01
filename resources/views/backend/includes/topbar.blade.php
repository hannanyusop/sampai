
<div class="nk-header-tools">
    <ul class="nk-quick-nav">
        <li class="dropdown notification-dropdown">
            <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown">
                <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1">
                <div class="dropdown-head">
                    <span class="sub-title nk-dropdown-title">Notifications</span>
                </div>
                <div class="dropdown-body">
                    @include('includes.partials.announcements')
                </div><!-- .nk-dropdown-body -->
            </div>
        </li><!-- .dropdown -->
        <li class="hide-mb-sm"><a href="{{ route('frontend.auth.logout') }}" class="nk-quick-nav-icon"><em class="icon ni ni-signout"></em></a></li>
        <li class="dropdown user-dropdown order-sm-first">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <div class="user-toggle">
                    <div class="user-avatar sm">
                        <em class="icon ni ni-user-alt"></em>
                    </div>
                    <div class="user-info d-none d-xl-block">
                        <div class="user-status user-status-unverified">{{ auth()->user()->role }}</div>
                        <div class="user-name dropdown-indicator">{{ auth()->user()->name }}</div>
                    </div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropd🥺own-menu-right dropdown-menu-s1 is-light">
                <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                    <div class="user-card">
                        <div class="user-avatar">
                            <span>AB</span>
                        </div>
                        <div class="user-info">
                            <span class="lead-text">{{ auth()->user()->name }}</span>
                            <span class="sub-text">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="user-action">
                            <a class="btn btn-icon mr-n2" href="#"><em class="icon ni ni-setting"></em></a>
                        </div>
                    </div>
                </div>
                <div class="dropdown-inner">
                    <ul class="link-list">
                        <li><a href="{{ route('frontend.user.account') }}"><em class="icon ni ni-setting-alt"></em><span>Update Information</span></a></li>
                    </ul>
                </div>
                <div class="dropdown-inner">
                    <ul class="link-list">
                        <li><a href="{{ route('frontend.auth.logout') }}"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                    </ul>
                </div>
            </div>
        </li><!-- .dropdown -->
    </ul><!-- .nk-quick-nav -->
</div><!-- .nk-header-tools -->

