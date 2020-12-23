@extends('backend.layouts.app')

@section('title', __('View User'))

@section('content')
    <div class="nk-block-head nk-block-head-lg wide-sm">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><a class="back-to" href="{{ route('admin.auth.user.index') }}"><em class="icon ni ni-arrow-left"></em><span>Users List</span></a></div>
            <h2 class="nk-block-title fw-normal">View Users</h2>
            <div class="nk-block-des">
                <p class="lead"></p>
            </div>
        </div>
    </div>

    <div class="nk-block">
        <div class="card card-bordered">
            <div class="card-aside-wrap">
                <div class="card-inner card-inner-lg">
                    <div class="nk-block-head nk-block-head-lg">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title">Personal Information</h4>
                                <div class="nk-block-des">
                                    <p>Basic info, like your name and address</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content align-self-start d-lg-none">
                                <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="nk-data data-list">
                            <div class="data-head">
                                <h6 class="overline-title">Basics</h6>
                            </div>
                            <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                <div class="data-col">
                                    <span class="data-label">Full Name</span>
                                    <span class="data-value">{{ $user->name }}</span>
                                </div>
                            </div><!-- data-item -->
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Email</span>
                                    <span class="data-value">{{ $user->email }}</span>
                                </div>
                            </div><!-- data-item -->
                            <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                <div class="data-col">
                                    <span class="data-label">@lang('Type')</span>
                                    <span class="data-value text-soft">@include('backend.auth.user.includes.type')</span>
                                </div>
                            </div>
                            <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                <div class="data-col">
                                    <span class="data-label">@lang('Roles')</span>
                                    <span class="data-value text-soft">{!! $user->roles_label !!}</span>
                                </div>
                            </div>

                            <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                <div class="data-col">
                                    <span class="data-label">Status</span>
                                    <span class="data-value">@include('backend.auth.user.includes.status', ['user' => $user])</span>
                                </div>
                            </div><!-- data-item -->

                            <div class="data-item" data-toggle="modal" data-target="#profile-edit" data-tab-target="#address">
                                <div class="data-col">
                                    <span class="data-label">Verified</span>
                                    <span class="data-value">@include('backend.auth.user.includes.verified', ['user' => $user])</span>
                                </div>
                            </div><!-- data-item -->

                            <div class="data-item" data-toggle="modal" data-target="#profile-edit" data-tab-target="#address">
                                <div class="data-col">
                                    <span class="data-label">@lang('Additional Permissions')</span>
                                    <span class="data-value">{!! $user->permissions_label !!}</span>
                                </div>
                            </div><!-- data-item -->

                            @if ($user->isSocial())
                                <div class="data-item" data-toggle="modal" data-target="#profile-edit" data-tab-target="#address">
                                    <div class="data-col">
                                        <span class="data-label">@lang('Provider')</span>
                                        <span class="data-value"{{ $user->provider ?? __('N/A') }}</span>
                                    </div>
                                </div><!-- data-item -->

                                <div class="data-item" data-toggle="modal" data-target="#profile-edit" data-tab-target="#address">
                                    <div class="data-col">
                                        <span class="data-label">@lang('Provider ID')</span>
                                        <span class="data-value">{{ $user->provider_id ?? __('N/A') }}</span>
                                    </div>
                                </div><!-- data-item -->
                            @endif

                        </div><!-- data-list -->
                        <div class="nk-data data-list">
                            <div class="data-head">
                                <h6 class="overline-title">Preferences</h6>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">2FA</span>
                                    <span class="data-value">@include('backend.auth.user.includes.2fa', ['user' => $user])</span>
                                </div>
                                <div class="data-col data-col-end"><a href="#" data-toggle="modal" data-target="#profile-language" class="link link-primary">Change Language</a></div>
                            </div><!-- data-item -->
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Timezone</span>
                                    <span class="data-value">{{ $user->timezone ?? __('N/A') }}</span>
                                </div>
                                <div class="data-col data-col-end"><a href="#" data-toggle="modal" data-target="#profile-language" class="link link-primary">Change</a></div>
                            </div><!-- data-item -->

                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Last Login At</span>
                                    <span class="data-value">
                                        @if($user->last_login_at)
                                            @displayDate($user->last_login_at)
                                        @else
                                            @lang('N/A')
                                        @endif</span>
                                </div>
                                <div class="data-col data-col-end"><a href="#" data-toggle="modal" data-target="#profile-language" class="link link-primary">Change</a></div>
                            </div><!-- data-item -->

                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">@lang('Last Known IP Address')</span>
                                    <span class="data-value">
                                        {{ $user->last_login_ip ?? __('N/A') }}
                                    </span>
                                </div>
                                <div class="data-col data-col-end"><a href="#" data-toggle="modal" data-target="#profile-language" class="link link-primary">Change</a></div>
                            </div><!-- data-item -->

                            <small class="float-right text-muted">
                                <strong>@lang('Account Created'):</strong> @displayDate($user->created_at) ({{ $user->created_at->diffForHumans() }}),
                                <strong>@lang('Last Updated'):</strong> @displayDate($user->updated_at) ({{ $user->updated_at->diffForHumans() }})

                                @if($user->trashed())
                                    <strong>@lang('Account Deleted'):</strong> @displayDate($user->deleted_at) ({{ $user->deleted_at->diffForHumans() }})
                                @endif
                            </small>

                        </div><!-- data-list -->
                    </div><!-- .nk-block -->
                </div>
                <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                    <div class="card-inner-group" data-simplebar>
                        <div class="card-inner">
                            <div class="user-card">
                                <div class="user-avatar bg-primary">
                                    <img src="{{ $user->avatar }}" class="user-profile-image" />
                                </div>
                                <div class="user-info">
                                    <span class="lead-text">{{ $user->name }}</span>
                                    <span class="sub-text">{{ $user->email }}</span>
                                </div>
                                <div class="user-action">
                                    <div class="dropdown">
                                        <a class="btn btn-icon btn-trigger mr-n2" data-toggle="dropdown" href="#"><em class="icon ni ni-more-v"></em></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#"><em class="icon ni ni-camera-fill"></em><span>Change Photo</span></a></li>
                                                <li><a href="#"><em class="icon ni ni-edit-fill"></em><span>Update Profile</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .user-card -->
                        </div><!-- .card-inner -->
                        <div class="card-inner p-0">
                            <ul class="link-list-menu">
                                <li><a class="active" href="#"><em class="icon ni ni-user-fill-c"></em><span>Personal Infomation</span></a></li>
                                <li><a href="#"><em class="icon ni ni-bell-fill"></em><span>Notifications</span></a></li>
                                <li><a href="#"><em class="icon ni ni-activity-round-fill"></em><span>Account Activity</span></a></li>
                                <li><a href="#"><em class="icon ni ni-lock-alt-fill"></em><span>Security Settings</span></a></li>
                                <li><a href="#"><em class="icon ni ni-shield-star-fill"></em><span>Password Change</span></a></li>
                                <li><a href="#"><em class="icon ni ni-grid-add-fill-c"></em><span>Connected with Social</span></a></li>
                            </ul>
                        </div><!-- .card-inner -->
                    </div><!-- .card-inner-group -->
                </div><!-- card-aside -->
            </div><!-- .card-aside-wrap -->
        </div><!-- .card -->
    </div><!-- .nk-block -->
@endsection
