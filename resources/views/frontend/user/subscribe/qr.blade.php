@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <div class="preview-block">
                            {!! getQr($sub->parcel->tracking_no) !!}
                            <div class="row gy-4">
                                <div class="col-sm-12 text-center">
                                    <h4 class="text-uppercase">{{ auth()->user()->name }}</h4>
                                    <h6 class="text-uppercase">Tracking : {{ $sub->parcel->tracking_no }}</h6>

                                    <div class="form-group text-center">
                                        <a href="{{ route('frontend.user.subscribe.index') }}" class="btn btn-lg btn-primary">Back</a>
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
