<div>
    @if (session()->has('success'))
        <div class="success-alert">
            <i class="ni ni-check-circle" style="font-size: 1.1rem;"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="password-card">
        <div class="form-field">
            <label for="current_password">{{ __('Current Password') }}</label>
            <input type="password" wire:model="current_password" id="current_password" class="form-input" placeholder="{{ __('Enter current password') }}" maxlength="100">
            @error('current_password')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-field">
            <label for="password">{{ __('New Password') }}</label>
            <input type="password" wire:model="password" id="password" class="form-input" placeholder="{{ __('Enter new password') }}" maxlength="100">
            @error('password')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-field">
            <label for="password_confirmation">{{ __('Confirm New Password') }}</label>
            <input type="password" wire:model="password_confirmation" id="password_confirmation" class="form-input" placeholder="{{ __('Confirm new password') }}" maxlength="100">
            @error('password_confirmation')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="password-actions">
            <button wire:click="updatePassword()" class="btn-save-pw">{{ __('Update Password') }}</button>
            <a href="{{ route('frontend.user.account') }}" class="btn-back-pw">
                <i class="ni ni-arrow-left"></i> {{ __('Back') }}
            </a>
        </div>
    </div>
</div>
