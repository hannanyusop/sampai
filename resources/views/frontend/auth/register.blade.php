@extends('frontend.layouts.auth')

@section('title', __('Buat akaun'))

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
                        <div class="brand-logo text-center">
                            <a href="" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/logo.png') }}"  alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="{{ asset('images/logo-dark.png') }}" alt="logo-dark">
                            </a>
                        </div>
                        <h6 class="card-title text-center">Getting Started With {{ env('APP_NAME') }} Is Free And Takes 57 Seconds</h6>
                        <x-forms.post :action="route('frontend.auth.register')">

                            @if(session('error'))
                                <div class="alert alert-danger alert-icon alert-dismissible">
                                    <em class="icon ni ni-cross-circle"></em> <strong>Failed to create  account</strong>!  {{ session('error') }} <button class="close" data-dismiss="alert"></button>
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="name">Full Name</label>
                                </div>
                                <input type="text" name="name" id="name" class="form-control form-control-lg text-uppercase" placeholder="Full Name" value="{{ old('name') }}" maxlength="255" required autofocus autocomplete="name" />
                                @error('name')
                                <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                @enderror
                            </div><!-- .foem-group -->

                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="password">E-mail</label>
                                </div>
                                <input type="email" name="email" id="email" class="form-control form-control-lg" value="{{ old('email') }}" maxlength="255" required autofocus autocomplete="email" />
                                @error('email')
                                <span id="fv-email-error" class="invalid">{{ $message }}</span>
                                @enderror
                            </div><!-- .foem-group -->

                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <input type="password" name="password" id="password" class="form-control form-control-lg" value="" maxlength="255" required />
                                @error('password')
                                <span id="password_error" class="invalid">{{ $message }}</span>
                                @enderror
                            </div><!-- .foem-group -->

                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="password_confirmation">Password Confirmation</label>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" value="" maxlength="255" required>
                                @error('password_confirmation')
                                <span id="fv-ic_no-error" class="invalid">{{ $message }}</span>
                                @enderror
                            </div><!-- .foem-group -->

                            <div class="form-group row">
                                <div class="form-check">
                                    <input type="checkbox" name="terms" value="1" id="terms" class="form-check-input" required>
                                    <label class="form-check-label" for="terms">
                                        @lang('I agree with') <a href="{{ route('frontend.pages.terms') }}" target="_blank">@lang('Term & Condition')</a>
                                    </label>
                                </div>
                            </div><!--form-group-->

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" type="submit">@lang('Register')</button>
                                </div>
                            </div><!--form-group-->
                        </x-forms.post>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <span class="fw-500 text-white">Already have an account? <a class="text-success" href="{{ route('frontend.auth.login') }}">Login Now </a>    </span>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection


