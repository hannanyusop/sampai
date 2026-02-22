<?php

namespace App\Http\Livewire\Account;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UpdatePassword extends Component
{
    public $current_password, $password, $password_confirmation;

    public function render()
    {
        return view('livewire.account.update-password');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if (! Hash::check($this->current_password, auth()->user()->password)) {
            $this->addError('current_password', __('The current password is incorrect.'));
            return;
        }

        auth()->user()->update([
            'password' => bcrypt($this->password),
            'password_changed_at' => now(),
        ]);

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        session()->flash('success', 'Password updated successfully.');
    }
}
