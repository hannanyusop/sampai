<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Http\Controllers\Controller;
use App\Models\TripBatch;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Trip\TripHelperService;
use App\Services\TripBatch\TripBatchGeneralService;
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


            $trip_batches = TripBatchGeneralService::query()->wherehas('trips',
                fn ($q) => $q->whereIn('status', [TripBatchHelperService::STATUS_PENDING]))
                ->orderBy('id', 'desc')
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

            return view('backend.dashboard-distributor', compact('trip_batches', 'pr', 'total_current_month', 'avg'));

        }elseif (auth()->user()->can('staff.runner')){

            $closed_trips = TripBatchGeneralService::getByStatus([TripHelperService::STATUS_CLOSED])->get();

            $picked_trips = TripBatchGeneralService::getByStatus([TripBatchHelperService::STATUS_IN_TRANSIT])
                ->get();

            $total = [
                'current' => Trip::whereYear('created_at', date('Y'))->count(),
                'prev' => Trip::whereYear('created_at', date('Y')-1)->count()
            ];

            return view('backend.dashboard-runner', compact('closed_trips', 'picked_trips', 'total'));
        }elseif (auth()->user()->can('staff.inhouse')){

            $data =  [
                'all' => Parcels::whereNotIn('status', [ParcelHelperService::STATUS_REGISTERED])->count(),
                'delivered' => Parcels::where('status', ParcelHelperService::STATUS_DELIVERED)->count(),
                'ready' => Parcels::where('status', ParcelHelperService::STATUS_READY_TO_COLLECT)->count(),
                'return' => Parcels::where('parcels.status', ParcelHelperService::STATUS_RETURN)->count(),
                'otw' => Parcels::whereIn('parcels.status', [ParcelHelperService::STATUS_RECEIVED,ParcelHelperService::STATUS_OUTBOUND_TO_DROP_POINT])->count(),
            ];

            $trips = Trip::whereIn('status', [TripBatchHelperService::STATUS_IN_TRANSIT, TripBatchHelperService::STATUS_ARRIVED])
                ->where('destination_id', auth()->user()->office_id)
                ->get();

            return view('backend.dashboard', compact('trips', 'data'));

        }elseif (auth()->user()->can('staff.biacc')){

            $trip_batches  = TripBatchGeneralService::query()->limit(5)->get();

            return view('backend.dashboard-biacc', compact('trip_batches'));
        }

    }
}
