@extends('frontend.layouts.auth')

@section('title', __('Login'))

@section('content')
    <style>
    #body {
        background: #051d39!important;
    }

    .card-signin {
        border: 0;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
    }

    .card-signin .card-title {
        margin-bottom: 2rem;
        font-weight: 300;
        font-size: 1.5rem;
    }

    .card-signin .card-body {
        padding: 2rem;
    }

    .form-signin {
        width: 100%;
    }
</style>
    <body id="body">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-6 col-lg-5 mx-auto">

                <div class="card card-signin my-5">
                    <div class="card-body">
                        <div class="brand-logo text-center mb-2">
                            <a href="{{ route('frontend.index') }}" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/logo.png') }}"  alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="{{ asset('images/logo.png') }}" alt="logo-dark">
                            </a>
                        </div>
                        <h5 class="card-title text-center">Sign In</h5>
                        <x-forms.post :action="route('frontend.auth.login')">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="ic_no">Email</label>
                                </div>
                                <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="{{ __('Email') }}" value="{{ old('email') }}" maxlength="255" required autofocus autocomplete="email" />
                                @error('email')
                                <span id="fv-ic_no-error" class="invalid">{{ $message }}</span>
                                @enderror
                            </div><!-- .foem-group -->
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="password">Password</label>
                                    <a class="link link-primary link-sm" tabindex="-1" href="{{ route('frontend.auth.password.request') }}">Forgot Password?</a>
                                </div>
                                <div class="form-control-wrap">
                                    <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Password">
                                    @error('password')
                                    <span id="fv-password-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input name="remember" id="remember" class="form-check-input" type="checkbox" {{ old('remember') ? 'checked' : '' }} />

                                        <label class="form-check-label" for="remember">
                                            @lang('Remember Me')
                                        </label>
                                    </div><!--form-check-->
                                </div>
                            </div><!--form-group-->


                            @if(config('boilerplate.access.captcha.login'))
                                <div class="row">
                                    <div class="col">
                                        @captcha
                                        <input type="hidden" name="captcha_status" value="true" />
                                    </div><!--col-->
                                </div><!--row-->
                            @endif
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-success btn-block btn-round">Login</button>
                            </div>
                        </x-forms.post>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <span class="fw-500 text-white">Don't have an account yet? <a class="text-success" href="{{ route('frontend.auth.register') }}">Sign up Here</a></span>
                </div>
            </div>
        </div>
    </div>
    </body>

@endsection
