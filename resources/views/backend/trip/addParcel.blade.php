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
                    <ul class="nk-block-tools justify-content-md-end g-4 flex-wrap">
                        <li class="order-md-last">
                            <a href="#" class="btn btn-auto btn-primary" data-toggle="modal" data-target="#subscription-cancel">
                                <em class="icon ni ni-cross"></em><span>Close Trip</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- .nk-block-head -->
        <div class="nk-block">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Add Parcel</h5>
                            </div>
                            <x-forms.post :action="route('admin.trip.insertParcel', $trip->id)" class="form-validate">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="tracking_no">Tracking No</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control text-uppercase" id="tracking_no" name="tracking_no" value="{{ old('tracking_no') }}" required>
                                                @error('tracking_no')
                                                    <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="receiver_name">Receiver Name</label>
                                            <div class="form-control-wrap">
                                                <input type="text" list="prevUser" class="form-control text-uppercase" id="receiver_name" name="receiver_name" value="{{ old('receiver_name') }}">
                                                <datalist id="prevUser">
                                                    @foreach($sName as $suggestion)
                                                        <option value="{{ $suggestion['receiver_name'] }}">
                                                    @endforeach
                                                </datalist>
                                                @error('name')
                                                    <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="receiver_info">Receiver Info</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" list="prevInfo" id="receiver_info" name="receiver_info" placeholder="Email address / Staff No /Student No" value="{{ old('receiver_info') }}">
                                                <datalist id="prevInfo">
                                                    @foreach($sInfo as $suggestion)
                                                        <option value="{{ $suggestion['receiver_info'] }}">
                                                    @endforeach
                                                </datalist>
                                                @error('receiver_info')
                                                    <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="remark">Remark</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control" id="name" name="name" rows="5"> {{ old('name') }}</textarea>
                                                @error('remark')
                                                    <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary">Insert Parcel</button>
                                        </div>
                                    </div>
                                </div>
                            </x-forms.post>
                        </div>
                    </div>
                </div><!-- .col -->
            </div>
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
                                <a class="btn btn-sm btn-danger btn-dim" onclick="return confirm('Are you sure want to remove this parcel ({{ $parcel->tracking_no }})?')" href="{{ route('admin.trip.deleteParcel', $parcel->id) }}">Delete</a>
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
                                <a href="{{ route('admin.trip.close', $trip->id) }}" class="btn btn-light" data-dismiss="modal">Sure, Close This Trip</a>
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
