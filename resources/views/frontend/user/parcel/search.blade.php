@extends('frontend.layouts.app')

@section('title', __('Search Parcel'))

@section('content')

    <div class="nk-block">
        <div class="card card-bordered">
            <div class="nk">
                <form  class="nk-refwg-invite card-inner">
                    <div class="nk-refwg-head g-3">
                        <div class="nk-refwg-title">
                            <h5 class="title">Search Parcel</h5>
                            <div class="title-sub">You can add parcel to subscription list for faster parcel status checking.</div>
                        </div>
                        <div class="nk-refwg-action">
                            <a href="{{ route('frontend.user.subscribe.create') }}" class="btn btn-primary">Subscribe</a>
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
            </div>
        </div><!-- .card -->
    </div><!-- .nk-block -->

    <div class="nk-content-wrap">
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
