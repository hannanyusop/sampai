@extends('backend.layouts.app')

@section('title', __('View'))

@php

@endphp

@section('content')
    <div class="nk-content-wrap">

        <div class="sp-plan-head">
            <h6 class="title">{{ __('Billing for Trip Batch :number', ['number' => $tripBatch->number]) }}</h6>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner">


                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                    <tr>
                                        <th>{{ __('Customer Name') }}</th>
                                        <th>{{ __('Pickup Code') }}</th>
                                        <th>{{ __('Parcel Coding') }}</th>
                                        <th>{{ __('Total Payment') }}</th>
                                        <th>{{ __('Status') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tripBatch->pickups as $pickup)
                                        <tr>
                                            <td>{{ $pickup?->user?->name }}</td>
                                            <td>{{ $pickup->code }}</td>
                                            <td>
                                                @foreach($pickup->parcels as $parcel)
                                                    {{ __(':coding - :price', ['coding' => $parcel->coding, 'price' => displayPriceFormat($parcel->total_billing, '$')]) }}
                                                @endforeach
                                            </td>
                                            <td>{{ displayPriceFormat($pickup?->total_payment, '$') }}</td>
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
