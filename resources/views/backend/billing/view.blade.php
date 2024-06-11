@extends('backend.layouts.app')

@section('title', __('View'))

@php

@endphp

@section('content')

    <div class="nk-content-wrap">
        <div class="nk-block">

            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Billing</h3>
                        <div class="nk-block-des text-soft">
                            <p>Trip : <span class="text-base">{{ $tripBatch->number }}</span></p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="{{ route('admin.tripBatch.show', $tripBatch) }}" class="btn btn-outline-light bg-warning d-none d-sm-inline-flex"><em class="icon ni ni-back-alt"></em><span>Back</span></a>
                        <a href="{{ route('admin.billing.export', $tripBatch) }}"  class="btn btn-success d-none d-sm-inline-flex" download><em class="icon ni ni-download-cloud"></em><span>Export</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nk-content-wrap">

        <div class="row my-2">
            <div class="col-md-6">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="">
                                <p class="font-weight-bold">Release Trip<br>
                                    <small class="font-italic">
                                        This action cannot be undone.
                                        Make sure you've completed update all parcel billing before you release the trip.<br>
                                        Only status <span class="badge badge-success mx-1">{{\App\Services\Trip\TripHelperService::getStatuses(\App\Services\Trip\TripHelperService::STATUS_PICKUP_POINT_PROCESS) }}</span>  can be released.<br>
                                        Customer only can pickup parcel once you release the trip.
                                    </small>
                                </p>

                                <table class="table table-borderless">
                                    <thead>
                                    <tr>
                                        <th>Destination</th>
                                        <th>Status</th>
                                        <th>Release Trip</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tripBatch->trips as $trip)
                                        <tr>
                                            <td>{{ $trip->destination->code }}</td>
                                            <td>{!! $trip->status_badge !!}</td>
                                            <td>
                                                @if($trip->status == \App\Services\Trip\TripHelperService::STATUS_PICKUP_POINT_PROCESS)
                                                    <a onclick="return confirm('Are you sure want to release this trip?')"  href="{{ route('admin.trip.release', $trip) }}" class="btn btn-primary">Release</a>
                                                @endif

                                                @if($trip->status == \App\Services\Trip\TripHelperService::STATUS_ARRIVED)
                                                    <span class="">{{ __("Released") }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @livewire('backend.billing.billing-view', ['tripBatch' => $tripBatch])

    </div>
@endsection
