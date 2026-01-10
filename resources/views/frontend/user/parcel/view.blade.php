@extends('frontend.layouts.app')

@section('title', __('Parcel Details'))

<style>
    .parcel-view-container {
        padding-bottom: 100px;
    }

    /* Status Header */
    .status-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 24px 20px;
        color: white;
        text-align: center;
        margin: -1px -1px 0;
    }

    @media (max-width: 767px) {
        .status-header {
            margin: 0;
            border-radius: 0;
        }
    }

    .status-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .tracking-number {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .pickup-code {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        padding: 16px;
        background: white;
    }

    .action-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px;
        border-radius: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .action-btn.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .action-btn.secondary {
        background: #f5f6fa;
        color: #667eea;
    }

    .action-btn:hover {
        text-decoration: none;
        transform: translateY(-2px);
    }

    .action-btn.primary:hover { color: white; }
    .action-btn.secondary:hover { color: #667eea; }

    /* Detail Cards */
    .detail-section {
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

    .detail-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 16px;
        border-bottom: 1px solid #f5f5f5;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-size: 0.9rem;
        color: #888;
    }

    .detail-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1a1a2e;
        text-align: right;
    }

    /* Categories */
    .categories-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding: 14px 16px;
    }

    .category-tag {
        padding: 6px 14px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        color: #667eea;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Invoice Section */
    .invoice-section {
        padding: 16px;
    }

    .invoice-preview {
        width: 100%;
        max-width: 200px;
        border-radius: 12px;
        margin-bottom: 12px;
    }

    .download-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #f5f6fa;
        color: #667eea;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
    }

    .download-btn:hover {
        background: #eef0f8;
        color: #667eea;
        text-decoration: none;
    }

    /* Timeline */
    .timeline-section {
        padding: 0 16px;
        margin-bottom: 24px;
    }

    .timeline-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 20px;
    }

    .timeline-item {
        display: flex;
        position: relative;
        padding-bottom: 24px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 11px;
        top: 28px;
        bottom: 0;
        width: 2px;
        background: #e5e5e5;
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-dot {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
        flex-shrink: 0;
        z-index: 1;
    }

    .timeline-dot i {
        color: white;
        font-size: 0.7rem;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 4px;
    }

    .timeline-time {
        font-size: 0.8rem;
        color: #888;
    }

    /* Process Steps */
    .process-steps {
        display: flex;
        overflow-x: auto;
        padding: 16px;
        gap: 8px;
        background: white;
        margin-bottom: 16px;
        -webkit-overflow-scrolling: touch;
    }

    .process-steps::-webkit-scrollbar {
        display: none;
    }

    .process-step {
        flex: 0 0 auto;
        text-align: center;
        padding: 12px 16px;
        background: #f5f6fa;
        border-radius: 12px;
        min-width: 100px;
    }

    .process-step.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .process-step.completed {
        background: rgba(17, 153, 142, 0.1);
        color: #11998e;
    }

    .step-number {
        font-size: 0.7rem;
        font-weight: 600;
        opacity: 0.7;
    }

    .step-name {
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 4px;
    }

    /* Staff Form */
    .staff-form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 20px;
        margin: 0 16px 16px;
    }

    .staff-form-card .form-label {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 8px;
    }

    .staff-form-card .form-control {
        border-radius: 12px;
        border: 2px solid #e5e5e5;
        padding: 12px 16px;
    }

    .staff-form-card .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .staff-form-card .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 600;
    }

    /* External Tracking */
    .external-tracking {
        padding: 16px;
    }

    /* Desktop */
    @media (min-width: 768px) {
        .parcel-view-container {
            max-width: 700px;
            margin: 0 auto;
        }

        .status-header {
            border-radius: 16px 16px 0 0;
            margin: 0;
        }
    }
</style>

@section('content')
<div class="parcel-view-container">
    <!-- Status Header -->
    <div class="status-header">
        <div class="status-badge">{{ $parcel->status_label }}</div>
        <div class="tracking-number">{{ $parcel->tracking_no }}</div>
        <div class="pickup-code">{{ $parcel->coding }}</div>
    </div>

    <!-- Action Buttons -->
    @if(is_null($parcel->pickup_id))
        <div class="action-buttons">
            <a href="{{ route('frontend.user.parcel.edit', encrypt($parcel->id)) }}" class="action-btn primary">
                <i class="ni ni-edit"></i>
                {{ __('Edit Parcel') }}
            </a>
        </div>
    @endif

    <!-- Process Steps -->
    <div class="process-steps">
        @php
            $steps = [
                1 => 'Registered',
                2 => 'Received',
                3 => 'Outbound',
                4 => 'Inbound',
                5 => 'Ready',
                6 => 'Delivered'
            ];
        @endphp
        @foreach($steps as $stepNum => $stepName)
            <div class="process-step {{ $parcel->status == $stepNum ? 'active' : ($parcel->status > $stepNum ? 'completed' : '') }}">
                <div class="step-number">{{ __('Step') }} {{ $stepNum }}</div>
                <div class="step-name">{{ __($stepName) }}</div>
            </div>
        @endforeach
    </div>

    <!-- Parcel Details -->
    <div class="detail-section">
        <div class="section-title">{{ __('Parcel Information') }}</div>
        <div class="detail-card">
            <div class="detail-row">
                <span class="detail-label">{{ __('Tracking No') }}</span>
                <span class="detail-value">{{ $parcel->tracking_no }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">{{ __('Date Received') }}</span>
                <span class="detail-value">{{ $parcel->created_at->format('d M Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">{{ __('Destination') }}</span>
                <span class="detail-value">{{ $parcel?->dropPoint?->name ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">{{ __('Quantity') }}</span>
                <span class="detail-value">{{ $parcel->quantity }}</span>
            </div>
            @if($showPrice)
                <div class="detail-row">
                    <span class="detail-label">{{ __('Service Charge') }}</span>
                    <span class="detail-value">{{ displayPriceFormat($parcel->service_charge, '$') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">{{ __('Tax') }}</span>
                    <span class="detail-value">{{ $parcel->tax_formated }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Categories -->
    @if(count($parcel->cat) > 0)
        <div class="detail-section">
            <div class="section-title">{{ __('Categories') }}</div>
            <div class="detail-card">
                <div class="categories-wrap">
                    @foreach($parcel->cat as $category_id => $category_name)
                        <span class="category-tag">{{ $category_name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Description -->
    @if($parcel->description)
        <div class="detail-section">
            <div class="section-title">{{ __('Item Description') }}</div>
            <div class="detail-card">
                <div class="detail-row">
                    <span class="detail-value" style="text-align: left; width: 100%;">{{ $parcel->description }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Invoice -->
    <div class="detail-section">
        <div class="section-title">{{ __('Invoice') }}</div>
        <div class="detail-card">
            <div class="invoice-section">
                <img src="{{ $parcel->invoice_path }}" alt="invoice" class="invoice-preview">
                <br>
                <a href="{{ route('frontend.user.parcel.download', encrypt($parcel->id)) }}" download class="download-btn">
                    <i class="ni ni-download"></i>
                    {{ __('Download Invoice') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Staff Delivery Form -->
    @if($parcel->status == 3 && auth()->user()->can('staff.inhouse'))
        <div class="staff-form-card">
            <h6 class="mb-3">{{ __('Mark As Received') }}</h6>
            <x-forms.post :action="route('admin.parcel.deliver', $parcel->tracking_no)" class="form-validate">
                <div class="form-group mb-3">
                    <label class="form-label" for="pickup_name">{{ __('Receiver Name') }}</label>
                    <input type="text" name="pickup_name" id="pickup_name" class="form-control" value="{{ $name }}" required>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="pickup_info">{{ __('Receiver Info') }}</label>
                    <input type="text" name="pickup_info" id="pickup_info" class="form-control" value="{{ $receiver_info }}" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">{{ __('Mark As Receive') }}</button>
            </x-forms.post>
        </div>
    @endif

    <!-- Timeline -->
    @if($parcel->transactions->count() > 0)
        <div class="timeline-section">
            <div class="section-title">{{ __('Tracking History') }}</div>
            <div class="timeline-card">
                @foreach($parcel->transactions as $transaction)
                    <div class="timeline-item">
                        <div class="timeline-dot">
                            <i class="ni ni-check"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">{{ $transaction->remark }}</div>
                            <div class="timeline-time">{{ reformatDatetime($transaction->created_at, 'd M Y, h:i A') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- External Tracking -->
    <div class="external-tracking">
        <div id="embedTrack"></div>
    </div>

    <div id="as-root"></div>
</div>

<script>(function(e,t,n){var r,i=e.getElementsByTagName(t)[0];if(e.getElementById(n))return;r=e.createElement(t);r.id=n;r.src="//s.trackingmore.com/button/getbutton.js";i.parentNode.insertBefore(r,i)})(document,"script","trackingmore-jssdk")</script>
<script src="//www.tracking.my/track-button.js"></script>
<script>
    TrackButton.embed({
        selector: "#embedTrack",
        tracking_no: "{{ $parcel->tracking_no }}",
    });
</script>
@endsection
