<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Http\Controllers\Controller;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if(auth()->user()->can('admin.access.user')){

            return view('backend.dashboard-admin');
        }elseif (auth()->user()->can('staff.distributor')){

            $trips = Trip::whereIn('status', [0,1])->get();

            $total_current_month = 0;
            $month = 1;
            $pr = array();
            do{
                $count = Parcels::whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', $month)->count();

                array_push($pr, $count);

                if($month == date('m')){
                    $total_current_month = $count;
                }

                $month++;
            }while($month <= 12);

            $avg = (int)(array_sum($pr)/12);

            return view('backend.dashboard-distributor', compact('trips', 'pr', 'total_current_month', 'avg'));

        }elseif (auth()->user()->can('staff.runner')){

            $trips = Trip::whereIn('status', [1,2])->get();     

            return view('backend.dashboard-runner', compact('trips'));
        }elseif ('staff.inhouse'){

            $data =  [
                'all' => Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.trip_id')->whereNotIn('parcels.status', [0    ])->count(),
                'delivered' => Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.trip_id')->where('parcels.status', 4)->count(),
                'ready' => Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.trip_id')->where('parcels.status', 3)->count(),
                'return' => Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.trip_id')->where('parcels.status', 5)->count(),
                'otw' => Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.trip_id')->whereIn('parcels.status', [1,2])->count(),
            ];

            $trips = Trip::whereIn('status', [4,3])->where('destination_id', auth()->user()->office_id)->get();

            return view('backend.dashboard', compact('trips', 'data'));

        }

    }
}
