@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="kyc-app wide-sm m-auto">
        <div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
            <div class="nk-block-head-content text-center">
                <h2 class="nk-block-title fw-normal">Collect Parcel QRCode</h2>
                <div class="nk-block-des">
                    <p>Show this QR to Drop Point Officer</p>
                </div>
            </div>
        </div><!-- .nk-block-head -->
        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner card-inner-lg">
                    <div class="nk-kyc-app p-sm-2 text-center">
                        <div class="nk-kyc-app-icon">
                            {!! getQr($sub->parcel->tracking_no) !!}
                        </div>
                        <div class="nk-kyc-app-text mx-auto">
                            <h4 class="text-uppercase">{{ auth()->user()->name }}</h4>
                            <h6 class="text-uppercase">Tracking : {{ $sub->parcel->tracking_no }}</h6>
                            <p class="lead"></p>
                        </div>
                        <div class="nk-kyc-app-action">
                            <a href="{{ route('frontend.user.subscribe.index') }}" class="btn btn-lg btn-primary">Back To Subscription List</a>
                        </div>
                    </div>
                </div>
            </div><!-- .card -->
        </div> <!-- .nk-block -->
    </div>
@endsection
@push('after-scripts')
@endpush
