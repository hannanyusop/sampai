<?php

namespace App\Services\Sales;

use App\Domains\Auth\Models\Office;
use App\Models\DailySale;
use Carbon\Carbon;

class DailySaleGeneralService
{
    public static function query()
    {
        return DailySale::query();
    }

    public static function create(int $office_id) : array
    {
        $office = Office::find($office_id);

        if(!$office){
            return ['status' => 'error', 'message' => 'Office not found!', 'code' => 404];
        }

        $sale = DailySale::where('office_id', $office_id)->whereDate('sales_date', Carbon::today())->first();

        if($sale){
            return ['status' => 'success', 'message' => 'Sale already created', 'data' => $sale, 'code' => 200];
        }

        try {

            $sale = new DailySale();
            $sale->office_id = $office_id;
            $sale->sales_date = Carbon::today();
            $sale->save();
            return ['status' => 'success', 'message' => 'Sale created successfully', 'data' => $sale, 'code' => 200];

        }catch (\Exception $e){
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 500];
        }
    }
}
