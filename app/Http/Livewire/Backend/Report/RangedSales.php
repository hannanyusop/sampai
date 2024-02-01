<?php

namespace App\Http\Livewire\Backend\Report;

use App\Models\DailySale;
use Carbon\Carbon;
use Livewire\Component;

class RangedSales extends Component
{

    public $from = null, $to = null, $office_id = null, $sales = [];

    public $total_sales = 0, $expected_sales = 0, $cash_received = 0, $bank_transfer = 0 , $total_days = 0;

    public function render()
    {
        return view('livewire.backend.report.ranged-sales');
    }

    public function filter()
    {
$this->validate([
            'from' => 'required',
            'to' => 'required|after:from',
            'office_id' => 'required|exists:offices,id',
        ]);

        $from = Carbon::parse($this->from)->format('Y-m-d');
        $to = Carbon::parse($this->to)->format('Y-m-d');

        $this->total_days = Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to));

        if ($from > $to) {
            $this->addError('from', 'From date cannot be greater than to date');
            return;
        }

        $this->sales = DailySale::where('office_id', $this->office_id)
            ->whereBetween('sales_date', [Carbon::parse($this->from), Carbon::parse($this->to)])
            ->get();

        $this->total_sales = $this->sales->sum('total_sales');
        $this->expected_sales = $this->sales->sum('expected_sales');
        $this->cash_received = $this->sales->sum('cash_received');
        $this->bank_transfer = $this->sales->sum('bank_transfer');

    }
}
