@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', __('Create User'))

@section('content')

    <div class="nk-block-head nk-block-head-lg wide-sm">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><a class="back-to" href="{{ route('admin.auth.user.index') }}"><em class="icon ni ni-arrow-left"></em><span>Users List</span></a></div>
            <h2 class="nk-block-title fw-normal">Create User</h2>
            <div class="nk-block-des">
                <p class="lead"></p>
            </div>
        </div>
    </div>

    <div class="nk-block nk-block-lg">
        <div class="card card-bordered">
            <div class="card-inner">
                <x-forms.post :action="route('admin.auth.user.store')">
                    <div class="row g-4">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="name">@lang('Name')</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="name" name="name" class="form-control text-uppercase" placeholder="{{ __('Name') }}" value="{{ old('name') }}" maxlength="100" required />
                                    @error('name')
                                    <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="email">@lang('E-mail')</label>
                                <div class="form-control-wrap">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" required />
                                    @error('email')
                                    <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="identification">@lang('Student/Staff ID')</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="identification" name="identification" class="form-control text-uppercase" placeholder="{{ __('') }}" value="{{ old('identification') }}" maxlength="15" required />
                                    @error('identification')
                                    <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="phone_number">@lang('Phone Number')</label>
                                <div class="form-control-wrap">
                                    <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="{{ __('Phone Number') }}" value="{{ old('phone_number') }}" maxlength="15" required />
                                    @error('phone_number')
                                    <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="password">@lang('Password')</label>
                                <div class="form-control-wrap">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Type Password') }}" value="" maxlength="255" required />
                                    @error('password')
                                        <span id="fv-password-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">@lang('Password Confirmation')</label>
                                <div class="form-control-wrap">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Re-type password') }}" value="" maxlength="255" required />
                                    @error('password_confirmation')
                                        <span id="fv-password_confirmation-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="email_verified">@lang('E-mail Verified')</label>
                                <div class="form-control-wrap">
                                    <ul class="custom-control-group g-3 align-center" >
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="active" {{ old('active', true) ? 'checked' : '' }}  value="1" id="active">
                                                <label class="custom-control-label" for="Active">@lang('Active')</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="email_verified" {{ old('email_verified') ? 'checked' : '' }} value="1" id="email_verified">
                                                <label class="custom-control-label" for="email_verified">@lang('Verified Email')</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="send_confirmation_email" {{ old('send_confirmation_email') ? 'checked' : '' }}  value="1" id="send_confirmation_email">
                                                <label class="custom-control-label" for="send_confirmation_email">@lang('Send Confirmation E-mail')</label>
                                            </div>
                                        </li>
                                    </ul>
                                    @error('email_verified')
                                        <span id="fv-password_confirmation-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                    @error('send_confirmation_email')
                                        <span id="fv-send_confirmation_email-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Type')</label>

                                <ul class="custom-control-group g-3 align-center">
                                    <li>
                                        <div class="custom-control custom-control-sm custom-radio">
                                            <input type="radio" class="custom-control-input" {{ old('type') === $model::TYPE_USER ? 'checked' : '' }} name="type" value="{{ $model::TYPE_USER }}" id="{{ $model::TYPE_USER }}">
                                            <label class="custom-control-label" for="{{ $model::TYPE_USER }}">@lang('User')</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-control-sm custom-radio">
                                            <input type="radio" class="custom-control-input" {{ old('type') === $model::TYPE_ADMIN ? 'checked' : '' }} name="type" value="{{ $model::TYPE_ADMIN }}" id="{{ $model::TYPE_ADMIN }}">
                                            <label class="custom-control-label" for="{{ $model::TYPE_ADMIN }}">@lang('Staff/Admin')</label>
                                        </div>
                                    </li>
                                </ul>
                                @error('type')
                                <span id="fv-type-error" class="invalid">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Roles')</label>

                                <div id="backend">
                                    <ul class="custom-control-group g-3 align-center">

                                        @foreach($roles as $role)
                                            <li>

                                                <div class="custom-control custom-control-sm custom-radio">
                                                    <input type="radio" class="custom-control-input" {{ (old('rules') && in_array($role->id, old('rules'), true)) || (isset($user) && in_array($role->id, $user->roles->modelKeys(), true)) ? 'checked' : '' }} name="roles" value="{{ $role->id }}" data-name="{{ $role->name }}" id="role_{{ $role->name }}">
                                                    <label class="custom-control-label" for="role_{{ $role->name }}">{{ $role->name }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>


                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">@lang('Permission')</label>

                                @foreach($arr as $roleName => $permissions)
                                    <div id="permission_{{ $roleName }}">
                                        <ul class="custom-control-group g-3 align-center" >

                                            @foreach($permissions->children as $permission)
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="permissions[]" value="{{ $permission->id }}" id="{{ $permission->name }}">
                                                        <label class="custom-control-label" for="{{ $permission->name }}">{{ $permission->description }}</label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary">@lang('Create User')</button>
                            </div>
                        </div>
                    </div>
                </x-forms.post>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script type="text/javascript">
        $(function () {

            $("#backend").hide();
            $("#permission_Administrator").hide();
            $("#permission_Staff").hide();

            $('input[name=roles]').change(function(){

                selected = $(this).data('name');

                if(selected == "Administrator"){
                    $("#permission_Administrator").show();
                    $("#permission_Staff").hide();

                }else if(selected == "Staff"){

                    $("#permission_Administrator").hide();
                    $("#permission_Staff").show();
                }else{
                    $("#permission_Administrator").hide();
                    $("#permission_Staff").hide();
                }

            })

            $('input[name=type]').change(function(){

                selected = $(this).val();

                if(selected == "admin"){
                    $("#backend").show();

                }else if(selected == "user"){

                    $("#backend").hide();
                }else{
                    $("#backend").hide();
                }

            })
        })
    </script>
@endpush

