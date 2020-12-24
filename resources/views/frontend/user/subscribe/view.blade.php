@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">

        <div class="row">
            <div class="col-xl-12">
                <div class="card card-bordered">
                    <div class="card-inner-group">

                        <a href="{{ route('frontend.user.subscribe.qr', $sub->tracking_no) }}" class="btn btn-primary">Show My QR</a>
                        <div class="card-inner">
                            <div class="sp-plan-head">
                                <h6 class="title">Parcel Details</h6>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-1">
                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Tracking No.</span>
                                            {{ $sub->tracking_no }}
                                        </p>
                                    </li>
                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Date Received</span>
                                            {{ ($sub->parcel)? $sub->parcel->created_at : "Not found" }}
                                        </p>
                                    </li>
                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Destination</span>
                                            {{ ($sub->parcel)? $sub->parcel->trip->destination->name : "Not found" }}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div>

        <div class="card card-bordered mt-3">
            <div class="card-inner">

                @if($sub->parcel)
                    <div class="timeline">
                    <h6 class="timeline-head">November, 2020</h6>
                    <ul class="timeline-list">

                        @foreach($sub->parcel->transactions as $transaction)
                        <li class="timeline-item">
                            <div class="timeline-status bg-primary"></div>
                            <div class="timeline-date">{{ reformatDatetime($transaction->created_at, 'd M') }} <em class="icon ni ni-alarm-alt"></em></div>
                            <div class="timeline-data">
                                <h6 class="timeline-title">{{ $transaction->remark }}</h6>
                                <div class="timeline-des">
                                    <span class="time">{{ reformatDatetime($transaction->created_at, 'h:i A') }}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @else
                    No info
                @endif
            </div>
        </div>

    </div>
@endsection
