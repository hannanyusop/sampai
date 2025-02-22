<?php

namespace App\Http\Livewire\Setting;

use Livewire\Component;

class ManageStorage extends Component
{
    public $year = null, $month = null;
    public $months = [];
    public $years = [];

    public function mount()
    {
        $this->year = date('Y');
        $this->month = date('m');

        $this->months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        $this->years = range(date('Y') - 2, date('Y'));

    }

    public function render()
    {
        return view('livewire.setting.manage-storage');
    }
}
