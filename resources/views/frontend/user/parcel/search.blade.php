@extends('frontend.layouts.app')

@section('title', __('Search Parcel'))

@section('content')
    <div class="nk-content-wrap">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="card-head">
                    <h5 class="card-title">Search Parcel</h5>
                </div>
                <x-forms.get class="form-validate gy-3">
                <div class="row g-3 align-center">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control text-uppercase form-control-lg" id="tracking_no" name="tracking_no" value="{{ request('tracking_no') }}" placeholder="ER123456MY">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-7 offset-lg-5">
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-lg btn-primary">Search</button>
                                <a href="{{ route('frontend.user.parcel.search') }}" class="btn btn-lg btn-outline-warning">Clear</a>
                            </div>
                        </div>
                    </div>
                </x-forms.get>
            </div>
        </div>

        @if(request()->tracking_no)
            @if($parcel)
            <div class="card card-bordered mt-3">
                <div class="card-inner">
                        <div class="timeline">
                            <h6 class="timeline-head">November, 2020</h6>
                            <ul class="timeline-list">

                                @foreach($parcel->transactions as $transaction)
                                    <li class="timeline-item">
                                        <div class="timeline-status bg-primary"></div>
                                        <div class="timeline-date">{{ reformatDatetime($transaction->created_at, 'd M') }} <em class="icon ni ni-alarm-alt"></em></div>
                                        <div class="timeline-data">
                                            <h6 class="timeline-title">{{ $transaction->remark }}</h6>
                                            <div class="timeline-des">
                                                <span class="time">{{ reformatDatetime($transaction->created_at, 'h:i A') }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                </div>
            </div>
            @else
                <div class="example-alert m-3">
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em> No parcel found for <strong>{{ request()->tracking_no }}</strong></div>
                </div>
            @endif
        @endif
    </div>
@endsection
