<?php

namespace App\Http\Livewire\Backend\Billing;

use App\Domains\Auth\Models\Office;
use App\Mail\Pickup\SendNotification;
use App\Models\Pickup;
use App\Models\PickupNotification;
use App\Models\TripBatch;
use App\Notifications\ParcelStatusNotification;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Pickup\PickupHelperService;
use Livewire\Component;
use Livewire\WithPagination;
use Mail;

class BillingView extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $tripBatch;

    // Filters
    public $filterStatus = '';
    public $filterDestination = '';
    public $filterNotYetNotified = false;
    public $filterInvalidPhone = false;

    // Bulk selection
    public $selectedPickups = [];
    public $selectAll = false;

    // Edit phone number
    public $editingPickupId = null;
    public $editingUserId = null;
    public $editingPhoneNumber = '';

    protected $queryString = [
        'filterStatus' => ['except' => ''],
        'filterDestination' => ['except' => ''],
        'filterNotYetNotified' => ['except' => false],
        'filterInvalidPhone' => ['except' => false],
    ];

    public function mount($tripBatch)
    {
        $this->tripBatch = $tripBatch;
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
        $this->selectedPickups = [];
        $this->selectAll = false;
    }

    public function updatingFilterDestination()
    {
        $this->resetPage();
        $this->selectedPickups = [];
        $this->selectAll = false;
    }

    public function updatingFilterNotYetNotified()
    {
        $this->resetPage();
        $this->selectedPickups = [];
        $this->selectAll = false;
    }

    public function updatingFilterInvalidPhone()
    {
        $this->resetPage();
        $this->selectedPickups = [];
        $this->selectAll = false;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedPickups = $this->getFilteredPickupsQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedPickups = [];
        }
    }

    public function getFilteredPickupsQuery()
    {
        $tripBatchId = $this->tripBatch->id;

        return Pickup::with(['latestNotification', 'user', 'dropPoint', 'parcels'])
            ->whereHas('trip', function ($query) use ($tripBatchId) {
                $query->where('trip_batch_id', $tripBatchId);
            })
            ->when($this->filterStatus !== '', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterDestination !== '', function ($query) {
                $query->where('office_id', $this->filterDestination);
            })
            ->when($this->filterNotYetNotified, function ($query) {
                $query->doesntHave('notifications');
            })
            ->when($this->filterInvalidPhone, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where(function ($q2) {
                        $q2->whereNull('phone_number')
                           ->orWhere('phone_number', '')
                           ->orWhere('phone_number', 'not like', '+6%');
                    });
                });
            });
    }

    public function bulkSendEmail()
    {
        if (empty($this->selectedPickups)) {
            session()->flash('error', __('Please select at least one pickup.'));
            return;
        }

        $pickups = Pickup::whereIn('id', $this->selectedPickups)->get();
        $offices = Office::pluck('whatsapp_template', 'id')->toArray();
        $successCount = 0;
        $failCount = 0;

        foreach ($pickups as $pickup) {
            $email = $pickup->user?->email ?? null;
            if (!$email) {
                $failCount++;
                continue;
            }

            $messageContent = \App\Services\Parcel\ParcelHelperService::GeneralWhatsappText($pickup, $offices);

            $notification = PickupNotification::create([
                'pickup_id' => $pickup->id,
                'via' => PickupNotification::VIA_EMAIL,
                'address' => $email,
                'content' => $messageContent,
                'status' => PickupNotification::STATUS_PENDING,
            ]);

            try {
                Mail::to($email)->send(new SendNotification($pickup, $messageContent));

                $notification->update([
                    'status' => PickupNotification::STATUS_SENT,
                    'provider_remark' => 'Email sent successfully',
                ]);

                $pickup->update([
                    'notification_sent' => 1,
                    'notification_send_at' => now()
                ]);

                $successCount++;
            } catch (\Exception $e) {
                $notification->update([
                    'status' => PickupNotification::STATUS_FAILED,
                    'provider_remark' => $e->getMessage(),
                ]);
                $failCount++;
            }
        }

        $this->selectedPickups = [];
        $this->selectAll = false;

        session()->flash('success', __(':success emails sent successfully, :fail failed.', ['success' => $successCount, 'fail' => $failCount]));
    }

    public function bulkSendWhatsApp()
    {
        if (empty($this->selectedPickups)) {
            session()->flash('error', __('Please select at least one pickup.'));
            return;
        }

        $pickups = Pickup::whereIn('id', $this->selectedPickups)->get();
        $offices = Office::pluck('whatsapp_template', 'id')->toArray();
        $successCount = 0;
        $failCount = 0;

        foreach ($pickups as $pickup) {
            $phoneNumber = $pickup->user?->phone_number;
            if (!$phoneNumber) {
                $failCount++;
                continue;
            }

            $message = \App\Services\Parcel\ParcelHelperService::GeneralWhatsappText($pickup, $offices);

            $notification = PickupNotification::create([
                'pickup_id' => $pickup->id,
                'via' => PickupNotification::VIA_WHATSAPP,
                'address' => $phoneNumber,
                'content' => $message,
                'status' => PickupNotification::STATUS_PENDING,
            ]);

            try {
                $service = new \App\Services\Twilio\TwilioWhatsAppService();
                $result = $service->send($phoneNumber, $message);

                $notification->update([
                    'status' => PickupNotification::STATUS_SENT,
                    'provider_remark' => 'Message SID: ' . ($result['sid'] ?? 'N/A'),
                ]);

                $pickup->update([
                    'notification_sent' => 1,
                    'notification_send_at' => now()
                ]);

                $successCount++;
            } catch (\Exception $e) {
                $notification->update([
                    'status' => PickupNotification::STATUS_FAILED,
                    'provider_remark' => $e->getMessage(),
                ]);
                $failCount++;
            }
        }

        $this->selectedPickups = [];
        $this->selectAll = false;

        session()->flash('success', __(':success WhatsApp messages sent successfully, :fail failed.', ['success' => $successCount, 'fail' => $failCount]));
    }

    public function bulkSendPushNotification()
    {
        if (empty($this->selectedPickups)) {
            session()->flash('error', __('Please select at least one pickup.'));
            return;
        }

        $pickups = Pickup::with(['user', 'parcels'])->whereIn('id', $this->selectedPickups)->get();
        $successCount = 0;
        $failCount = 0;

        foreach ($pickups as $pickup) {
            $user = $pickup->user;
            if (!$user || empty($user->fcm_token)) {
                $failCount++;
                continue;
            }

            $notification = PickupNotification::create([
                'pickup_id' => $pickup->id,
                'via' => PickupNotification::VIA_FCM,
                'address' => 'fcm_token',
                'content' => 'Push notification sent for ' . $pickup->parcels->count() . ' parcel(s)',
                'status' => PickupNotification::STATUS_PENDING,
            ]);

            try {
                foreach ($pickup->parcels as $parcel) {
                    $user->notify(new ParcelStatusNotification($parcel, ParcelHelperService::STATUS_READY_TO_COLLECT));
                }

                $notification->update([
                    'status' => PickupNotification::STATUS_SENT,
                    'provider_remark' => 'Push notification sent successfully',
                ]);

                $pickup->update([
                    'notification_sent' => 1,
                    'notification_send_at' => now()
                ]);

                $successCount++;
            } catch (\Exception $e) {
                $notification->update([
                    'status' => PickupNotification::STATUS_FAILED,
                    'provider_remark' => $e->getMessage(),
                ]);
                $failCount++;
            }
        }

        $this->selectedPickups = [];
        $this->selectAll = false;

        session()->flash('success', __(':success push notifications sent successfully, :fail failed.', ['success' => $successCount, 'fail' => $failCount]));
    }

    public function clearFilters()
    {
        $this->filterStatus = '';
        $this->filterDestination = '';
        $this->filterNotYetNotified = false;
        $this->filterInvalidPhone = false;
        $this->selectedPickups = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    public function editPhoneNumber($pickupId)
    {
        $pickup = Pickup::with('user')->find($pickupId);
        if ($pickup && $pickup->user) {
            $this->editingPickupId = $pickupId;
            $this->editingUserId = $pickup->user->id;
            $this->editingPhoneNumber = $pickup->user->phone_number ?? '';
            $this->dispatchBrowserEvent('show-edit-phone-modal');
        }
    }

    public function updatePhoneNumber()
    {
        $this->validate([
            'editingPhoneNumber' => 'required|string|max:20',
        ]);

        if ($this->editingUserId) {
            \App\Domains\Auth\Models\User::where('id', $this->editingUserId)->update([
                'phone_number' => $this->editingPhoneNumber,
            ]);

            session()->flash('success', __('Phone number updated successfully.'));
            $this->closeEditPhoneModal();
        }
    }

    public function closeEditPhoneModal()
    {
        $this->editingPickupId = null;
        $this->editingUserId = null;
        $this->editingPhoneNumber = '';
        $this->dispatchBrowserEvent('hide-edit-phone-modal');
    }

    public function render()
    {
        $pickups = $this->getFilteredPickupsQuery()->paginate(20);

        $statuses = PickupHelperService::statusLabel();
        $destinations = Office::where('is_drop_point', 1)->orderBy('code')->get();

        return view('livewire.backend.billing.billing-view', compact('pickups', 'statuses', 'destinations'));
    }
}
