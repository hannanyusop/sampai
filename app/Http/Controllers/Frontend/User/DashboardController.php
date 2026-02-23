<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\Parcels;
use App\Http\Controllers\Controller;
use App\Models\Pickup;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Pickup\PickupHelperService;

class DashboardController extends Controller{

    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_parcels' => Parcels::where('user_id', $user->id)->count(),
            'pending_parcels' => Parcels::where('user_id', $user->id)
                ->whereIn('status', ParcelHelperService::PENDING_STATUS)
                ->count(),
            'ready_to_collect' => Parcels::where('user_id', $user->id)
                ->whereIn('status', ParcelHelperService::READY_TO_COLLECT_STATUS)
                ->count(),
            'delivered_parcels' => Parcels::where('user_id', $user->id)
                ->whereIn('status', ParcelHelperService::COMPLETED_STATUS)
                ->count(),
            'total_pickups' => Pickup::where('user_id', $user->id)->count(),
            'pending_pickups' => Pickup::where('user_id', $user->id)
                ->where('status', PickupHelperService::STATUS_PENDING)
                ->count(),
        ];

        return view('frontend.user.dashboard', compact('stats'));
    }

    public function pwaSetup()
    {
        return view('frontend.user.pwa-setup');
    }

    public function notificationSetup()
    {
        return view('frontend.user.notification-setup');
    }
}
