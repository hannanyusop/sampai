@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    @php $data = parcelData() @endphp

    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-head-sub"><span>Welcome!</span>
                </div>
                <div class="nk-block-between-md g-4">
                    <div class="nk-block-head-content">
                        <h2 class="nk-block-title fw-normal">{{ auth()->user()->name }}</h2>
                        <div class="nk-block-des">
                            <p>Role : Runner</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->

            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-xl-4">
                        <div class="row g-gs">
                            <div class="col-lg-6 col-xl-12">
                                <div class="card card-bordered card-full">
                                    <div class="card-inner">
                                        <div class="nk-cov-wg2">
                                            <div class="card-title">
                                                <h5 class="title">Trip <small>Report</small></h5>
                                            </div>
                                            <div class="nk-cov-group">
                                                <div class="nk-cov-data">
                                                    <h6 class="overline-title">Closed</h6>
                                                    <div class="amount amount-sm">{{ $picked_trips->count() }}</div>
                                                </div>
                                                <div class="nk-cov-data">
                                                    <h6 class="overline-title">Picked</h6>
                                                    <div class="amount amount-sm text-info">{{ $closed_trips->count() }}</div>
                                                </div>
                                                <div class="nk-cov-data">
                                                    <h6 class="overline-title">Total</h6>
                                                    <div class="amount amount-sm text-success">{{ $picked_trips->count()+$closed_trips->count() }}</div>
                                                </div>
                                            </div>
                                            <div class="nk-cov-wg2-group">
                                                <ul class="nk-cov-wg2-data">
                                                    <small>Total Trip Created By Year</small>

                                                    <li>
                                                        <div class="title">
                                                            <div class="dot dot-lg sq bg-purple"></div>
                                                            <span> {{ date('Y') }} </span>
                                                        </div>
                                                        <div class="count">{{ $total['current'] }}</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">
                                                            <div class="dot dot-lg sq bg-success"></div>
                                                            <span> {{ date('Y')-1 }}</span>
                                                        </div>
                                                        <div class="count">{{ $total['prev'] }}</div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .col -->

                    <div class="col-xl-8">
                        <div class="card card-bordered">
                            <div class="card-inner mb-n2">
                                <div class="card-title-group">
                                    <div class="card-title card-title-sm">
                                        <h6 class="title">Closed Trip</h6>
                                        <p>Pick this trip and transfer to their destination(Drop Point Office).</p>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-list is-loose traffic-channel-table">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col nk-tb-channel"><span>Code</span></div>
                                    <div class="nk-tb-col nk-tb-prev-sessions"><span>Create At</span></div>
                                    <div class="nk-tb-col nk-tb-change"><span>Total Parcel(s)</span></div>
                                    <div class="nk-tb-col nk-tb-change tb-col-sm text-right"><span></span></div>
                                </div><!-- .nk-tb-head -->

                                @if($closed_trips->count() == 0)
                                    <div class="nk-tb-col nk-tb-covid tb-col-sm text-right"><span>No Closed Trip Found</span></div>
                                @else
                                    @foreach($closed_trips as $trip)
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">{{ $trip->number }}</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-prev-sessions">
                                                <span class="tb-sub tb-amount"><span>{{ reformatDatetime($trip->date, 'M d, Y h:i A') }}</span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-change">
                                        <span class="tb-sub">
                                            {{ $trip->parcels->count() }}<span class="currency currency-usd"> Parcel(s) </span>
                                        </span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-trend text-right">
                                                <div class="dropdown">
                                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-md">
                                                        <ul class="link-list-plain">
                                                            <li><a href="{{ route('admin.tripBatch.show', $trip->id) }}">View</a></li>
                                                            @if($trip->status == \App\Services\Trip\TripHelperService::STATUS_CLOSED)
                                                                <li><a href="{{ route('admin.trip.picked', $trip->id) }}">Pick</a></li>
                                                            @elseif($trip->status == \App\Services\Trip\TripHelperService::STATUS_IN_TRANSIT && $trip->runner_id == auth()->user()->id)
                                                                <li><a href="{{ route('admin.trip.transferCode', $trip->id) }}">Transfer Trip</a></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div><!-- .nk-tb-list -->
                        </div><!-- .card -->

                        <div class="card card-bordered">
                            <div class="card-inner mb-n2">
                                <div class="card-title-group">
                                    <div class="card-title card-title-sm">
                                        <h6 class="title">Picked Trip</h6>
                                        <p>Notes : Show OTP/QRCode to drop point officer to transfer the trip.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr class="bg-dark text-white">
                                                <th>Code</th>
                                                <th>Created At</th>
                                                <th>Total Parcel</th>
                                                <th>Destination</th>
                                            </tr>
                                            <tbody>
                                            @forelse($picked_trips as $tripBatch)
                                                <tr>
                                                    <td>{{ $tripBatch->number }}</td>
                                                    <td>{{ reformatDatetime($tripBatch->date, 'M d, Y h:i A') }}</td>
                                                    <td>
                                                        {{ $tripBatch->parcels->count() }}<span class="currency currency-usd"> Parcel(s) </span>
                                                    </td>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <th>Destination</th>
                                                                <th>Parcel(s)</th>
                                                                <th></th>
                                                            </tr>
                                                            @foreach($tripBatch->trips as $trip)
                                                                <tr>
                                                                    <td>{{ $trip->destination->name }}</td>
                                                                    <td>{{ $trip->parcels->count() }}</td>
                                                                    <td>
                                                                        @if(auth()->user()->can('staff.runner'))
                                                                            @if($trip->status == \App\Services\Trip\TripHelperService::STATUS_IN_TRANSIT && $trip->runner_id == auth()->user()->id)
                                                                                <a class="btn btn-info btn-sm" href="{{ route('admin.trip.transferCode', $trip->id) }}">Transfer</a>
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3">
                                                        <div class="nk-tb-col nk-tb-covid tb-col-sm text-right"><span>No Picked Trip Found</span></div>
                                                    </td>
                                                </tr>

                                            @endforelse
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card -->
                    </div>
                </div><!-- .row -->
            </div>
        </div>
    </div>

@endsection
@push('after-scripts')
@endpush
