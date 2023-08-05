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
                        <div class="brand-logo text-center mb-2">
                            <a href="{{ route('frontend.index') }}" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/logo.png') }}"  alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="{{ asset('images/logo.png') }}" alt="logo-dark">
                            </a>
                        </div>
                        <p class="">Getting Started With {{ env('APP_NAME') }} Is Free And Takes 57 Seconds</p>
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
                                <input type="text" name="name" id="name" class="form-control form-control-lg text-uppercase" value="{{ old('name') }}" maxlength="255" required autofocus autocomplete="name" />
                                @error('name')
                                <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                @enderror
                            </div><!-- .foem-group -->


                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="identification">Preferred Collection point</label>
                                </div>

                                <div class="mb-3">
                                    @foreach($drop_points as $drop_point)
                                        <div class="form-check">
                                            <input type="radio" name="default_drop_point" id="drop_point_{{ $drop_point->id }}" value="{{ $drop_point->id }}" class="form-check-input">
                                            <lable class="form-check-label">{{ $drop_point->code." - ".$drop_point->name }}</lable>
                                        </div>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="phone_number">Phone Number (WhatsApp)</label>
                                </div>
                                <input type="text" name="phone_number" id="phone_number" class="form-control form-control-lg text-uppercase" value="{{ old('phone_number') }}" maxlength="15" required>
                                @error('phone_number')
                                    <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                @enderror
                                <br><small class="text-info font-weight-bold">*Contact must be a valid number starting with '6'</small>
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

                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" name="terms" value="1" id="terms" class="form-check-input" required>
                                    <label class="form-check-label" for="terms">
                                        @lang('I agree with') <a href="{{ route('frontend.pages.terms') }}" target="_blank">@lang('Term & Condition')</a>
                                    </label>
                                </div>
                            </div><!--form-group-->

                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-success btn-block btn-round">Create Account</button>
                                </div>
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


