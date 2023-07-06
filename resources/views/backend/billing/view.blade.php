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
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <td>{{ __('Phone Number') }}</td>
                                        <th>{{ __('Code') }}</th>
                                        <th>{{ __('Parcel Coding') }}</th>
                                        <td>{{ __('Quantity') }}</td>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Tax') }}</th>
                                        <th>{{ __('Permit') }}</th>
                                        <th>{{ __('Postage') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th>{{ __('Location') }}</th>
                                        <th>{{ __('Status') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tripBatch->pickups as $pickup)
                                        <tr>
                                            <td>{{ $pickup?->user?->name }}</td>
                                            <td>{{ $pickup?->user?->phone_number }}</td>
                                            <td>{{ $pickup->code }}</td>
                                            <td>
                                                @foreach($pickup->parcels as $parcel)
                                                    <small>{{ __(':coding - :price', ['coding' => $parcel->coding, 'price' => displayPriceFormat($parcel->total_billing, '$')]) }}</small><br>
                                                @endforeach
                                            </td>
                                            <td>{{ $pickup->parcels->count() }}</td>
                                            <td>{{ displayPriceFormat($pickup->gross_price, '$') }}</td>
                                            <td>{{ displayPriceFormat($pickup->tax, '$') }}</td>
                                            <td>{{ displayPriceFormat($pickup->permit, '$') }}</td>
                                            <td>{{ displayPriceFormat($pickup?->service_charge, '$') }}</td>
                                            <td>{{ displayPriceFormat($pickup?->total, '$') }}</td>
                                            <td>{{ $pickup?->dropPoint->code }}</td>
                                            <td>{!! $pickup?->status_badge !!}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div><!-- .card-inner -->
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div>
    </div>
@endsection
