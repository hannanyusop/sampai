@extends('frontend.layouts.auth')

@section('title', __('Reset Password'))

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
                            <a href="" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/logo.png') }}"  alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="{{ asset('images/logo.png') }}" alt="logo-dark">
                            </a>
                        </div>
                        <h5 class="text-center">Reset Password</h5>

                        <x-forms.post :action="route('frontend.auth.password.email')">

                            @include('includes.partials.messages')
                            @if(session('error'))
                                    <div class="alert alert-danger alert-icon alert-dismissible">
                                        <em class="icon ni ni-cross-circle"></em> <strong>Failed to reset  password</strong>!  {{ session('error') }} <button class="close" data-dismiss="alert"></button>
                                    </div>
                            @endif

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
                                <button type="submit" class="btn btn-lg btn-success btn-block btn-round">@lang('Send Password Reset Link')</button>
                            </div>
                        </x-forms.post>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <span class="fw-500 text-white mb-5">Already have an account? <a class="text-success" href="{{ route('frontend.auth.login') }}">Login Now </a>    </span>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection
