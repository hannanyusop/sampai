@extends('frontend.layouts.app')

@section('title', __('Pickup Details'))

<style>
    .pickup-view-container {
        padding-bottom: 100px;
    }

    /* Header */
    .pickup-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 24px 20px;
        color: white;
        position: relative;
    }

    @media (max-width: 767px) {
        .pickup-header {
            margin: 0;
            border-radius: 0;
        }
    }

    .header-back {
        position: absolute;
        left: 16px;
        top: 24px;
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        font-size: 1.25rem;
    }

    .header-back:hover {
        background: rgba(255,255,255,0.3);
        color: white;
        text-decoration: none;
    }

    .header-content {
        text-align: center;
        padding-top: 20px;
    }

    .header-code {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .header-status {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .header-status.pending { background: rgba(255, 193, 7, 0.9); color: #000; }
    .header-status.ready { background: rgba(40, 167, 69, 0.9); color: white; }
    .header-status.processing { background: rgba(255, 255, 255, 0.3); color: white; }
    .header-status.delivered { background: rgba(255, 255, 255, 0.9); color: #28a745; }

    /* Alert Banner */
    .alert-banner {
        margin: 16px;
        padding: 16px;
        border-radius: 12px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .alert-banner.warning {
        background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
        border: 1px solid #ffc107;
    }

    .alert-banner.info {
        background: linear-gradient(135deg, #cff4fc 0%, #9eeaf9 100%);
        border: 1px solid #0dcaf0;
    }

    .alert-banner.success {
        background: linear-gradient(135deg, #d1e7dd 0%, #a3cfbb 100%);
        border: 1px solid #198754;
    }

    .alert-banner-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .alert-banner.warning .alert-banner-icon {
        background: #ffc107;
        color: #000;
    }

    .alert-banner.info .alert-banner-icon {
        background: #0dcaf0;
        color: white;
    }

    .alert-banner.success .alert-banner-icon {
        background: #198754;
        color: white;
    }

    .alert-banner-content {
        flex: 1;
    }

    .alert-banner-title {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 4px;
    }

    .alert-banner.warning .alert-banner-title { color: #664d03; }
    .alert-banner.info .alert-banner-title { color: #055160; }
    .alert-banner.success .alert-banner-title { color: #0f5132; }

    .alert-banner-text {
        font-size: 0.85rem;
        line-height: 1.5;
    }

    .alert-banner.warning .alert-banner-text { color: #664d03; }
    .alert-banner.info .alert-banner-text { color: #055160; }
    .alert-banner.success .alert-banner-text { color: #0f5132; }

    /* Section */
    .section {
        padding: 0 16px;
        margin-bottom: 16px;
    }

    .section-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px 4px 8px;
    }

    .info-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 20px;
    }

    /* Customer Info */
    .customer-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .customer-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
        flex-shrink: 0;
    }

    .customer-details {
        flex: 1;
    }

    .customer-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 4px;
    }

    .customer-contact {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .customer-contact-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: #666;
    }

    .customer-contact-item i {
        color: #667eea;
        width: 16px;
    }

    /* Pickup Details */
    .pickup-details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .pickup-detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .pickup-detail-label {
        font-size: 0.75rem;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .pickup-detail-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1a1a2e;
    }

    /* Grand Total Card */
    .total-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 24px;
        color: white;
        text-align: center;
    }

    .total-label {
        font-size: 0.85rem;
        opacity: 0.9;
        margin-bottom: 8px;
    }

    .total-amount {
        font-size: 2rem;
        font-weight: 700;
    }

    .total-parcels {
        font-size: 0.85rem;
        opacity: 0.9;
        margin-top: 8px;
    }

    /* Parcel List */
    .parcel-item {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 16px;
        margin-bottom: 12px;
    }

    .parcel-item-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .parcel-tracking {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1a1a2e;
    }

    .parcel-coding {
        font-size: 0.8rem;
        color: #667eea;
        font-weight: 500;
    }

    .parcel-total {
        font-size: 1rem;
        font-weight: 700;
        color: #28a745;
    }

    .parcel-charges {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 12px;
    }

    .charge-item {
        text-align: center;
    }

    .charge-label {
        font-size: 0.65rem;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .charge-value {
        font-size: 0.8rem;
        font-weight: 600;
        color: #1a1a2e;
    }

    .parcel-actions {
        display: flex;
        gap: 8px;
    }

    .parcel-action-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }

    .parcel-action-btn.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .parcel-action-btn.primary:hover {
        color: white;
        text-decoration: none;
        opacity: 0.9;
    }

    .parcel-action-btn.secondary {
        background: #f5f6fa;
        color: #666;
    }

    .parcel-action-btn.secondary:hover {
        background: #eef0f8;
        color: #666;
        text-decoration: none;
    }

    /* Empty State */
    .empty-parcels {
        text-align: center;
        padding: 40px 20px;
        color: #888;
    }

    .empty-parcels i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 12px;
    }

    /* Desktop */
    @media (min-width: 768px) {
        .pickup-view-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .pickup-header {
            border-radius: 16px 16px 0 0;
        }

        .parcel-charges {
            grid-template-columns: repeat(6, 1fr);
        }
    }

    /* Blinking animation for not ready */
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    .pulse-animation {
        animation: pulse 2s infinite;
    }
</style>

@section('content')
<div class="pickup-view-container">

    <!-- Header -->
    <div class="pickup-header">
        <a href="{{ route('frontend.user.pickup.index') }}" class="header-back">
            <i class="ni ni-arrow-left"></i>
        </a>
        <div class="header-content">
            <div class="header-code">{{ $pickup->code }}</div>
            @php
                $statusClass = match($pickup->status) {
                    \App\Services\Pickup\PickupHelperService::STATUS_PENDING => 'pending',
                    \App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER => 'ready',
                    \App\Services\Pickup\PickupHelperService::STATUS_DELIVERED => 'delivered',
                    \App\Services\Pickup\PickupHelperService::STATUS_PICKUP_POINT_PROCESS => 'processing',
                    default => 'pending'
                };
            @endphp
            <span class="header-status {{ $statusClass }}">{{ $pickup->status_label }}</span>
        </div>
    </div>

    <!-- Alert for Ready to Deliver -->
    @if(in_array($pickup->status, [\App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER]))
        <div class="alert-banner success">
            <div class="alert-banner-icon">
                <i class="ni ni-check"></i>
            </div>
            <div class="alert-banner-content">
                <div class="alert-banner-title">{{ __('Ready for Pickup') }}</div>
                <div class="alert-banner-text">{!! $pickup->dropPoint->pickup_remark !!}</div>
            </div>
        </div>
    @endif

    <!-- Alert for Not Ready -->
    @if(auth()->user()->type == \App\Domains\Auth\Models\User::TYPE_USER && !in_array($pickup->status, [\App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER, \App\Services\Pickup\PickupHelperService::STATUS_DELIVERED]))
        <div class="alert-banner warning pulse-animation">
            <div class="alert-banner-icon">
                <i class="ni ni-alert"></i>
            </div>
            <div class="alert-banner-content">
                <div class="alert-banner-title">{{ __('Not Ready for Pickup') }}</div>
                <div class="alert-banner-text">{{ __('This item is not ready for pickup. Please wait until further notice.') }}</div>
            </div>
        </div>
    @endif

    <!-- Customer Info -->
    <div class="section">
        <div class="section-title">{{ __('Customer Information') }}</div>
        <div class="info-card">
            <div class="customer-info">
                <div class="customer-avatar">
                    {{ strtoupper(substr($pickup->user->name ?? 'U', 0, 1)) }}
                </div>
                <div class="customer-details">
                    <div class="customer-name">{{ $pickup->user->name ?? '-' }}</div>
                    <div class="customer-contact">
                        <div class="customer-contact-item">
                            <i class="ni ni-mail"></i>
                            <span>{{ $pickup->user->email ?? '-' }}</span>
                        </div>
                        <div class="customer-contact-item">
                            <i class="ni ni-call"></i>
                            <span>{{ $pickup->user->phone_number ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pickup Details -->
    <div class="section">
        <div class="section-title">{{ __('Pickup Details') }}</div>
        <div class="info-card">
            <div class="pickup-details-grid">
                <div class="pickup-detail-item">
                    <div class="pickup-detail-label">{{ __('Pickup Code') }}</div>
                    <div class="pickup-detail-value">{{ $pickup->code }}</div>
                </div>
                <div class="pickup-detail-item">
                    <div class="pickup-detail-label">{{ __('Trip') }}</div>
                    <div class="pickup-detail-value">{{ $pickup->trip->code ?? '-' }}</div>
                </div>
                <div class="pickup-detail-item">
                    <div class="pickup-detail-label">{{ __('Drop Point') }}</div>
                    <div class="pickup-detail-value">{{ $pickup->dropPoint->code ?? '-' }}</div>
                </div>
                <div class="pickup-detail-item">
                    <div class="pickup-detail-label">{{ __('Total Parcels') }}</div>
                    <div class="pickup-detail-value">{{ $pickup->parcels->count() }}</div>
                </div>
                @if($pickup->pickup_name)
                <div class="pickup-detail-item">
                    <div class="pickup-detail-label">{{ __('Pickup By') }}</div>
                    <div class="pickup-detail-value">{{ $pickup->pickup_name }}</div>
                </div>
                @endif
                @if($pickup->pickup_datetime)
                <div class="pickup-detail-item">
                    <div class="pickup-detail-label">{{ __('Pickup Date') }}</div>
                    <div class="pickup-detail-value">{{ $pickup->pickup_datetime }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Grand Total -->
    @if(auth()->user()->type != \App\Domains\Auth\Models\User::TYPE_USER || in_array($pickup->status, [\App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER, \App\Services\Pickup\PickupHelperService::STATUS_DELIVERED]))
    <div class="section">
        <div class="total-card">
            <div class="total-label">{{ __('Grand Total') }}</div>
            <div class="total-amount">{{ displayPriceFormat($pickup->total, '$') }}</div>
            <div class="total-parcels">{{ $pickup->parcels->count() }} {{ __('Parcel(s)') }}</div>
        </div>
    </div>
    @endif

    <!-- Parcel List -->
    <div class="section">
        <div class="section-title">{{ __('Parcel List') }}</div>

        @forelse($pickup->parcels as $parcel)
            <div class="parcel-item">
                <div class="parcel-item-header">
                    <div>
                        <div class="parcel-tracking">{{ $parcel->tracking_no }}</div>
                        <div class="parcel-coding">{{ $parcel->coding }}</div>
                    </div>
                    @if(auth()->user()->type != \App\Domains\Auth\Models\User::TYPE_USER || in_array($pickup->status, [\App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER, \App\Services\Pickup\PickupHelperService::STATUS_DELIVERED]))
                    <div class="parcel-total">{{ displayPriceFormat($parcel->total_billing, '$') }}</div>
                    @endif
                </div>

                @if(auth()->user()->type != \App\Domains\Auth\Models\User::TYPE_USER || in_array($pickup->status, [\App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER, \App\Services\Pickup\PickupHelperService::STATUS_DELIVERED]))
                <div class="parcel-charges">
                    <div class="charge-item">
                        <div class="charge-label">{{ __('COD') }}</div>
                        <div class="charge-value">{{ displayPriceFormat($parcel->cod_fee, '$') }}</div>
                    </div>
                    <div class="charge-item">
                        <div class="charge-label">{{ __('Tax') }}</div>
                        <div class="charge-value">{{ displayPriceFormat($parcel->tax, '$') }}</div>
                    </div>
                    <div class="charge-item">
                        <div class="charge-label">{{ __('Service') }}</div>
                        <div class="charge-value">{{ displayPriceFormat($parcel->service_charge, '$') }}</div>
                    </div>
                    <div class="charge-item">
                        <div class="charge-label">{{ __('Declare') }}</div>
                        <div class="charge-value">{{ displayPriceFormat($parcel->declare_charge, '$') }}</div>
                    </div>
                    <div class="charge-item">
                        <div class="charge-label">{{ __('Permit') }}</div>
                        <div class="charge-value">{{ displayPriceFormat($parcel->permit, '$') }}</div>
                    </div>
                    <div class="charge-item">
                        <div class="charge-label">{{ __('Total') }}</div>
                        <div class="charge-value" style="color: #28a745;">{{ displayPriceFormat($parcel->total_billing, '$') }}</div>
                    </div>
                </div>
                @endif

                <div class="parcel-actions">
                    <a href="{{ route('frontend.user.parcel.show', encrypt($parcel->id)) }}" class="parcel-action-btn secondary">
                        <i class="ni ni-eye"></i>
                        {{ __('View') }}
                    </a>
                    @if($parcel->invoice_url)
                    <a href="{{ route('frontend.user.parcel.download', encrypt($parcel->id)) }}" class="parcel-action-btn primary">
                        <i class="ni ni-download"></i>
                        {{ __('Invoice') }}
                    </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="parcel-item">
                <div class="empty-parcels">
                    <i class="ni ni-box"></i>
                    <p>{{ __('No parcels in this pickup') }}</p>
                </div>
            </div>
        @endforelse
    </div>

</div>

<!-- SweetAlert -->
@if(session('flash_success') || session('success') || session('flash_danger') || session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('flash_success') || session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ __("Success") }}',
            text: '{{ session("flash_success") ?? session("success") }}',
            confirmButtonColor: '#667eea'
        });
    @endif

    @if(session('flash_danger') || session('error'))
        Swal.fire({
            icon: 'error',
            title: '{{ __("Error") }}',
            text: '{{ session("flash_danger") ?? session("error") }}',
            confirmButtonColor: '#667eea'
        });
    @endif
</script>
@endif
@endsection
