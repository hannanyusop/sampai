<?php

namespace App\Http\Livewire\Setting;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ManageStorage extends Component
{
    public $year = null, $month = null;
    public $months = [];
    public $years = [];

    public $data = [];

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

    public function getData()
    {

        $this->data = [];
        $month = 1;
        do {

            //add 0 to month if less than 10
            $month_path = str_pad($month, 2, '0', STR_PAD_LEFT);
            $path = 'invoice/' . $this->year . '/' . $month_path;
            $this->data[] = [
                'key'    => $month,
                'year'   => $this->year,
                'month'  => $this->months[$month],
                'path'   => $path,
                'exists' => Storage::disk('public')->exists($path)
            ];
            $month++;
        } while ($month <= 12);
    }

    public function deletePath($month, $path)
    {
        $parse_date = $this->year.'-'.$month.'-01';

        if(strtotime($parse_date) > strtotime(date('Y-m-d', strtotime('-3 months')))){
            return redirect(route('admin.setting.storage'))->with('error', 'You can not delete data less than 3 months');
        }
        Storage::disk('public')->deleteDirectory($path);
        $this->getData();
    }
}
