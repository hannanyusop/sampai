<?php

namespace App\Http\Livewire\Account;

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

        auth()->user()->update([
            'password' => bcrypt($this->password),
        ]);

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        session()->flash('success', 'Password updated successfully.');
    }
}
