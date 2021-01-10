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
                        <a href="{{ route('frontend.index') }}" class="logo-link">
                            <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/logo.png') }}"  alt="logo">
                            <img class="logo-dark logo-img logo-img-lg" src="{{ asset('images/logo.png') }}" alt="logo-dark">
                        </a>
                    </div>
                    <h5 class="text-center">Reset Password</h5>

                    <x-forms.post :action="route('frontend.auth.password.update')">

                        @include('includes.partials.messages')

                        <input type="hidden" name="token" value="{{ $reset->token }}" />


                        <div class="form-group">
                            <div class="form-label-group">
                                <label class="form-label" for="email">Email</label>
                            </div>
                            <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ $reset->email }}" maxlength="255" disabled>
                            @error('email')
                                <span id="fv-name-error" class="invalid">{{ $message }}</span>
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


                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-success btn-block btn-round">Reset Password</button>
                        </div>
                    </x-forms.post>
                </div>
            </div>

            <div class="text-center mt-3">
                <span class="fw-500 text-white mb-5">Already remember password? <a class="text-success" href="{{ route('frontend.auth.login') }}">Login Now </a>    </span>
            </div>
        </div>
    </div>
</div>
</body>
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
@endsection
