@php $extend = (auth()->user()->type == 'user')? 'frontend.layouts.app' :  'backend.layouts.app'; @endphp

@extends($extend)

@section('title', __('Account'))

@section('content')
<style>
    .account-page {
        min-height: 100vh;
        background: var(--bg-primary, #f5f6fa);
        padding-bottom: 100px;
    }

    .profile-hero {
        background: linear-gradient(135deg, var(--accent-color, #667eea) 0%, var(--gradient-end, #764ba2) 100%);
        padding: 32px 20px 40px;
        text-align: center;
        position: relative;
    }

    .profile-avatar-wrap {
        position: relative;
        display: inline-block;
        margin-bottom: 12px;
    }

    .profile-avatar {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,0.4);
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    .profile-avatar-edit {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: white;
        color: #667eea;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .profile-hero-name {
        font-size: 1.35rem;
        font-weight: 700;
        color: white;
        margin-bottom: 2px;
    }

    .profile-hero-id {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.75);
        margin-bottom: 16px;
    }

    .btn-edit-profile {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 20px;
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1.5px solid rgba(255,255,255,0.4);
        border-radius: 24px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-edit-profile:hover {
        background: rgba(255,255,255,0.3);
        color: white;
        text-decoration: none;
    }

    .btn-edit-profile i { font-size: 0.85rem; }

    .account-sections {
        padding: 0 16px;
        margin-top: -20px;
        position: relative;
        z-index: 1;
    }

    .section-group { margin-bottom: 16px; }

    .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-muted, #999);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 0 4px;
        margin-bottom: 6px;
    }

    .info-card {
        background: var(--bg-card, white);
        border-radius: 14px;
        box-shadow: var(--shadow, 0 1px 8px rgba(0,0,0,0.06));
        overflow: hidden;
    }

    .info-row {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color, #f2f3f5);
    }

    .info-row:last-child { border-bottom: none; }

    .info-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .info-icon.purple { background: var(--accent-light, rgba(102, 126, 234, 0.1)); color: var(--accent-color, #667eea); }
    .info-icon.green { background: rgba(17, 153, 142, 0.1); color: #11998e; }
    .info-icon.blue { background: rgba(79, 172, 254, 0.1); color: #4facfe; }
    .info-icon.orange { background: rgba(255, 154, 0, 0.1); color: #ff9a00; }
    .info-icon.pink { background: rgba(245, 87, 108, 0.1); color: #f5576c; }
    .info-details { flex: 1; min-width: 0; }

    .info-label {
        font-size: 0.7rem;
        color: var(--text-muted, #999);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .info-value {
        font-size: 0.9rem;
        color: var(--text-primary, #1a1a2e);
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .info-value.muted { color: #bbb; font-style: italic; }

    .link-row {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color, #f2f3f5);
        cursor: pointer;
        transition: background 0.15s;
        text-decoration: none;
        color: inherit;
    }

    .link-row:last-child { border-bottom: none; }
    .link-row:hover { background: var(--badge-bg, #fafafa); text-decoration: none; color: inherit; }

    .link-row .link-title { font-size: 0.9rem; font-weight: 600; color: var(--text-primary, #1a1a2e); }
    .link-row .link-subtitle { font-size: 0.75rem; color: var(--text-muted, #999); }
    .link-arrow { color: var(--text-muted, #ccc); font-size: 1rem; margin-left: auto; flex-shrink: 0; }

    .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 14px;
        background: var(--bg-card, white);
        color: #e53e3e;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s;
        gap: 8px;
    }

    .logout-btn:hover { background: #fff5f5; color: #e53e3e; text-decoration: none; }

    .account-footer {
        text-align: center;
        padding: 24px 20px;
        color: var(--text-muted, #ccc);
        font-size: 0.75rem;
    }

    .account-footer .app-name { font-weight: 600; color: var(--text-muted, #aaa); }

    /* Appearance Section */
    .toggle-row {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color, #f2f3f5);
    }
    .toggle-row:last-child { border-bottom: none; }

    .toggle-details { flex: 1; min-width: 0; }
    .toggle-title { font-size: 0.9rem; font-weight: 600; color: var(--text-primary, #1a1a2e); }
    .toggle-subtitle { font-size: 0.75rem; color: var(--text-muted, #999); }

    .toggle-switch {
        position: relative;
        width: 48px;
        height: 26px;
        flex-shrink: 0;
    }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute;
        inset: 0;
        background: #ddd;
        border-radius: 26px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .toggle-slider::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        left: 3px;
        bottom: 3px;
        background: white;
        border-radius: 50%;
        transition: transform 0.3s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }
    .toggle-switch input:checked + .toggle-slider { background: var(--accent-color, #667eea); }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(22px); }

    .color-picker-row {
        padding: 14px 16px;
    }
    .color-picker-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-primary, #1a1a2e);
        margin-bottom: 12px;
    }
    .color-options {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }
    .color-dot {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 3px solid transparent;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .color-dot:hover { transform: scale(1.1); }
    .color-dot.active { border-color: var(--text-primary, #1a1a2e); }
    .color-dot.active::after {
        content: '\2713';
        color: white;
        font-size: 0.8rem;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    .color-custom {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 2px dashed var(--text-muted, #999);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .color-custom i { font-size: 0.85rem; color: var(--text-muted, #999); }
    .color-custom input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    /* Edit form */
    .edit-form-section { display: none; }
    .edit-form-section.active { display: block; }

    .edit-form-card {
        background: var(--bg-card, white);
        border-radius: 14px;
        box-shadow: var(--shadow, 0 1px 8px rgba(0,0,0,0.06));
        padding: 20px 16px;
    }

    .form-field { margin-bottom: 16px; }

    .form-field label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary, #666);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 6px;
    }

    .form-field .form-input {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid var(--border-color, #e8e8e8);
        border-radius: 10px;
        font-size: 0.9rem;
        color: var(--text-primary, #1a1a2e);
        background: var(--input-bg, #fafbfc);
        transition: border-color 0.2s, background 0.2s;
        outline: none;
    }

    .form-field .form-input:focus { border-color: var(--accent-color, #667eea); background: var(--bg-card, white); }
    .form-field .field-error { font-size: 0.75rem; color: #e53e3e; margin-top: 4px; }

    .form-field .field-info {
        font-size: 0.75rem;
        color: #4facfe;
        margin-top: 4px;
        display: flex;
        align-items: flex-start;
        gap: 4px;
    }

    .form-actions { display: flex; gap: 10px; margin-top: 20px; }

    .btn-save {
        flex: 1;
        padding: 12px;
        background: linear-gradient(135deg, var(--accent-color, #667eea) 0%, var(--gradient-end, #764ba2) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity 0.2s;
    }

    .btn-save:hover { opacity: 0.9; }

    .btn-cancel {
        padding: 12px 20px;
        background: var(--bg-primary, #f5f6fa);
        color: var(--text-secondary, #666);
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-cancel:hover { background: #eee; }

    @media (min-width: 768px) {
        .account-page { padding-top: 20px; }
        .account-sections { max-width: 480px; margin-left: auto; margin-right: auto; }
        .profile-hero { max-width: 480px; margin: 0 auto; border-radius: 0 0 20px 20px; }
    }
</style>

<div class="account-page">
    <!-- Profile Hero -->
    <div class="profile-hero">
        <div class="profile-avatar-wrap" data-toggle="modal" data-target="#update-image">
            <img src="{{ $logged_in_user->avatar }}" alt="{{ $logged_in_user->name }}" class="profile-avatar">
            <div class="profile-avatar-edit">
                <i class="ni ni-camera"></i>
            </div>
        </div>
        <div class="profile-hero-name">{{ $logged_in_user->name }}</div>
        <div class="profile-hero-id">{{ $logged_in_user->identification }}</div>
        <a href="javascript:void(0)" class="btn-edit-profile" id="editProfileBtn" onclick="toggleEditProfile(true)">
            <i class="ni ni-edit"></i> {{ __('Edit Profile') }}
        </a>
    </div>

    <div class="account-sections">
        <!-- View Mode: Personal Info -->
        <div class="section-group" id="viewSection">
            <div class="section-label">{{ __('Personal Information') }}</div>
            <div class="info-card">
                <div class="info-row">
                    <div class="info-icon purple"><i class="ni ni-user"></i></div>
                    <div class="info-details">
                        <div class="info-label">{{ __('Full Name') }}</div>
                        <div class="info-value">{{ $logged_in_user->name }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon blue"><i class="ni ni-mail"></i></div>
                    <div class="info-details">
                        <div class="info-label">{{ __('Email') }}</div>
                        <div class="info-value">{{ $logged_in_user->email }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon green"><i class="ni ni-call"></i></div>
                    <div class="info-details">
                        <div class="info-label">{{ __('Phone Number') }}</div>
                        <div class="info-value {{ $logged_in_user->phone_number ? '' : 'muted' }}">{{ $logged_in_user->phone_number ?: __('Not set') }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon orange"><i class="ni ni-map-pin"></i></div>
                    <div class="info-details">
                        <div class="info-label">{{ __('Address') }}</div>
                        <div class="info-value {{ $logged_in_user->address ? '' : 'muted' }}">{{ $logged_in_user->address ?: __('Not set') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Mode: Profile Form -->
        <div class="section-group edit-form-section" id="editSection">
            <div class="section-label">{{ __('Edit Profile') }}</div>
            <div class="edit-form-card">
                <x-forms.patch :action="route('frontend.user.profile.update')">
                    <div class="form-field">
                        <label for="name">{{ __('Full Name') }}</label>
                        <input type="text" name="name" id="name" class="form-input text-uppercase" placeholder="{{ __('Full Name') }}" value="{{ old('name') ?? $logged_in_user->name }}" required>
                        @error('name')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($logged_in_user->canChangeEmail())
                        <div class="form-field">
                            <label for="email">{{ __('E-mail Address') }}</label>
                            <input type="email" name="email" id="email" class="form-input" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') ?? $logged_in_user->email }}" required autocomplete="email">
                            <div class="field-info">
                                <i class="ni ni-info"></i>
                                <span>{{ __('Changing your email will log you out until confirmed.') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="form-field">
                        <label for="phone_number">{{ __('Phone Number') }}</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-input" placeholder="{{ __('Phone Number') }}" value="{{ old('phone_number') ?? $logged_in_user->phone_number }}" required>
                        @error('phone_number')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-save">{{ __('Save Changes') }}</button>
                        <button type="button" class="btn-cancel" onclick="toggleEditProfile(false)">{{ __('Cancel') }}</button>
                    </div>
                </x-forms.patch>
            </div>
        </div>

        <!-- Security -->
        <div class="section-group">
            <div class="section-label">{{ __('Security') }}</div>
            <div class="info-card">
                <a href="{{ route('account.update-password') }}" class="link-row">
                    <div class="info-icon pink"><i class="ni ni-lock-alt"></i></div>
                    <div class="info-details">
                        <div class="link-title">{{ __('Change Password') }}</div>
                        <div class="link-subtitle">{{ (is_null($logged_in_user->password_changed_at)) ? __('Never changed') : $logged_in_user->password_changed_at->diffForHumans() }}</div>
                    </div>
                    <div class="link-arrow"><i class="ni ni-chevron-right"></i></div>
                </a>
            </div>
        </div>

        <!-- Notifications -->
        <div class="section-group">
            <div class="section-label">{{ __('Notifications') }}</div>
            <div class="info-card">
                <a href="{{ route('frontend.user.notifications') }}" class="link-row">
                    <div class="info-icon green"><i class="ni ni-bell"></i></div>
                    <div class="info-details">
                        <div class="link-title">{{ __('Notification Settings') }}</div>
                        <div class="link-subtitle">{{ __('Manage push notifications') }}</div>
                    </div>
                    <div class="link-arrow"><i class="ni ni-chevron-right"></i></div>
                </a>
            </div>
        </div>

        <!-- Appearance -->
        <div class="section-group">
            <div class="section-label">{{ __('Appearance') }}</div>
            <div class="info-card">
                <div class="toggle-row">
                    <div class="info-icon purple"><i class="ni ni-moon"></i></div>
                    <div class="toggle-details">
                        <div class="toggle-title">{{ __('Dark Mode') }}</div>
                        <div class="toggle-subtitle">{{ __('Easier on the eyes at night') }}</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="darkModeToggle" onchange="toggleDarkMode(this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="color-picker-row">
                    <div class="color-picker-label">{{ __('Accent Color') }}</div>
                    <div class="color-options">
                        <div class="color-dot" style="background:#667eea;" data-color="#667eea" onclick="setAccentColor('#667eea')"></div>
                        <div class="color-dot" style="background:#00c6a7;" data-color="#00c6a7" onclick="setAccentColor('#00c6a7')"></div>
                        <div class="color-dot" style="background:#f5576c;" data-color="#f5576c" onclick="setAccentColor('#f5576c')"></div>
                        <div class="color-dot" style="background:#ff9a00;" data-color="#ff9a00" onclick="setAccentColor('#ff9a00')"></div>
                        <div class="color-dot" style="background:#11998e;" data-color="#11998e" onclick="setAccentColor('#11998e')"></div>
                        <div class="color-dot" style="background:#6366f1;" data-color="#6366f1" onclick="setAccentColor('#6366f1')"></div>
                        <div class="color-custom" title="{{ __('Custom color') }}">
                            <i class="ni ni-plus"></i>
                            <input type="color" id="customColorPicker" value="#667eea" onchange="setAccentColor(this.value)">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Info -->
        <div class="section-group">
            <div class="section-label">{{ __('Account') }}</div>
            <div class="info-card">
                <div class="info-row">
                    <div class="info-icon blue"><i class="ni ni-calendar"></i></div>
                    <div class="info-details">
                        <div class="info-label">{{ __('Member Since') }}</div>
                        <div class="info-value">@displayDate($logged_in_user->created_at)</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout -->
        <div class="section-group">
            <div class="info-card">
                <a href="{{ route('frontend.auth.logout') }}" class="logout-btn">
                    <i class="ni ni-signout"></i>
                    {{ __('Log Out') }}
                </a>
            </div>
        </div>

        <div class="account-footer">
            <div class="app-name">{{ env('APP_NAME') }}</div>
            <div>Version 1.2</div>
        </div>
    </div>
</div>

<!-- Update Image Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="update-image">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">{{ __('Update Profile Image') }}</h5>
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
                                <span class="invalid">{{ $message }}</span>
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

<script>
    function toggleEditProfile(show) {
        var viewSection = document.getElementById('viewSection');
        var editSection = document.getElementById('editSection');
        var editBtn = document.getElementById('editProfileBtn');

        if (show) {
            viewSection.style.display = 'none';
            editSection.classList.add('active');
            editBtn.style.display = 'none';
        } else {
            viewSection.style.display = '';
            editSection.classList.remove('active');
            editBtn.style.display = '';
        }
    }

    // Auto-show edit form on validation errors
    @if($errors->has('name') || $errors->has('email') || $errors->has('phone_number'))
        toggleEditProfile(true);
    @endif

    @if($errors->has('image'))
        $(function(){ $("#update-image").modal('show'); });
    @endif

    // Theme: Dark Mode
    function toggleDarkMode(on) {
        var theme = on ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
    }

    // Theme: Accent Color
    function setAccentColor(color) {
        document.documentElement.style.setProperty('--accent-color', color);
        localStorage.setItem('accentColor', color);
        updateColorDots(color);
    }

    function updateColorDots(active) {
        document.querySelectorAll('.color-dot').forEach(function(dot) {
            dot.classList.toggle('active', dot.getAttribute('data-color') === active);
        });
    }

    // Initialize theme state on page load
    (function() {
        var theme = localStorage.getItem('theme');
        var color = localStorage.getItem('accentColor') || '#667eea';
        var toggle = document.getElementById('darkModeToggle');
        if (toggle) toggle.checked = (theme === 'dark');
        updateColorDots(color);
        document.getElementById('customColorPicker').value = color;
    })();
</script>
@endsection
