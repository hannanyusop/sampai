@extends('frontend.layouts.app')

@section('title', __('Pickup List'))


@section('content')

    <style>
        /* Define blinking animation */
        @keyframes blink {
            0% { background-color: white; }
            50% { background-color: #880707; }
            100% { background-color: white; }
        }

        /* Apply animation to desired element  */
        .element {
            animation: blink 1.5s infinite;
        }
    </style>

    <div class="nk-content-wrap">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item text-lg"><a href="#">Parcel Management</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.user.pickup.index') }}">Pickup List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Parcel</li>
            </ol>
        </nav>
    </div>

    @if(in_array($pickup->status, [\App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER]))
        <div class="alert alert-fill alert-secondary alert-icon">
            @if($pickup->dropPoint->code == "K")
                @include('frontend.user.pickup.message.kln')
            @else
                @include('frontend.user.pickup.message.lbk')
            @endif
        </div>
    @endif

    <div class="invoice">
        <div class="card invoice-wrap">
            <div class="invoice-brand text-center">
                <div class="logo-link">
                    <img class="logo-light logo-img" src="{{ asset('images/logo.png') }}" srcset="{{ asset('images/logo.png') }} 2x" alt="logo">
                    <img class="logo-dark logo-img" src="{{ asset('images/logo.png') }}" srcset="{{ asset('images/logo.png') }} 2x" alt="logo-dark">
                </div>
            </div>
            <div class="invoice-head">
                <div class="invoice-contact">
                    <span class="overline-title">Customer Detail</span>
                    <div class="invoice-contact-info">
                        <h4 class="title">{{ $pickup?->user->name }}</h4>
                        <ul class="list-plain">
                            <li>
                                <em class="icon ni ni-mail"></em>
                                <span>{{ $pickup?->user->email }}</span>
                            </li>
                            <li>
                                <em class="icon ni ni-call-fill"></em>
                                <span>{{ $pickup?->user?->phone_number }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                @if(in_array($pickup->status, [\App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER]))
                <div class="invoice-desc">
                    <h5 class="title">Pickup Detail </h5>
                    <ul class="list-plain">
                        <li class="invoice-id">
                            <span>Code</span>: {{ $pickup->code }} <span></span>
                        </li>
                        <li class="invoice-date">
                            <span>Total Parcels</span>: {{ $pickup->parcels->count() }}<span></span>
                        </li>
                    </ul>
                </div>
                @endif
            </div>

            @if(auth()->user()->type == \App\Domains\Auth\Models\User::TYPE_USER && !in_array($pickup->status, [\App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER, \App\Services\Pickup\PickupHelperService::STATUS_DELIVERED]))
                <div class="alert alert-fill alert-info alert-icon element"><em class="icon ni ni-alert-circle"></em>
                    <strong>This item is not ready for pickup.</strong> Please wait until further notice. </div>
            @else
                <div class="invoice-bills">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Item ID</th>
                                <th class="text-left">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pickup->parcels as $parcel)
                                <tr>
                                    <td class="text-left">
                                        {{ $parcel->coding }}
                                        <small><br>{{ $parcel->tracking_no  }}</small>
                                    </td>
                                    <td class="text-left">{{ displayPriceFormat($parcel->total_billing, '$') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td>Grand Total : {{ displayPriceFormat($pickup->total, '$') }}</td>
                            </tr>
                            </tfoot>
                        </table>
                        <div class="nk-notes ff-italic fs-12px text-soft"> Invoice was created on a computer and is valid without the signature and seal. </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="card card-bordered">
        <div class="card-inner-group">
            <div class="card-inner">
                @include('components.parcel.summary-box')
            </div>
        </div>
    </div>

{{--    <div id="embedTrack"></div>--}}
{{--    <script src="//www.tracking.my/track-button.js"></script>--}}
{{--    <script>--}}
{{--        TrackButton.embed({--}}
{{--            selector: "#embedTrack",--}}
{{--            tracking_no: "{{ $parcel->tracking_no }}",--}}
{{--        });--}}
{{--    </script>--}}
@endsection
