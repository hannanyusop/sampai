@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-8">

                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Trip List (Ajax search)</h5>
                            </div>
                            <form action="#">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="trip_no">Trip No</label>
                                            <div class="form-control-wrap">
                                                <input id="trip_no" name="trip_no" type="text" class="form-control" placeholder="Ex: LES-11111-1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="pay-card-1">
                                                        <label class="custom-control-label" for="pay-card-1">All</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="pay-card-1">
                                                        <label class="custom-control-label" for="pay-card-1">Opened</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="pay-bitcoin-1">
                                                        <label class="custom-control-label" for="pay-bitcoin-1">In Transit</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="pay-cash-1">
                                                        <label class="custom-control-label" for="pay-cash-1">Completed</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Drop Point</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="com-email-1" checked>
                                                        <label class="custom-control-label" for="com-email-1">All</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="com-email-1">
                                                        <label class="custom-control-label" for="com-email-1">FTMK</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="com-sms-1">
                                                        <label class="custom-control-label" for="com-sms-1">FKM</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="com-phone-1">
                                                        <label class="custom-control-label" for="com-phone-1">LES</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="com-phone-1">
                                                        <label class="custom-control-label" for="com-phone-1">SATR</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--                                                            <div class="col-12">-->
                                    <!--                                                                <div class="form-group">-->
                                    <!--                                                                    <button type="submit" class="btn btn-lg btn-primary">Search (Ajax)</button>-->
                                    <!--                                                                </div>-->
                                    <!--                                                            </div>-->
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-bordered">
                        <div class="card-inner p-0 border-top">
                            <div class="nk-tb-list nk-tb-orders">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col"><span>Trip No.</span></div>
                                    <div class="nk-tb-col tb-col-sm"><span>Destination</span></div>
                                    <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                    <div class="nk-tb-col"><span>Amount</span></div>
                                    <div class="nk-tb-col"><span class="d-none d-sm-inline">Status</span></div>
                                    <div class="nk-tb-col"><span class="d-none d-sm-inline">Current Location</span></div>
                                    <div class="nk-tb-col"><span>&nbsp;</span></div>
                                </div>
                                @foreach($trips as $trip)
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <span class="tb-lead"><a href="#">{{ $trip->code }}</a></span>
                                        </div>
                                        <div class="nk-tb-col tb-col-sm">
                                            <div class="user-card">
                                                <div class="user-name">
                                                    <span class="tb-lead">{{ $trip->destination->code }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <span class="tb-sub">{{ $trip->date }}</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span class="tb-sub tb-amount">{{ $trip->parcels->count() }} Parcel(s)</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            @if($trip->status == 0)
                                                <span class="badge badge-dot badge-dot-xs badge-secondary">Open</span>
                                            @else
                                                <span class="badge badge-dot badge-dot-xs badge-success">In Transit</span>
                                            @endif
                                        </div>
                                        <div class="nk-tb-col">Runner</div>
                                        <div class="nk-tb-col nk-tb-col-action">
                                            <div class="dropdown">
                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-md">
                                                    <ul class="link-list-plain">
                                                        <li><a href="{{ route('admin.trip.view', $trip->id) }}">View</a></li>
                                                        <li><a href="{{ route('admin.trip.addParcel', $trip->id) }}">Add Parcel</a></li>
                                                        <li><a href="{{ route('admin.trip.transferCode', $trip->id) }}">Transfer Trip (runner)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div><!-- .card -->
                </div>
            </div>
        </div>

    </div>
@endsection
@push('after-scripts')

@endpush
