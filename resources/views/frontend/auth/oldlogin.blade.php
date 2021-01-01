@extends('frontend.layouts.auth')

@section('title', __('Login'))

@section('content')
    <style>
        .bc{

            /*filter: blur(8px);*/
            /*-webkit-filter: blur(8px);*/

            /* Full height */
            /*height: 100%;*/

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            /*background-size: cover;*/

            background-size: 100% 100%;
            background-image: url('{{ asset('images/sampai.jpg') }}')
        }

        .bg-text {
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(110, 107, 107, 0.4); /* Black w/opacity/see-through */
            color: white;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 80%;
            padding: 20px;
            text-align: center;
        }
    </style>
    <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container">
        <div class="absolute-top-right d-lg-none p-3 p-sm-5">
            <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
        </div>
        <div class="nk-block nk-block-middle nk-auth-body">
            <div class="brand-logo pb-5">
                <a href="" class="logo-link">
                    <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/logo.png') }}"  alt="logo">
                    <img class="logo-dark logo-img logo-img-lg" src="{{ asset('images/logo-dark.png') }}" alt="logo-dark">
                </a>
            </div>
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h5 class="nk-block-title">Log Masuk</h5>
                    <div class="nk-block-des">
                        <p>Access the panel using your email and password.</p>
                    </div>
                </div>
            </div><!-- .nk-block-head -->
            {{--            @include('includes.partials.messages')--}}
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
                        <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                        </a>
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
                    <button type="submit" class="btn btn-lg btn-primary btn-block">Log Masuk</button>
                </div>
            </x-forms.post><!-- form -->

            <div class="text-center mt-5">
                <span class="fw-500">Tidak mempunyai akaun?  <a href="{{ route('frontend.auth.register') }}">Daftar akaun percuma </a></span>
            </div>
        </div><!-- .nk-block -->
    </div>
    <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right bc" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
        <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto text-center text-white" >
            <div class="bg-text">
                <h3>sampai @ utem</h3>
                <h6>Tagline</h6>
            </div>
        </div><!-- .slider-wrap -->
    </div><!-- .nk-split-content -->
@endsection
