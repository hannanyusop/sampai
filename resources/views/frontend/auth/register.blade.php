@extends('frontend.layouts.auth')

@section('title', __('Create Account'))

@section('content')
<div class="auth-wrapper">
    <!-- Left Panel - Branding -->
    <div class="auth-brand-panel">
        <div class="auth-brand-content">
            <div class="auth-brand-logo">
                <a href="{{ route('frontend.index') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ appName() }}">
                </a>
            </div>
            <h1 class="auth-brand-title">
                Join<br>
                <span>NUJ Express</span>
            </h1>
            <p class="auth-brand-desc">
                Create your account and start tracking your parcels with ease. Fast, reliable, and always connected.
            </p>

            <div class="auth-brand-features">
                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="auth-feature-text">
                        <h6>Quick Setup</h6>
                        <p>Get started in less than a minute</p>
                    </div>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="auth-feature-text">
                        <h6>SMS Alerts</h6>
                        <p>Receive notifications via WhatsApp</p>
                    </div>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="auth-feature-text">
                        <h6>Seller Dashboard</h6>
                        <p>Manage all your orders in one place</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-brand-footer">
            <p>&copy; {{ date('Y') }} NUJ Express. All rights reserved.</p>
        </div>
    </div>

    <!-- Right Panel - Form -->
    <div class="auth-form-panel">
        <div class="auth-form-container">
            <div class="auth-form-header">
                <h1>Create Account</h1>
                <p>Fill in your details to get started</p>
            </div>

            <div class="auth-form-body">
                <x-forms.post :action="route('frontend.auth.register')">
                    @if(session('error'))
                        <div class="alert-modern error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="form-group-modern">
                        <div class="form-label-modern">
                            <label for="name">Full Name</label>
                        </div>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-input-modern"
                            placeholder="Enter your full name"
                            value="{{ old('name') }}"
                            style="text-transform: uppercase;"
                            maxlength="255"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group-modern">
                        <div class="form-label-modern">
                            <label>Preferred Collection Point</label>
                        </div>
                        <div class="radio-group">
                            @foreach($drop_points as $drop_point)
                                <label class="radio-item">
                                    <input
                                        type="radio"
                                        name="default_drop_point"
                                        id="drop_point_{{ $drop_point->id }}"
                                        value="{{ $drop_point->id }}"
                                        required
                                    />
                                    <span class="radio-label">{{ $drop_point->code }} - {{ $drop_point->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <div class="form-label-modern">
                            <label for="phone_number">Phone Number (WhatsApp)</label>
                        </div>
                        <input
                            type="text"
                            name="phone_number"
                            id="phone_number"
                            class="form-input-modern"
                            placeholder="e.g. 6738123456"
                            value="{{ old('phone_number') }}"
                            maxlength="15"
                            required
                        />
                        @error('phone_number')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                        <span class="form-note">* Must be a valid number starting with '673'</span>
                    </div>

                    <div class="form-group-modern">
                        <div class="form-label-modern">
                            <label for="email">Email Address</label>
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-input-modern"
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                            maxlength="255"
                            required
                            autocomplete="email"
                        />
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group-modern">
                        <div class="form-label-modern">
                            <label for="password">Password</label>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-input-modern"
                            placeholder="Create a password"
                            maxlength="255"
                            required
                        />
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group-modern">
                        <div class="form-label-modern">
                            <label for="password_confirmation">Confirm Password</label>
                        </div>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-input-modern"
                            placeholder="Confirm your password"
                            maxlength="255"
                            required
                        />
                        @error('password_confirmation')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group-modern">
                        <div class="form-check-modern">
                            <input
                                type="checkbox"
                                name="terms"
                                id="terms"
                                value="1"
                                required
                            />
                            <label for="terms">
                                I agree to the <a href="{{ route('frontend.pages.terms') }}" target="_blank">Terms & Conditions</a>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn-auth">
                        <i class="fas fa-user-plus"></i>
                        Create Account
                    </button>
                </x-forms.post>
            </div>

            <div class="auth-form-footer">
                <p>Already have an account? <a href="{{ route('frontend.auth.login') }}">Sign In</a></p>
            </div>

            <div class="auth-form-footer" style="margin-top: 16px;">
                <p style="font-size: 13px; color: #9ca3af;">Developed by <a href="https://www.facebook.com/hannan.yusop" target="_blank" style="color: #00c6a7;">Hannan Yusop</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
