<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Http\Controllers\Controller;
use App\Services\TripBatch\TripBatchHelperService;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{

    public function index()
    {
        if(auth()->user()->can('admin.access.user')){

            return view('backend.dashboard-admin');
        }elseif (auth()->user()->can('staff.distributor')){

            //status 0,1
            $trips = Trip::wherehas('batch',
                fn ($q) => $q->whereIn('status', [TripBatchHelperService::STATUS_PENDING]))
            ->get();

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

            $picks  = Trip::wherehas('batch',
                fn ($q) => $q->where('status', TripBatchHelperService::STATUS_PENDING))
                ->get();

            $transfers = Trip::wherehas('batch',
                fn ($q) => $q->whereIn('status', [TripBatchHelperService::STATUS_TRANSFERED]))
                ->get();

            $total = [
                'current' => Trip::whereYear('created_at', date('Y'))->count(),
                'prev' => Trip::whereYear('created_at', date('Y')-1)->count()
            ];

            return view('backend.dashboard-runner', compact('picks', 'transfers', 'total'));
        }elseif ('staff.inhouse'){

            $data =  [
                'all' => Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.trip_id')->whereNotIn('parcels.status', [0])->count(),
                'delivered' => Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.trip_id')->where('parcels.status', 4)->count(),
                'ready' => Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.trip_id')->where('parcels.status', 3)->count(),
                'return' => Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.trip_id')->where('parcels.status', 5)->count(),
                'otw' => Parcels::leftJoin('trips', 'trips.id', '=', 'parcels.trip_id')->whereIn('parcels.status', [1,2])->count(),
            ];

            //status in 3,4
            $trips = Trip::wherehas('batch',
                fn ($q) => $q->where('status', TripBatchHelperService::STATUS_PENDING))
                ->get()->where('destination_id', auth()->user()->office_id)->get();

            return view('backend.dashboard', compact('trips', 'data'));

        }

    }
}
