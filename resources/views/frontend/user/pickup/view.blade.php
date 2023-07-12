@extends('frontend.layouts.app')

@section('title', __('Pickup List'))


@section('content')


    <div class="nk-content-wrap">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item text-lg"><a href="#">Parcel Management</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.user.pickup.index') }}">Pickup List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Parcel</li>
            </ol>
        </nav>

        @foreach($pickups->parcels as $parcel)
        <h6>Parcel {{ $loop->iteration }}</h6>
          <?php $count = 1; ?>
        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="sp-plan-head">
                                <h6 class="title">Parcel Details</h6>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-1">
                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Tracking No.</span>
                                            {{ $parcel->tracking_no }}
                                        </p>
                                    </li>
                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Date Received</span>
                                            {{ $parcel->created_at }}
                                        </p>
                                    </li>

                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Destination</span>
                                            {{ $parcel?->dropPoint?->name }}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-1">
                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Invoice</span>
                                            <a href="{{ route('frontend.user.parcel.download',encrypt($parcel->id)) }}" download><i class="fa fa-download me-2"></i> Download</a>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <hr>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-1">
                                    <li class="col-sm-3">
                                        <p><span class="text-soft">Service Charge</span>
                                            {{ displayPriceFormat($parcel->service_charge, '$') }}
                                        </p>
                                    </li>

                                    <li class="col-sm-3">
                                        <p><span class="text-soft">Tax</span>
                                            {{ displayPriceFormat($parcel->tax, '$') }}
                                        </p>
                                    </li>

                                    <li class="col-sm-3">
                                        <p><span class="text-soft">Permit</span>
                                            {{  displayPriceFormat($parcel->permit, '$') }}
                                        </p>
                                    </li>

                                    <li class="col-sm-3">
                                        <p><span class="text-soft">Cod Fee <small><i>(For COD Only)</i></small></span>
                                            {{ $parcel->cod_fee > 0 ? displayPriceFormat($parcel->cod_fee, '$') : __('-NA-') }}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-1">

                                    <li class="col-sm-4">
                                        <div class="text-success font-weight-bold"><span>Total Billing </span>
                                            <h4 class="text-success">
                                                {{ displayPriceFormat($parcel->total_billing, '$') }}
                                            </h4>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div>
        @endforeach
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
