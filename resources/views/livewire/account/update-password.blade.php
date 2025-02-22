<div>
    <div class="tab-pane active" id="personal">
        <div class="row gy-4">

            <x-utils.alert type="info" class="col-12" :dismissable="false">
                This section still under development. Sorry for the inconvenience.
            </x-utils.alert>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label" for="current_password">@lang('Current Password')</label>
                    <input type="password" name="current_password" wire:model="current_password" id="current_password" class="form-control" placeholder="{{ __('Current Password') }}" maxlength="100" autofocus />
                    @error('current_password')
                    <span id="address" class="invalid">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label" for="password">@lang('New Password')</label>
                    <input type="password" name="password" wire:model="password" id="password" class="form-control" placeholder="{{ __('New Password') }}" maxlength="100" />
                    @error('password')
                    <span id="address" class="invalid">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">@lang('New Password Confirmation')</label>
                    <input type="password" name="password_confirmation" wire:model="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('New Password Confirmation') }}" maxlength="100" />
                    @error('password_confirmation')
                    <span id="address" class="invalid">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-12 m-2">
                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
{{--                    <li>--}}
{{--                        <button wire:click="updatePassword()" class="btn btn-sm btn-primary float-right">@lang('Change Password')</button>--}}
{{--                    </li>--}}
                    <li>
                        <a href="{{ route('frontend.user.account') }}" class="link link-light">Back</a>
                    </li>
                </ul>
            </div>
        </div>
    </div><!-- .tab-pane -->
</div>
