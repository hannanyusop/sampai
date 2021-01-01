@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-6">
                    <div class="row g-gs">
                        <div class="col-lg-6 col-xxl-12">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-2">
                                        <div class="card-title">
                                            <h6 class="title">Parcel Receive</h6>
                                            <p>Parcel received in last 30 days.</p>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Revenue from subscription"></em>
                                        </div>
                                    </div>
                                    <div class="align-end gy-3 gx-5 flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                        <div class="nk-sale-data-group flex-md-nowrap g-4">
                                            <div class="nk-sale-data">
                                                <span class="amount">14,299.59 <span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>16.93%</span></span>
                                                <span class="sub-title">This Month</span>
                                            </div>
                                            <div class="nk-sale-data">
                                                <span class="amount">7,299.59 <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>4.26%</span></span>
                                                <span class="sub-title">This Week</span>
                                            </div>
                                        </div>
                                        <div class="nk-sales-ck sales-revenue">
                                            <canvas class="sales-bar-chart" id="salesRevenue"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-12">
                            <div class="row g-gs">
                                <div class="col-sm-6 col-lg-12 col-xxl-6">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-2">
                                                <div class="card-title">
                                                    <h6 class="title">In Process Parcel</h6>
                                                </div>
                                                <div class="card-tools">
                                                    <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total active subscription"></em>
                                                </div>
                                            </div>
                                            <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                <div class="nk-sale-data">
                                                    <span class="amount">9.69K</span>
                                                    <span class="sub-title"><span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>1.93%</span>since last month</span>
                                                </div>
                                                <div class="nk-sales-ck">
                                                    <canvas class="sales-bar-chart" id="activeSubscription"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->
                                <div class="col-sm-6 col-lg-12 col-xxl-6">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-2">
                                                <div class="card-title">
                                                    <h6 class="title">Avg Parcel Received</h6>
                                                </div>
                                                <div class="card-tools">
                                                    <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Daily Avg. subscription"></em>
                                                </div>
                                            </div>
                                            <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                <div class="nk-sale-data">
                                                    <span class="amount">346.2</span>
                                                    <span class="sub-title"><span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>2.45%</span>since last week</span>
                                                </div>
                                                <div class="nk-sales-ck">
                                                    <canvas class="sales-bar-chart" id="totalSubscription"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->
                            </div><!-- .row -->
                        </div><!-- .col -->
                    </div>
                </div><!-- .col -->
            </div>
        </div>

        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-8">

                    <div class="card card-bordered">
                        <div class="card-inner p-0 border-top">

                            <table class="table table-orders">
                                <thead class="tb-odr-head">
                                <tr class="tb-odr-item">
                                    <th class="tb-odr-info">
                                        <span class="tb-odr-id">Trip No.</span>
                                        <span class="tb-odr-date d-none d-md-inline-block">Date</span>
                                    </th>
                                    <th class="tb-odr-amount">
                                        <span class="tb-odr-total">Destination</span>
                                        <span class="tb-odr-status d-none d-md-inline-block">Status</span>
                                    </th>
                                    <th class="tb-odr-amount">
                                        <span class="tb-odr-total">Current Location</span>
                                        <span class="tb-odr-status d-none d-md-inline-block">Total Parcel</span>
                                    </th>
                                    <th class="tb-odr-action">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody class="tb-odr-body">
                                @foreach($trips as $trip)

                                <tr class="tb-odr-item">
                                    <td class="tb-odr-info">
                                        <span class="tb-odr-id"><a href="#">{{ $trip->code }}</a></span>
                                        <span class="tb-odr-date">{{ $trip->date }}</span>
                                    </td>
                                    <td class="tb-odr-amount">
                                        <span class="tb-odr-total">
                                            <span class="amount">{{ $trip->destination->code }}</span>
                                        </span>
                                        <span class="tb-odr-status">{!! getTripStatusBadge($trip->status) !!}</span>
                                    </td>
                                    <td class="tb-odr-amount">
                                         <span class="tb-odr-total">
                                            <span class="amount">Runner</span>
                                        </span>
                                        <span class="tb-odr-status">{{ $trip->parcels->count() }} Parcel(s)
                                        </span>
                                    </td>
                                    <td class="tb-odr-action">
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-md">
                                                <ul class="link-list-plain">
                                                    <li><a href="{{ route('admin.trip.view', $trip->id) }}">View</a></li>

                                                    @if(auth()->user()->can('staff.distributor'))
                                                        @if($trip->status == 0)
                                                            <li><a href="{{ route('admin.trip.addParcel', $trip->id)  }}">Add Parcel</a></li>
                                                            <li><a href="{{ route('admin.trip.close', $trip->id) }}" onclick="return confirm('Are you sure want to close this trip?')">Closed</a></li>
                                                        @endif
                                                    @endif
                                                    @if(auth()->user()->can('staff.runner'))
                                                        @if($trip->status == 1)
                                                            <li><a href="{{ route('admin.trip.picked', $trip->id) }}">Pick</a></li>
                                                        @elseif($trip->status == 2 && $trip->runner_id == auth()->user()->id)
                                                        <li><a href="{{ route('admin.trip.transferCode', $trip->id) }}">Transfer Trip</a></li>
                                                        @endif
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!-- .card -->
                </div>
            </div>
        </div>

    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/js/charts/gd-general.js') }}?ver=1.4.0"></script>
@endpush
