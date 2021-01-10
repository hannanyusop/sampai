@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><a href="{{ route('frontend.user.subscribe.index') }}" class="text-soft back-to"><em class="icon ni ni-arrow-left"> </em><span>Subscription List</span></a></div>
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h2 class="nk-block-title fw-normal">#{{ $sub->tracking_no }}</h2>
                    <div class="nk-block-des">
                        <p> <span class="badge badge-outline badge-primary"> Created At {{ $sub->created_at  }}</span></p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools gx-3">
                        @if($sub->parcel && $sub->parcel->status == 3)
                            <li class="order-md-last"><a href="{{ route('frontend.user.subscribe.qr', $sub->tracking_no) }}" class="btn btn-success"><em class="icon ni ni-qr"></em> <span>Show My QR</span> </a></li>
                        @endif
                        <li><a href="{{ route('frontend.user.subscribe.view', $sub->tracking_no) }}" class="btn btn-icon btn-light"><em class="icon ni ni-reload"></em></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-content-wrap">
        <div class="row">
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

                <div class="timeline">
                    <ul class="timeline-list">
                        @if($sub->parcel)
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
                        @endif
                            <li class="timeline-item">
                                <div class="timeline-status bg-primary"></div>
                                <div class="timeline-date">{{ reformatDatetime($sub->created_at, 'd M') }} <em class="icon ni ni-alarm-alt"></em></div>
                                <div class="timeline-data">
                                    <h6 class="timeline-title">Added To Subscription List</h6>
                                    <div class="timeline-des">
                                        <span class="time">{{ reformatDatetime($sub->created_at, 'h:i A') }}</span>
                                    </div>
                                </div>
                            </li>
                    </ul>
                </div>


            </div>
        </div>

    </div>
@endsection
