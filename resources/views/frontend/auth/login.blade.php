@extends('frontend.layouts.auth')

@section('title', __('Login'))

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
                Welcome back to<br>
                <span>NUJ Express</span>
            </h1>
            <p class="auth-brand-desc">
                Track your parcels in real-time, manage deliveries, and stay informed every step of the way.
            </p>

            <div class="auth-brand-features">
                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="auth-feature-text">
                        <h6>Real-Time Tracking</h6>
                        <p>Track parcels 24/7 with live updates</p>
                    </div>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="auth-feature-text">
                        <h6>Instant Notifications</h6>
                        <p>Get SMS alerts when parcels arrive</p>
                    </div>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="auth-feature-text">
                        <h6>Secure & Reliable</h6>
                        <p>Your parcels are in safe hands</p>
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
                <h1>Sign In</h1>
                <p>Enter your credentials to access your account</p>
            </div>

            <div class="auth-form-body">
                <x-forms.post :action="route('frontend.auth.login')">
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
                            autofocus
                            autocomplete="email"
                        />
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group-modern">
                        <div class="form-label-modern">
                            <label for="password">Password</label>
                            <a href="{{ route('frontend.auth.password.request') }}">Forgot Password?</a>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-input-modern"
                            placeholder="Enter your password"
                            required
                        />
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group-modern">
                        <div class="form-check-modern">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            />
                            <label for="remember">Remember me</label>
                        </div>
                    </div>

                    @if(config('boilerplate.access.captcha.login'))
                        <div class="form-group-modern">
                            @captcha
                            <input type="hidden" name="captcha_status" value="true" />
                        </div>
                    @endif

                    <button type="submit" class="btn-auth">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In
                    </button>
                </x-forms.post>
            </div>

            @if(registrationEnabled())
                <div class="auth-form-footer">
                    <p>Don't have an account? <a href="{{ route('frontend.auth.register') }}">Create Account</a></p>
                </div>
            @endif

            <div class="auth-form-footer" style="margin-top: 16px;">
                <p style="font-size: 13px; color: #9ca3af;">Developed by <a href="https://www.facebook.com/hannan.yusop" target="_blank" style="color: #00c6a7;">Hannan Yusop</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
