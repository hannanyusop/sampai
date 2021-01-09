@php $extend = (auth()->user()->type == 'user')? 'frontend.layouts.app' :  'backend.layouts.app'; @endphp

@extends($extend)

@section('title', __('My Account'))

@section('content')
    <div class="nk-content-body">
        <div class="nk-content-wrap">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <div class="nk-block-head-sub"><span>Account Setting</span></div>
                    <h2 class="nk-block-title fw-normal">My Profile</h2>
                    <div class="nk-block-des">
                        <p>You have full control to manage your own account setting. <span class="text-primary"><em class="icon ni ni-info"></em></span></p>
                    </div>
                </div>
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Personal Information</h5>
                        <div class="nk-block-des">
                            <p>Basic info, like your name and address, that you use on {{ env('APP_NAME') }}.</p>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <div class="card card-bordered">
                    <div class="nk-data data-list">
                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">Profile Image</span>
                                <span class="data-value">
                                    <img src="{{ $logged_in_user->avatar }}" class="user-profile-image" />
                                </span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div><!-- .data-item -->
                        <div class="data-item">
                            <div class="data-col">
                                <span class="data-label">Name</span>
                                <span class="data-value">{{ $logged_in_user->name }}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                        </div><!-- .data-item -->
                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">Email</span>
                                <span class="data-value text-soft">{{ $logged_in_user->email }}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div>
                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">Student/Staff ID </span>
                                <span class="data-value text-soft">{{ $logged_in_user->identification }}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div>
                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">Phone Number </span>
                                <span class="data-value text-soft">{{ $logged_in_user->phone_number }}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div>

                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">Address </span>
                                <span class="data-value text-soft">{{ $logged_in_user->address }}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div>

                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">Registered Date</span>
                                <span class="data-value">@displayDate($logged_in_user->created_at) ({{ $logged_in_user->created_at->diffForHumans() }})</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div><!-- .data-item -->
                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">Last Update</span>
                                <span class="data-value">@displayDate($logged_in_user->updated_at) ({{ $logged_in_user->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div><!-- .data-item -->
                    </div><!-- .nk-data -->
                </div><!-- .card -->
                <!-- Another Section -->
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Account Setting</h5>
                        <div class="nk-block-des">
                            <p>Your personalized preference allows you best use.</p>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <div class="card card-bordered">
                    <div class="nk-data data-list">
                        <div class="data-item">
                            <div class="data-col">
                                <span class="data-label">Password Last Change At</span>
                                <span class="data-value"> {{ (is_null($logged_in_user->password_changed_at))? "Not Yet" : $logged_in_user->password_changed_at->diffForHumans() }}</span>
                            </div>
                            <div class="data-col data-col-end"><a href="#" data-toggle="modal" data-target="#update-password" class="link link-primary">Update Password</a></div>
                        </div><!-- .data-item -->
                    </div><!-- .nk-data -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="profile-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Update Profile</h5>



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
                                        </div><!--form-group-->
                                    </div>
                                @endif

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="identification">@lang('Student/Staff ID')</label>
                                    <input type="text" name="identification" id="identification" class="form-control text-uppercase"  value="{{ old('identification') ?? $logged_in_user->identification }}" required autofocus>
                                    @error('identification')
                                    <span id="identification" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="phone_number">@lang('Phone Number')</label>
                                    <input type="text" name="phone_number" id="phone_number" class="form-control text-uppercase"  value="{{ old('phone_number') ?? $logged_in_user->phone_number }}" required autofocus>
                                    @error('phone_number')
                                        <span id="phone_number" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="address">@lang('Address')</label>
                                    <textarea name="address" id="address" class="form-control text-uppercase" required>{{ old('address') ?? $logged_in_user->address }}</textarea>
                                    @error('address')
                                        <span id="address" class="invalid">{{ $message }}</span>
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
                    </div><!-- .tab-pane -->

                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="update-password">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Update Password</h5>



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
                    </div><!-- .tab-pane -->

                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->

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
        });
    </script>
@endpush
