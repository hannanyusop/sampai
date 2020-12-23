@extends('backend.layouts.app')

@section('title', __('User Management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')

    <div class="nk-block nk-block-lg">
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                @if ($logged_in_user->hasAllAccess())
                    <div class="row text-right">
                        <div class="m-2 float-right">
                            <a href="{{ route('admin.auth.user.create') }}" class="btn btn-primary">Create New User</a>
                        </div>
                    </div>
                @endif
                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                    <tr class="nk-tb-item nk-tb-head">
                        <th class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid">
                                <label class="custom-control-label" for="uid"></label>
                            </div>
                        </th>
                        <th class="nk-tb-col"><span class="sub-text">User</span></th>
                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Type</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Timezone</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Last Login</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Last IP</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                        <th class="nk-tb-col nk-tb-col-tools text-right">
                            <div class="dropdown">
                                <a href="#" class="btn btn-xs btn-outline-light btn-icon dropdown-toggle" data-toggle="dropdown" data-offset="0,5"><em class="icon ni ni-plus"></em></a>
                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                    <ul class="link-tidy sm no-bdr">
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked="" id="bl">
                                                <label class="custom-control-label" for="bl">Type</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked="" id="ph">
                                                <label class="custom-control-label" for="ph">Permission</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="vri">
                                                <label class="custom-control-label" for="vri">Last Login</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="st">
                                                <label class="custom-control-label" for="st">Last IP</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col nk-tb-col-check">
                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                    <input type="checkbox" class="custom-control-input" id="{{ $user->id }}">
                                    <label class="custom-control-label" for="{{ $user->id }}"></label>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                        <img src="{{ $user->avatar }}" class="user-profile-image" />
                                    </div>
                                    <div class="user-info">
                                        <span class="tb-lead">{{ $user->name }} <span class="dot dot-success d-md-none ml-1"></span></span>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col tb-col-mb">
                                <span class="tb-amount">{{ $user->type }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span>{!! $user->permissions_label !!}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ (!is_null($user->last_login_at))? $user->last_login_at->diffForHumans() : "No Login Information" }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <ul class="list-status">
                                    <li><em class="icon text-success ni ni-check-circle"></em> <span>{{ $user->last_login_ip }}</span></li>
                                </ul>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                @if($user->active == 1)
                                    <span class="tb-status text-success">Active</span>
                                @else
                                    <span class="tb-status text-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    @if ($user->trashed() && $logged_in_user->hasAllAccess())
                                                        <li><a href="{{ route('admin.auth.user.restore', $user) }}"><em class="icon ni ni-focus"></em><span>Restore</span></a></li>
                                                        @if (config('boilerplate.access.user.permanently_delete'))
                                                            <li><a href="{{ route('admin.auth.user.permanently-delete', $user) }}"><em class="icon ni ni-focus"></em><span>Delete Permanently</span></a></li>
                                                        @endif
                                                    @else
                                                        @if ($logged_in_user->hasAllAccess())
                                                            <li><a href="{{ route('admin.auth.user.show', $user) }}"><em class="icon ni ni-eye"></em><span>Show</span></a></li>
                                                            <li><a href="{{ route('admin.auth.user.edit', $user) }}"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>

                                                            @if($user->can('staff.inhouse'))
                                                                <li><a href="{{ route('admin.auth.user.assign', $user) }}"><em class="icon ni ni-link-alt"></em><span>@lang('Assign office')</span></a></li>
                                                            @endif

                                                        @endif
                                                        @if (! $user->isActive())
                                                            <li><a href="{{ route('admin.auth.user.mark', [$user, 1]) }}"><em class="icon ni ni-focus"></em><span>@lang('Reactivate')</span></a></li>
                                                        @endif
                                                        @if ($user->id !== $logged_in_user->id && !$user->isMasterAdmin() && $logged_in_user->hasAllAccess())
                                                            <li><a href="{{ route('admin.auth.user.destroy', $user) }}"><em class="icon ni ni-focus"></em><span>@lang('Reactivate')</span></a></li>
                                                        @endif
                                                        @if ($user->isMasterAdmin() && $logged_in_user->isMasterAdmin())
                                                            <li><a href="{{ route('admin.auth.user.change-password', $user) }}"><em class="icon ni ni-focus"></em><span>{{ __('Change Password') }}</span></a></li>
                                                        @elseif (!$user->isMasterAdmin() && // This is not the master admin
                                                            $user->isActive() && // The account is active
                                                            $user->id !== $logged_in_user->id && // It's not the person logged in
                                                            ($logged_in_user->can('admin.access.user.change-password') ||$logged_in_user->can('admin.access.user.clear-session') ||
                                                             $logged_in_user->can('admin.access.user.impersonate') ||$logged_in_user->can('admin.access.user.deactivate')))

                                                            <li><a href="{{ route('admin.auth.user.change-password', $user) }}"><em class="icon ni ni-lock-alt"></em><span>{{ __('Change Password') }}</span></a></li>

                                                            @if ($user->id !== $logged_in_user->id && !$user->isMasterAdmin())

                                                                <li><a href="{{ route('admin.auth.user.clear-session', $user) }}"><em class="icon ni ni-regen"></em><span>@lang('Clear Session')</span></a></li>

                                                                <li><a href="{{ route('admin.auth.user.mark', [$user, 0]) }}"><em class="icon ni ni-user-cross"></em><span>@lang('Deactivate')</span></a></li>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- .card-preview -->
    </div> <!-- nk-block -->

@endsection
