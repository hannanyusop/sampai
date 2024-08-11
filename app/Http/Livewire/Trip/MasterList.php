<?php

namespace App\Http\Livewire\Trip;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Parcels;
use App\Exports\Trip\MasterListExport;
use App\Exports\Trip\WhatsappBotExport;
use App\Models\TripBatch;
use App\Services\Parcel\ParcelHelperService;
use Cknow\Money\Money;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;


class MasterList extends Component
{
    //use bootstrap template for pagination

    protected $paginationTheme = 'bootstrap';

    use WithPagination;
    public $selected_parcel;
    public $trip_batch;
    public $trip, $tax, $trip_ids = [], $service_charge = 0.00, $percent = 0.00, $price = 0.00, $currency_exchange = 0.00, $permit = 0.00, $declare_charge = 0.00, $cod_fee = 0.00;
    public $cod_fee_ori;
    public $tracking_no, $edited_id = 0;
    public $drop_point_id, $drop_points = [];

    public bool $edit_rate = false;
    public $tax_rate = 0.00, $pos_rate = 0.00;

    public function mount($trip_id)
    {
        $this->trip_batch = TripBatch::with('trips')->findOrFail($trip_id);

        $this->drop_points = Office::where('is_drop_point', true)->get();


        $this->currency_exchange = $this->trip_batch->tax_rate;

        $this->trip_ids = $this->trip_batch->trips()->pluck('id');

        $this->tax_rate = $this->trip_batch->tax_rate;
        $this->pos_rate = $this->trip_batch->pos_rate;
    }

    public function render()
    {
        $parcels = Parcels::whereHas('pickup', function($query){
            $query->whereIn('trip_id', $this->trip_ids);
        })->when($this->tracking_no, function ($query) {
            $query->where('tracking_no', 'like', '%' . $this->tracking_no . '%');
        })
            ->when($this->drop_point_id, function ($query) {
                $query->where('office_id', $this->drop_point_id);
            })
            ->orderBy('user_id', 'asc')
            ->paginate(20);

        return view('livewire.trip.master-list', compact('parcels'));
    }

    public function changeEditedId($id)
    {

        $parcel = Parcels::whereHas('pickup', function($query){
            $query->whereIn('trip_id', $this->trip_ids);
        })->find($id);

        if(!$parcel){
            session()->flash('error', 'Parcel not found.');
            return;
        }

        $this->selected_parcel = $parcel;

        $this->edited_id = $parcel->id;
        $this->tax = $parcel->tax;
        $this->price = $parcel->price;
        $this->percent = $parcel->percent;
        $this->service_charge = $parcel->service_charge;
        $this->permit = $parcel->permit;
        $this->cod_fee = $parcel->cod_fee;
        $this->declare_charge = $parcel->declare_charge;
    }

    public function updateTax()
    {
        $this->validate([
            'price'          => 'required|numeric|min:0.00',
            'percent'        => 'required|numeric|min:0|max:100',
            'service_charge' => 'required|numeric|min:0.00',
            'permit'         => 'required|numeric|min:0.00',
            'cod_fee'    => 'required|numeric|min:0.00',
            'declare_charge' => 'required|numeric|min:0.00',
        ]);


        $parcel = Parcels::whereHas('pickup', function($query){
            $query->whereIn('trip_id', $this->trip_ids);
        })->find($this->edited_id);

        if(!$parcel){
             session()->flash('error', 'Parcel not found.');
             return;
        }

        if($parcel->status == ParcelHelperService::STATUS_DELIVERED){
            session()->flash('error', 'Cannot edit delivered parcel information.');
            return;
        }

        $parcel->tax = ParcelHelperService::CalculateTax($this->price,$this->currency_exchange, $this->percent);
        $parcel->price = $this->price;
        $parcel->percent = $this->percent;
        $parcel->service_charge = $this->service_charge;
        $parcel->permit = $this->permit;
        $parcel->cod_fee = $this->cod_fee;
        $parcel->declare_charge = $this->declare_charge;
        $parcel->save();

        $this->edited_id = null;
        $this->selected_parcel = null;
        $this->tax = null;
        $this->service_charge = 0.00;
        $this->percent = 0.00;
        $this->price = 0.00;
        $this->permit = 0.00;
        $this->cod_fee = 0.00;
        $this->declare_charge = 0.00;

        session()->flash('success', __('Billing For :tracking_no updated!', ['tracking_no' => $parcel->tracking_no]));
    }

    public function updateTaxValue(){
        $this->tax = ParcelHelperService::CalculateTax($this->price,$this->currency_exchange, $this->percent);
    }

    public function export(){
        return Excel::download(new MasterListExport($this->trip_batch), time()."_".$this->trip_batch->number.'.xlsx');
    }

    public function exportWhatsappBot($tripId = null){

        return Excel::download(new WhatsappBotExport($this->trip_batch, $tripId), time()."_".$this->trip_batch->number.'.xlsx');
    }

    public function editRate(){
        $this->edit_rate = true;
    }

    public function saveRate(){

        $this->trip_batch->update([
            'tax_rate' => $this->tax_rate,
            'pos_rate' => $this->pos_rate
        ]);

        session()->flash("success", "Data updated!");
        $this->edit_rate = false;
    }
}
