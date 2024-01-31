<div class="nk-header-menu" data-content="headerNav">
    <div class="nk-header-mobile">
        <div class="nk-header-brand">
            <a href="{{ route(homeRoute()) }}" class="logo-link">
                <img class="logo-light logo-img" src="{{ asset('images/logo.png') }}"  alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('images/logo-dark.png') }}" alt="logo-dark">
                <span class="nio-version">Admin Panel</span>
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
        </div>
    </div>
    <!-- Menu -->
    <ul class="nk-menu nk-menu-main">

        <li class="nk-menu-item">
            <a href="{{ route('admin.dashboard') }}" class="nk-menu-link">
                <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                <span class="nk-menu-text">Dashboard</span>
            </a>
        </li>
        <li class="nk-menu-item has-sub">
            <a href="#" class="nk-menu-link nk-menu-toggle">
                <span class="nk-menu-text">Trip Management</span>
            </a>
            <ul class="nk-menu-sub">
                <li class="nk-menu-item">
                    <a href="{{ route('admin.tripBatch.index') }}" class="nk-menu-link">
                        <span class="nk-menu-text">Trip List</span>
                    </a>
                </li>
                @if($logged_in_user->can('admin.trip.open'))
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.tripBatch.create') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Create Trip</span>
                        </a>
                    </li>
                @endif
            @if($logged_in_user->can('staff.inhouse') && auth()->user()->office_id != 0)
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.trip.receive') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Receive Trip</span>
                        </a>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.parcel.scan') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Scan User QRCode</span>
                        </a>
                    </li>
                @endif
                @if($logged_in_user->can('staff.runner'))

                @endif
                <li class="nk-menu-item">
                    <a href="{{ route('admin.parcel.index') }}" class="nk-menu-link">
                        <span class="nk-menu-text">Parcel List</span>
                    </a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('admin.unregisteredParcel.index') }}" class="nk-menu-link">
                        <span class="nk-menu-text">Unregistered Parcel List</span>
                    </a>
                </li>
            </ul>
        </li>

        @if($logged_in_user->can('staff.finance'))
            <li class="nk-menu-item has-sub">
                <a href="#" class="nk-menu-link nk-menu-toggle">
                    <span class="nk-menu-text">Report</span>
                </a>
                <ul class="nk-menu-sub">
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.report.monthly') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Parcel Report</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.report.daily') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Daily Sales Report</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.report.income') }}" class="nk-menu-link">
                            <span class="nk-menu-text">Monthly Sales Report</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if ($logged_in_user->hasAllAccess() ||(
            $logged_in_user->can('admin.access.user.list') ||
            $logged_in_user->can('admin.access.user.deactivate') ||
            $logged_in_user->can('admin.access.user.reactivate') ||
            $logged_in_user->can('admin.access.user.clear-session') ||
            $logged_in_user->can('admin.access.user.impersonate') ||
            $logged_in_user->can('admin.access.user.change-password')))

            <li class="nk-menu-item has-sub">
                <a href="#" class="nk-menu-link nk-menu-toggle">
                    <span class="nk-menu-text">System Setting</span>
                </a>
                <ul class="nk-menu-sub">

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.setting.system') }}" class="nk-menu-link">
                            <span class="nk-menu-text">{{ __('System Setting') }}</span>
                        </a>
                    </li>

{{--                    <li class="nk-menu-item">--}}
{{--                        <a href="{{ route('admin.setting.payment') }}" class="nk-menu-link">--}}
{{--                            <span class="nk-menu-text">{{ __('Payment Setting') }}</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

                    @if ($logged_in_user->hasAllAccess() ||(
                           $logged_in_user->can('admin.access.user.list') ||
                           $logged_in_user->can('admin.access.user.deactivate') ||
                           $logged_in_user->can('admin.access.user.reactivate') ||
                           $logged_in_user->can('admin.access.user.clear-session') ||
                           $logged_in_user->can('admin.access.user.impersonate') ||
                           $logged_in_user->can('admin.access.user.change-password')))

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.auth.user.index') }}" class="nk-menu-link">
                            <span class="nk-menu-text">{{ __('User Management') }}</span>
                        </a>
                    </li>
                    @endif

                    @if ($logged_in_user->hasAllAccess())
                    @endif

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.auth.role.index') }}" class="nk-menu-link">
                            <span class="nk-menu-text">{{ __('Role Management') }}</span>
                        </a>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.office.index') }}" class="nk-menu-link">
                            <span class="nk-menu-text">{{ __('Office Management') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</div><!-- .nk-header-menu -->
