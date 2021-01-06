<?php
namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Models\Parcels;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller{

    public function monthly(Request $request){

        if(!$request->year){
            return redirect()->route('admin.report.monthly', ['year' => date('Y')]);
        }


        if($request->office_id){
            $office_id = $request->office_id;
        }else{
            $office_id = [];
        }

        $year = $request->year;

        $month = 1; $data = array();

        $table = [];

        do{

            $process = Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.id')
                ->whereYear('parcels.created_at', $year)
                ->whereMonth('parcels.created_at', $month)
                ->whereIn('parcels.status', [0,1,2])
                ->whereIn('destination_id', $office_id)
                ->count();

            $pending = Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.id')
                ->whereYear('parcels.created_at', $year)
                ->whereMonth('parcels.created_at', $month)
                ->whereIn('destination_id', $office_id)
                ->where('parcels.status', 3)
                ->count();

            $completed = Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.id')
                ->whereYear('parcels.created_at', $year)
                ->whereMonth('parcels.created_at', $month)
                ->whereIn('destination_id', $office_id)
                ->where('parcels.status', 4)
                ->count();

            $return = Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.id')
                ->whereYear('parcels.created_at', $year)
                ->whereMonth('parcels.created_at', $month)
                ->whereIn('destination_id', $office_id)
                ->where('parcels.status', 5)
                ->count();

            $count = Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.id')
                ->whereYear('parcels.created_at', $year)
                ->whereMonth('parcels.created_at', $month)
                ->whereIn('destination_id', $office_id)
                ->count();

            $table[$year." - ".$month] = [
                'process' => $process,
                'pending' =>  $pending,
                'completed' => $completed,
                'return' => $return,
                'total' => $count,
            ];

            $month++;

            array_push($data, $count);
        }while($month <= 12);

        return view('backend.report.monthly', compact('data', 'year', 'table'));
    }
}
