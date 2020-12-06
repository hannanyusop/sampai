@extends('backend.layouts.app')

@section('title', __('Transfer Code'))

@section('content')
    <div class="nk-content-wrap">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <div class="preview-block">
                            <span class="preview-title-lg overline-title">Transfer Trip</span>
                            <div class="row gy-4">

                                <div class="col-md-12">
                                    <dl class="row">
                                        <dt class="col-sm-3">Trip ID</dt>
                                        <dd class="col-sm-9"><b>{{ $trip->code }}</b></dd>
                                        <dt class="col-sm-3">Destination</dt>
                                        <dd class="col-sm-9">
                                            <p>{{ $trip->destination->code }}</p>
                                            <p>{{ $trip->destination->name }}</p>
                                        </dd>
                                        <dt class="col-sm-3">Date</dt>
                                        <dd class="col-sm-9">{{ $trip->date }}</dd>
                                        <dt class="col-sm-3 text-truncate">Amount</dt>
                                        <dd class="col-sm-9">{{ $trip->parcels->count() }} Parcel(s)</dd>
                                        <dt class="col-sm-3 text-truncate">Remark</dt>
                                        <dd class="col-sm-9"><small>{{ $trip->remark }}</small></dd>
                                    </dl>
                                </div>
                                <div class="col-sm-12">
                                    <h6 class="text-center text-primary"><small class="font-weight-bold">One Time Password</small></h6>
                                    <h3 class="text-center text-success mb-5">{{ $trip->receive_code }}</h3>

                                    <div class="form-group text-center">
                                        <a href="{{ route('admin.trip.index') }}" class="btn btn-lg btn-warning">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
@endpush
