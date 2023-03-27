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
                                        <p><span class="text-soft">Quantity</span>
                                            {{ $parcel->quantity }}
                                        </p>
                                    </li>

                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Price</span>
                                            {{ $parcel->price }}
                                        </p>
                                    </li>

                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Tax</span>
                                            {{ $parcel->tax }}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-1">
                                    <li class="col-sm-8">
                                        <p><span class="text-soft">Item Description (Keterangan barang)</span>
                                            {{ $parcel->description }}
                                        </p>
                                    </li>

                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Invoice</span>
                                            <a href="" download><i class="fa fa-download me-2"></i> Download</a>
                                        </p>
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
