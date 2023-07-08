<?php

namespace App\Imports\Parcel;

use App\Services\General\GeneralHelperService;
use App\Services\Parcel\ParcelGeneralService;
use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OfflineParcelImport implements ToCollection, WithHeadingRow
{

    //constructor
    public function __construct($tripBatch)
    {
        $this->tripBatch = $tripBatch;
    }

    public function collection(Collection $collection)
    {

        //check if header all exist
        //no_item, nama, trackin_no, harga, destination
        $header = $collection->first()->keys()->toArray();

        //get total data
        $total_data = $collection->count();

        $required_header = ['no_item', 'nama', 'tracking_no', 'harga', 'destinasi'];

        if (count(array_diff($required_header, $header)) > 0) {

            //get the missing header and return error
            $missing_header = array_diff($required_header, $header);
            return session()->flash('insert_'.GeneralHelperService::STATUS_ERROR, __('Missing header :missing_header', ['missing_header' => implode(', ', $missing_header)]));

        }

        //start db commit
        DB::beginTransaction();
        foreach ($collection as $parcel){

            $checking = ParcelGeneralService::insertableParcel( $parcel['tracking_no'] , $this->tripBatch);

            if ($checking[GeneralHelperService::KEY_STATUS] == GeneralHelperService::STATUS_ERROR) {
                DB::rollBack();
                return session()->flash('insert_'.GeneralHelperService::STATUS_ERROR, $checking[GeneralHelperService::KEY_MESSAGE]);
            }

            $inserting = ParcelGeneralService::assignToTripBatch($parcel['tracking_no'], $this->tripBatch);
            $parcel    = $inserting[GeneralHelperService::KEY_DATA];

            $parcel->receiver_name = $parcel['nama'];
            $parcel->price = $parcel['harga'];
            $parcel->save();
        }

        DB::commit();
        return session()->flash('insert_'.GeneralHelperService::STATUS_SUCCESS, __(':total_data parcel inserted', ['total_data' => $total_data]));
    }
}
