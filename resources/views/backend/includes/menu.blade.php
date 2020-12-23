<div class="nk-aside" data-content="sideNav" data-toggle-overlay="true" data-toggle-screen="lg" data-toggle-body="true">
    <div class="nk-sidebar-menu" data-simplebar>
        <!-- Menu -->
        <ul class="nk-menu">
            <li class="nk-menu-heading">
                <h6 class="overline-title">Menu</h6>
            </li>
            <li class="nk-menu-item">
                <a href="{{ route('admin.dashboard') }}" class="nk-menu-link">
                    <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                    <span class="nk-menu-text">Dashboard</span>
                </a>
            </li>
            <li class="nk-menu-item">
                <a href="#" class="nk-menu-link">
                    <span class="nk-menu-icon"><em class="icon ni ni-tags"></em></span>
                    <span class="nk-menu-text">Trip Management</span>
                </a>
                <ul class="nk-menu-sub">
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.trip.index') }}" class="nk-menu-link">
                            <span class="nk-menu-text">List</span>
                        </a>
                        @if($logged_in_user->can('staff.inhouse'))
                            <a href="{{ route('admin.trip.create') }}" class="nk-menu-link">
                                <span class="nk-menu-text">Add Trip</span>
                            </a>
                            <a href="{{ route('admin.trip.receive') }}" class="nk-menu-link">
                                <span class="nk-menu-text">Receive Trip</span>
                            </a>
                        @endif
                        @if($logged_in_user->can('staff.runner'))

                        @endif
                    </li>
                </ul>
            </li>

            @if ($logged_in_user->hasAllAccess() ||(
                $logged_in_user->can('admin.access.user.list') ||
                $logged_in_user->can('admin.access.user.deactivate') ||
                $logged_in_user->can('admin.access.user.reactivate') ||
                $logged_in_user->can('admin.access.user.clear-session') ||
                $logged_in_user->can('admin.access.user.impersonate') ||
                $logged_in_user->can('admin.access.user.change-password')))

                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                        <span class="nk-menu-text">@lang('System')</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">

                            @if ($logged_in_user->hasAllAccess() ||(
                            $logged_in_user->can('admin.access.user.list') ||
                            $logged_in_user->can('admin.access.user.deactivate') ||
                            $logged_in_user->can('admin.access.user.reactivate') ||
                            $logged_in_user->can('admin.access.user.clear-session') ||
                            $logged_in_user->can('admin.access.user.impersonate') ||
                            $logged_in_user->can('admin.access.user.change-password')))
                                <a href="{{ route('admin.auth.user.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">{{ __('User Management') }}</span>
                                </a>
                            @endif

                            @if ($logged_in_user->hasAllAccess())
                            @endif


{{--                            <a href="{{ route('admin.auth.role.index') }}" class="nk-menu-link">--}}
{{--                                <span class="nk-menu-text">{{ __('Role Management') }}</span>--}}
{{--                            </a>--}}
                            <a href="{{ route('admin.office.index') }}" class="nk-menu-link">
                                <span class="nk-menu-text">{{ __('Office Management') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

            @endif
        </ul>
    </div>
    <div class="nk-aside-close">
        <a href="#" class="toggle" data-target="sideNav"><em class="icon ni ni-cross"></em></a>
    </div><!-- .nk-aside-close -->
</div><!-- .nk-aside -->
