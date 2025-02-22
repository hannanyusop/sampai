<?php

namespace App\Http\Livewire\Setting;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\ParcelTransaction;
use App\Jobs\DeletePickupsJob;
use App\Models\Pickup;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Pickup\PickupHelperService;
use Kreait\Firebase\Database\Transaction;
use Livewire\Component;

class ManageData extends Component
{
    public $pickups = [];
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

        $this->getData();

    }

    public function render()
    {
        return view('livewire.setting.manage-data');
    }

    public function getData()
    {
        $month = 1;

        do{
            $delivered = Pickup::whereYear('created_at', $this->year)
                ->where('status', PickupHelperService::STATUS_DELIVERED)
                ->whereMonth('created_at', $month)
                ->count();

            $not_delivered = Pickup::whereYear('created_at', $this->year)
                ->where('status','!=', PickupHelperService::STATUS_DELIVERED)
                ->whereMonth('created_at', $month)
                ->count();

            $pickups[] = [
                'key'           => $month,
                'month'         => $this->months[$month]." ".$this->year,
                'delivered'     => $delivered,
                'not_delivered' => $not_delivered,
            ];

            $month++;

        }while($month <= 12);

        $this->pickups = $pickups;
    }

    public function deleteData($month)
    {

        $parse_date = $this->year.'-'.$month.'-01';

        //check if date is less than 3 months

        if(strtotime($parse_date) > strtotime(date('Y-m-d', strtotime('-3 months')))){
            return redirect(route('admin.setting.file'))->with('error', 'You can not delete data less than 3 months');
        }

        $pickup_query = Pickup::whereYear('created_at', $this->year)
            ->where('status', PickupHelperService::STATUS_DELIVERED)
            ->whereMonth('created_at', $month);

        $pickup_ids   = $pickup_query->select('id')->get()->pluck('id');
        $parcel_query = Parcels::whereIn('pickup_id', $pickup_ids);
        $parcel_ids   = $parcel_query->select('id')->get()->pluck('id');
        $transaction_query = ParcelTransaction::whereIn('parcel_id', $parcel_ids);

        $transaction_query->delete();
        $parcel_query->delete();
        $pickup_query->delete();

        $this->getData();
    }
}
