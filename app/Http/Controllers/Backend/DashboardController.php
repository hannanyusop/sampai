<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Models\TripBatch;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Sales\DailySaleGeneralService;
use App\Services\Trip\TripHelperService;
use App\Services\TripBatch\TripBatchGeneralService;
use App\Services\TripBatch\TripBatchHelperService;
use Illuminate\Http\Request;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

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
            return view('backend.dashboard');

        }elseif (auth()->user()->can('staff.biacc')){

            $trip_batches  = TripBatchGeneralService::query()->orderBy('id', 'desc')->limit(5)->get();

            return view('backend.dashboard-biacc', compact('trip_batches'));
        }elseif (auth()->user()->can('staff.finance')) {


            $today = date('Y-m-d');

            $daily_sales = DailySaleGeneralService::query()
                ->with('office')
                ->whereDate('sales_date', $today)
                ->get();


            return view('backend.finance', compact('daily_sales', 'today'));
        }

        abort(403, 'You do not have permission to access the dashboard.');
    }

    public function notifyUsers()
    {
        return view('backend.notify-users');
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $users = User::whereNotNull('fcm_token')->get();

        if ($users->isEmpty()) {
            return back()->with('flash_warning', 'No users with FCM tokens found.');
        }

        $fcmMessage = FcmMessage::create()
            ->setData(['type' => 'broadcast'])
            ->setNotification(
                FcmNotification::create()
                    ->setTitle('NUJ Express')
                    ->setBody($request->message)
            );

        $sent = 0;
        foreach ($users as $user) {
            try {
                $user->notify(new class($fcmMessage) extends \Illuminate\Notifications\Notification {
                    protected $message;
                    public function __construct($message) { $this->message = $message; }
                    public function via($notifiable) { return [FcmChannel::class]; }
                    public function toFcm($notifiable) { return $this->message; }
                });
                $sent++;
            } catch (\Exception $e) {
                continue;
            }
        }

        return back()->with('flash_success', "Notification sent to {$sent} user(s).");
    }
}
