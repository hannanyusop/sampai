@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h2 class="nk-block-title fw-normal">Welcome, {{ auth()->user()->name }}</h2>
                    <div class="nk-block-des">
                        <p>Welcome to our dashboard. Manage your account and your subscriptions.</p>
                    </div>
                </div>
            </div>
        </div><!-- .nk-block-head -->

        <div class="nk-block">
            <div class="row g-2">
                <div class="col-sm-3">
                    <div class="card bg-light">
                        <div class="nk-wgw sm">
                            <a class="nk-wgw-inner" href="#">
                                <div class="nk-wgw-name">
                                    <div class="nk-wgw-icon">
                                        <em class="icon ni ni-search"></em>
                                    </div>
                                    <h5 class="nk-wgw-title title">Pending</h5>
                                </div>
                                <div class="nk-wgw-balance">
                                    <div class="amount">0</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div><!-- .col -->
                <div class="col-sm-3">
                    <div class="card bg-light">
                        <div class="nk-wgw sm">
                            <a class="nk-wgw-inner" href="#">
                                <div class="nk-wgw-name">
                                    <div class="nk-wgw-icon">
                                        <em class="icon ni ni-truck"></em>
                                    </div>
                                    <h5 class="nk-wgw-title title">In Transit</h5>
                                </div>
                                <div class="nk-wgw-balance">
                                    <div class="amount">2</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card bg-light">
                        <div class="nk-wgw sm">
                            <a class="nk-wgw-inner" href="#">
                                <div class="nk-wgw-name">
                                    <div class="nk-wgw-icon">
                                        <em class="icon ni ni-text-rich"></em>
                                    </div>
                                    <h5 class="nk-wgw-title title">Arrived</h5>
                                </div>
                                <div class="nk-wgw-balance">
                                    <div class="amount">0</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card bg-light">
                        <div class="nk-wgw sm">
                            <a class="nk-wgw-inner" href="#">
                                <div class="nk-wgw-name">
                                    <div class="nk-wgw-icon">
                                        <em class="icon ni ni-check-thick"></em>
                                    </div>
                                    <h5 class="nk-wgw-title title">Received</h5>
                                </div>
                                <div class="nk-wgw-balance">
                                    <div class="amount">5</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->
        </div>


        <div class="nk-block">

            @foreach($subscribes as $subscribe)
                <div class="card card-bordered sp-plan">
                <div class="row no-gutters">
                    <div class="col-md-8">
                        <div class="sp-plan-info card-inner">
                            <div class="row gx-0 gy-3">
                                <div class="col-xl-9 col-sm-8">
                                    <div class="sp-plan-name">
                                        <h6 class="title">{{ $subscribe->tracking_no }}
                                            {!! getParcelStatus($subscribe->tracking_no) !!}
                                        </h6>
                                        <p>Trip ID: <span class="text-base">{{ ($subscribe->parcel)? $subscribe->parcel->trip->code : "Not found" }}</span></p>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-4">
                                    <div class="sp-plan-opt">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_notify_" id="is_notify_{{ $subscribe->tracking_no }}" {{ ($subscribe->is_notify ==1)? "checked" : "" }}>
                                            <label class="custom-control-label text-soft" for="is_notify_{{ $subscribe->tracking_no }}">Notify</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .sp-plan-info -->
                        <div class="sp-plan-desc card-inner">
                            <ul class="row gx-1">
                                <li class="col-6 col-lg-3">
                                    <p><span class="text-soft">Notes</span>{{ $subscribe->remark }}</p>
                                </li>
                                @if($subscribe->parcel)
                                    <li class="col-6 col-lg-6">
                                        <p><span class="text-soft">Last Transaction	</span>
                                            <small>{{ $subscribe->parcel->lastTransaction->remark }}</small>
                                        </p>
                                    </li>
                                @endif
                            </ul>
                        </div><!-- .sp-plan-desc -->
                    </div><!-- .col -->
                    <div class="col-md-4">
                        <div class="sp-plan-action card-inner">
                            @if($subscribe->parcel)
                                <div class="sp-plan-btn">
                                    <a href="{{ route('frontend.user.subscribe.view', $subscribe->tracking_no) }}" class="btn btn-primary"><span>View</span></a>
                                </div>
                            @else
                                <div class="sp-plan-note text-md-center">
                                    <p>Utem-mel still not receive this parcel</p>
                                </div>
                            @endif
                        </div>
                    </div><!-- .col -->
                </div><!-- .row -->
            </div>
            @endforeach
        </div>
    </div>
@endsection
