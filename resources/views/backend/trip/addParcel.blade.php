@extends('backend.layouts.app')

@section('title', __('Add Trip'))

@section('content')
    <div class="nk-content-wrap">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-sub">
                <a class="back-to" href="{{ route('admin.trip.index') }}"><em class="icon ni ni-arrow-left"></em><span>Trip List</span></a>
            </div>
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h2 class="nk-block-title fw-normal">{{ $trip->code }}</h2>
                    <div class="nk-block-des">
                        <p>Created at <span class="text-soft">{{ $trip->created_at->diffForHumans() }}</span> <span class="text-primary"><em class="icon ni ni-info"></em></span></p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools justify-content-md-end g-1 flex-wrap">
                        <li class="order-md-last">
                            <a href="{{ route('admin.trip.view', $trip->id) }}" class="btn btn-auto btn-success">
                                <em class="icon ni ni-list"></em><span>All Parcel</span>
                            </a>
                        </li>
                        <li class="order-md-last">
                            <a href="#" class="btn btn-auto btn-warning" data-toggle="modal" data-target="#subscription-cancel">
                                <em class="icon ni ni-cross"></em><span>Close Trip</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- .nk-block-head -->
        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner card-inner-md">
                    <div class="card-title-group">
                        <h6 class="card-title">Pending Parcel </h6>
                    </div>
                </div>

                <form  class="nk-refwg-invite card-inner">
                    <div class="nk-refwg-head g-3">
                        <div class="nk-refwg-title">
                            <h5 class="title">Search Parcel</h5>
                            <div class="title-sub">You can add parcel to subscription list for faster parcel status checking.</div>
                        </div>
                    </div>
                    <div class="nk-refwg-url">
                        <div class="form-control-wrap">
                            <div class="form-clip clipboard-init"><button type="submit" class="btn"><em class="clipboard-icon icon ni ni-search"></em> <span class="clipboard-text"> Search</span></button></div>
                            <div class="form-icon">
                                <em class="icon ni ni-tag-alt"></em>
                            </div>
                            <input type="text" class="form-control copy-text" id="tracking_no" name="tracking_no" placeholder="ER123456MY" value="{{ request('tracking_no') }}">
                        </div>
                    </div>
                </form>

                <table class="table table-tranx">
                    <thead>
                    <tr class="tb-tnx-head">
                        <th class="tb-tnx-id"><span class="">Tracking No</span></th>
                        <th class="tb-tnx-info">
                                <span class="tb-tnx-desc d-none d-sm-inline-block">
                                    <span>Receiver Name</span>
                                </span>
                        </th>
                        <th class="tb-tnx-amount">
                            <span>Receiver Info</span>
                        </th>
                        <th class="tb-tnx-amount">
                            <span>Action</span>
                        </th>
                    </tr><!-- .tb-tnx-item -->
                    </thead>
                    <tbody>
                    @foreach($pending_parcels as $parcel)
                        <tr class="tb-tnx-item">
                            <td class="tb-tnx-id">
                                {{ $parcel->tracking_no }}
                            </td>
                            <td class="tb-tnx-info">
                                <span class="title">{{ $parcel->receiver_name }}</span>
                            </td>
                            <td class="">
                                <span class="date">{{ $parcel->receiver_info }}</span>
                            </td>
                            <td class="">
                                <a class="btn btn-sm btn-success btn-dim" onclick="return confirm('Are you sure want to assign this parcel ({{ $parcel->tracking_no }})?')" href="{{ route('admin.trip.assignParcel', [$trip, $parcel]) }}">Assign</a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- .card -->
        </div><!-- .nk-block -->
        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner card-inner-md">
                    <div class="card-title-group">
                        <h6 class="card-title">Previous Parcel </h6>
                        <div class="card-action">
                            <a href="{{ route('admin.trip.view', $trip->id) }}" class="link link-sm">View All Parcel</a>
                        </div>
                    </div>
                </div>
                <table class="table table-tranx">
                    <thead>
                        <tr class="tb-tnx-head">
                            <th class="tb-tnx-id"><span class="">Tracking No</span></th>
                            <th class="tb-tnx-info">
                                <span class="tb-tnx-desc d-none d-sm-inline-block">
                                    <span>Receiver Name</span>
                                </span>
                            </th>
                            <th class="tb-tnx-amount">
                                <span>Receiver Info</span>
                            </th>
                            <th class="tb-tnx-amount">
                                <span>Action</span>
                            </th>
                        </tr><!-- .tb-tnx-item -->
                    </thead>
                    <tbody>
                    @foreach($parcels as $parcel)
                        <tr class="tb-tnx-item">
                            <td class="tb-tnx-id">
                                {{ $parcel->tracking_no }}
                            </td>
                            <td class="tb-tnx-info">
                                <span class="title">{{ $parcel->receiver_name }}</span>
                            </td>
                            <td class="">
                                <span class="date">{{ $parcel->receiver_info }}</span>
                            </td>
                            <td class="">
                                <a class="btn btn-sm btn-warning btn-dim" onclick="return confirm('Are you sure want to remove this parcel ({{ $parcel->tracking_no }})?')" href="{{ route('admin.trip.deleteParcel', $parcel->id) }}">Remove</a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- .card -->
        </div><!-- .nk-block -->
    </div>

    <div class="modal fade" tabindex="-1" id="subscription-cancel">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
                <div class="modal-body modal-body-md">
                    <h4 class="nk-modal-title title">Close Trip</h4>
                    <p><strong>Are you sure you want to close this trip?</strong></p>
                    <p>Notes : You cannot add/update/delete parcel after the trip close.</p>
                    <div class="form">
                        <ul class="align-center flex-wrap g-3">
                            <li>
                                <a href="{{ route('admin.trip.close', $trip->id) }}" class="btn btn-light">Sure, Close This Trip</a>
                            </li>
                            <li>
                                <button class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#subscription-cancel-confirmed">Cancel</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div><!-- .modal -->
@endsection
@push('after-scripts')

@endpush
