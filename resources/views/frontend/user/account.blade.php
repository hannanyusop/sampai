@php $extend = (auth()->user()->type == 'user')? 'frontend.layouts.app' :  'backend.layouts.app'; @endphp

@extends($extend)

@section('title', __('Account'))

<style>
    /* Account Page Mobile Styles */
    .account-container {
        padding-bottom: 100px;
    }

    /* Profile Header */
    .profile-header {
        text-align: center;
        padding: 24px 20px 32px;
        background: linear-gradient(180deg, rgba(102, 126, 234, 0.05) 0%, transparent 100%);
    }

    .profile-avatar-wrap {
        position: relative;
        display: inline-block;
        margin-bottom: 16px;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }

    .profile-avatar-edit {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        border: 3px solid white;
        cursor: pointer;
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 4px;
    }

    .profile-id {
        font-size: 0.875rem;
        color: #666;
    }

    /* Settings Sections */
    .settings-section {
        padding: 0 16px;
        margin-bottom: 24px;
    }

    .section-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0 4px;
        margin-bottom: 8px;
    }

    .settings-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .settings-item {
        display: flex;
        align-items: center;
        padding: 16px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: background 0.2s;
        text-decoration: none;
        color: inherit;
    }

    .settings-item:last-child {
        border-bottom: none;
    }

    .settings-item:hover {
        background: #f9f9f9;
        text-decoration: none;
        color: inherit;
    }

    .settings-item:active {
        background: #f0f0f0;
    }

    .settings-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
        font-size: 1.25rem;
    }

    .settings-icon.purple { background: rgba(102, 126, 234, 0.1); color: #667eea; }
    .settings-icon.green { background: rgba(17, 153, 142, 0.1); color: #11998e; }
    .settings-icon.blue { background: rgba(79, 172, 254, 0.1); color: #4facfe; }
    .settings-icon.orange { background: rgba(255, 154, 0, 0.1); color: #ff9a00; }
    .settings-icon.red { background: rgba(229, 62, 62, 0.1); color: #e53e3e; }
    .settings-icon.pink { background: rgba(245, 87, 108, 0.1); color: #f5576c; }

    .settings-content {
        flex: 1;
    }

    .settings-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 2px;
    }

    .settings-value {
        font-size: 0.8rem;
        color: #888;
    }

    .settings-arrow {
        color: #ccc;
        font-size: 1.25rem;
    }

    /* Logout Button */
    .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 16px;
        background: #fff5f5;
        color: #e53e3e;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s;
    }

    .logout-btn:hover {
        background: #fee;
        color: #e53e3e;
        text-decoration: none;
    }

    .logout-btn i {
        margin-right: 8px;
        font-size: 1.25rem;
    }

    /* Version Footer */
    .version-footer {
        text-align: center;
        padding: 32px 20px;
        color: #bbb;
        font-size: 0.8rem;
    }

    .version-footer .app-name {
        font-weight: 600;
        color: #999;
    }

    /* Desktop adjustments */
    @media (min-width: 768px) {
        .account-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .settings-card {
            border: 1px solid #eee;
        }
    }
</style>

@section('content')
<div class="account-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-avatar-wrap" data-toggle="modal" data-target="#update-image">
            <img src="{{ $logged_in_user->avatar }}" alt="{{ $logged_in_user->name }}" class="profile-avatar">
            <div class="profile-avatar-edit">
                <i class="ni ni-camera"></i>
            </div>
        </div>
        <div class="profile-name">{{ $logged_in_user->name }}</div>
        <div class="profile-id">{{ $logged_in_user->identification }}</div>
    </div>

    <!-- Personal Information -->
    <div class="settings-section">
        <div class="section-label">{{ __('Personal Information') }}</div>
        <div class="settings-card">
            <div class="settings-item" data-toggle="modal" data-target="#profile-edit">
                <div class="settings-icon purple">
                    <i class="ni ni-user"></i>
                </div>
                <div class="settings-content">
                    <div class="settings-title">{{ __('Full Name') }}</div>
                    <div class="settings-value">{{ $logged_in_user->name }}</div>
                </div>
                <div class="settings-arrow">
                    <i class="ni ni-chevron-right"></i>
                </div>
            </div>

            <div class="settings-item" data-toggle="modal" data-target="#profile-edit">
                <div class="settings-icon blue">
                    <i class="ni ni-mail"></i>
                </div>
                <div class="settings-content">
                    <div class="settings-title">{{ __('Email') }}</div>
                    <div class="settings-value">{{ $logged_in_user->email }}</div>
                </div>
                <div class="settings-arrow">
                    <i class="ni ni-chevron-right"></i>
                </div>
            </div>

            <div class="settings-item" data-toggle="modal" data-target="#profile-edit">
                <div class="settings-icon green">
                    <i class="ni ni-call"></i>
                </div>
                <div class="settings-content">
                    <div class="settings-title">{{ __('Phone Number') }}</div>
                    <div class="settings-value">{{ $logged_in_user->phone_number ?: __('Not set') }}</div>
                </div>
                <div class="settings-arrow">
                    <i class="ni ni-chevron-right"></i>
                </div>
            </div>

            <div class="settings-item" data-toggle="modal" data-target="#profile-edit">
                <div class="settings-icon orange">
                    <i class="ni ni-map-pin"></i>
                </div>
                <div class="settings-content">
                    <div class="settings-title">{{ __('Address') }}</div>
                    <div class="settings-value">{{ $logged_in_user->address ?: __('Not set') }}</div>
                </div>
                <div class="settings-arrow">
                    <i class="ni ni-chevron-right"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Security -->
    <div class="settings-section">
        <div class="section-label">{{ __('Security') }}</div>
        <div class="settings-card">
            <a href="{{ route('account.update-password') }}" class="settings-item">
                <div class="settings-icon pink">
                    <i class="ni ni-lock-alt"></i>
                </div>
                <div class="settings-content">
                    <div class="settings-title">{{ __('Change Password') }}</div>
                    <div class="settings-value">{{ (is_null($logged_in_user->password_changed_at)) ? __('Never changed') : $logged_in_user->password_changed_at->diffForHumans() }}</div>
                </div>
                <div class="settings-arrow">
                    <i class="ni ni-chevron-right"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Account Info -->
    <div class="settings-section">
        <div class="section-label">{{ __('Account Info') }}</div>
        <div class="settings-card">
            <div class="settings-item" style="cursor: default;">
                <div class="settings-icon blue">
                    <i class="ni ni-calendar"></i>
                </div>
                <div class="settings-content">
                    <div class="settings-title">{{ __('Member Since') }}</div>
                    <div class="settings-value">@displayDate($logged_in_user->created_at)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout -->
    <div class="settings-section">
        <div class="settings-card">
            <a href="{{ route('frontend.auth.logout') }}" class="logout-btn">
                <i class="ni ni-signout"></i>
                {{ __('Log Out') }}
            </a>
        </div>
    </div>

    <!-- Version Footer -->
    <div class="version-footer">
        <div class="app-name">{{ env('APP_NAME') }}</div>
        <div>Version 1.2</div>
    </div>
</div>

<!-- Profile Edit Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="profile-edit">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">{{ __('Update Profile') }}</h5>

                <div class="tab-pane active" id="personal">
                    <x-forms.patch :action="route('frontend.user.profile.update')" class="row gy-4">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="name">@lang('Name')</label>
                                <input type="text" name="name" id="name" class="form-control text-uppercase" placeholder="{{ __('Name') }}" value="{{ old('name') ?? $logged_in_user->name }}" required>
                                @error('name')
                                <span id="address" class="invalid">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @if ($logged_in_user->canChangeEmail())
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">@lang('E-mail Address')</label>
                                    <x-utils.alert type="info" class="mb-3" :dismissable="false">
                                        <i class="fas fa-info-circle"></i> @lang('If you change your e-mail you will be logged out until you confirm your new e-mail address.')
                                    </x-utils.alert>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') ?? $logged_in_user->email }}" required autocomplete="email" />
                                </div>
                            </div>
                        @endif

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="phone_number">@lang('Phone Number')</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control text-uppercase"  value="{{ old('phone_number') ?? $logged_in_user->phone_number }}" required autofocus>
                                @error('phone_number')
                                    <span id="phone_number" class="invalid">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 m-2">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update')</button>
                                </li>
                                <li>
                                    <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </x-forms.patch>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Update Password Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="update-password">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">{{ __('Update Password') }}</h5>

                <div class="tab-pane active" id="personal">
                    <x-forms.patch :action="route('frontend.user.profile.password')" class="row gy-4">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="current_password">@lang('Current Password')</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="{{ __('Current Password') }}" maxlength="100" required autofocus />
                                @error('current_password')
                                <span id="address" class="invalid">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="password">@lang('New Password')</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('New Password') }}" maxlength="100" required />
                                @error('password')
                                    <span id="address" class="invalid">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">@lang('New Password Confirmation')</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('New Password Confirmation') }}" maxlength="100" required />
                                @error('password_confirmation')
                                    <span id="address" class="invalid">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 m-2">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Change Password')</button>
                                </li>
                                <li>
                                    <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </x-forms.patch>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Update Image Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="update-image">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">{{ __('Update Profile Image') }}</h5>

                <div class="tab-pane active" id="personal">
                    <x-forms.patch :action="route('frontend.user.profile.image')" class="row gy-4" enctype="multipart/form-data">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail h-150">
                                <img src="{{ asset($logged_in_user->avatar) }}" alt="" style="width: 100px; height: auto;">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail thumbnail-h3"></div>
                            <div>
                                <span class="btn btn-primary btn-file">
                                    <input type="file" name="image" id="image">
                                </span>
                                @error('image')
                                    <span id="address" class="invalid">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 m-2">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Profile')</button>
                                </li>
                                <li>
                                    <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </x-forms.patch>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('after-scripts')
    <script type="text/javascript">
        $(function (){
            @if($errors->has('name') || $errors->has('email') || $errors->has('phone_number') || $errors->has('identification') || $errors->has('address'))
                $("#profile-edit").modal('show');
            @endif

            @if($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
                $("#update-password").modal('show');
            @endif

            @if($errors->has('image'))
                $("#update-image").modal('show');
            @endif
        });
    </script>
@endpush
