@extends('frontend.layouts.app')

@section('title', __('Parcel List'))


@section('content')
    <div class="nk-content-wrap">

        <div class="row">
            <div class="col-xl-12">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="sp-plan-head">
                                <h6 class="title">Parcel Details</h6>
                                <div class="text-right mt-n5 mr-n2">
                                    @if($parcel->status == \App\Services\Parcel\ParcelHelperService::STATUS_REGISTERED)
                                        <a href="{{ route('frontend.user.parcel.edit',encrypt($parcel->id)) }}" class="btn btn-md btn-primary">Edit Parcel</a>
                                    @endif
                                </div>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-1">
                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Tracking No.</span>
                                            {{ $parcel->tracking_no }}
                                        </p>
                                    </li>
                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Date Received</span>
                                            {{ $parcel->created_at }}
                                        </p>
                                    </li>

                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Destination</span>
                                            {{ $parcel?->dropPoint?->name }}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-1">
                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Quantity</span>
                                            {{ $parcel->quantity }}
                                        </p>
                                    </li>

                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Price</span>
                                            {{ $parcel->price_formated }}
                                        </p>
                                    </li>

                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Tax</span>
                                            {{ $parcel->tax_formated }}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-1">
                                    <li class="col-sm-8">
                                        <p><span class="text-soft">Item Description (Keterangan barang)</span>
                                            {{ $parcel->description }}
                                        </p>
                                    </li>

                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Invoice</span>
                                            <a href="{{ route('frontend.user.parcel.download',encrypt($parcel->id)) }}" download><i class="fa fa-download me-2"></i> Download</a>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div>

        <div class="nk-block nk-block-lg my-3">

            <div class="nk-iv-scheme-list text-center">
                <div class="nk-iv-scheme-item">
                    <div class="nk-iv-scheme-term">
                        <div class="nk-iv-scheme-start nk-iv-scheme-order">
                            <span class="nk-iv-scheme-value date">Register Parcel</span>
                            <span class="nk-iv-scheme-label text-soft">Customer</span>
                        </div>
                        <div class="nk-iv-scheme-start nk-iv-scheme-order">
                            <span class="nk-iv-scheme-value date">Received From Curier</span>
                            <span class="nk-iv-scheme-label text-soft">Limbang / Miri Office</span>
                        </div>
                        <div class="nk-iv-scheme-start nk-iv-scheme-order">
                            <span class="nk-iv-scheme-value date">Outbound To Drop Point</span>
                            <span class="nk-iv-scheme-label text-soft">Runner</span>
                        </div>
                        <div class="nk-iv-scheme-start nk-iv-scheme-order">
                            <span class="nk-iv-scheme-value date">Inbound To Drop Point</span>
                            <span class="nk-iv-scheme-label text-soft">Runner</span>
                        </div>
                        <div class="nk-iv-scheme-start nk-iv-scheme-order">
                            <span class="nk-iv-scheme-value date">Sorting Process </span>
                            <span class="nk-iv-scheme-label text-soft">Lambak /Kilanas office</span>
                        </div>
                        <div class="nk-iv-scheme-end nk-iv-scheme-order">
                            <span class="nk-iv-scheme-value date">Ready To Collect</span>
                            <span class="nk-iv-scheme-label text-soft">Lambak /Kilanas office</span>
                        </div>
                    </div>
                </div><!-- .nk-iv-scheme-item -->
            </div><!-- .nk-iv-scheme-list -->
        </div>

        @if($parcel->status == 3 && auth()->user()->can('staff.inhouse') )
            <div class="card card-bordered mt-3">
                <div class="card-inner">
                    <x-forms.post :action="route('admin.parcel.deliver', $parcel->tracking_no)" class="form-validate gy-3">
                        <div class="row g-3 align-center">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="pickup_name">Receiver Name</label>
                                    <span class="form-note">Required</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="custom-control-wrap">
                                        <input type="text" name="pickup_name" id="pickup_name" class="form-control" value="{{ $name  }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 align-center">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="pickup_info">Receiver Info</label>
                                    <span class="form-note">Required</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="custom-control-wrap">
                                        <input type="text" name="pickup_info" id="pickup_info" class="form-control" value="{{ $receiver_info }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-7 offset-lg-5">
                                <div class="form-group mt-2">
                                    <button  class="btn btn-lg btn-primary submit">Mark As Receive</button>
                                </div>
                            </div>
                        </div>
                    </x-forms.post>
                </div>
            </div>
        @else
        @endif

        <div class="card card-bordered mt-3">
            <div class="card-inner">
                <div class="timeline">
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

            <div id="as-root"></div><script>(function(e,t,n){var r,i=e.getElementsByTagName(t)[0];if(e.getElementById(n))return;r=e.createElement(t);r.id=n;r.src="//s.trackingmore.com/button/getbutton.js";i.parentNode.insertBefore(r,i)})(document,"script","trackingmore-jssdk")</script>
        </div>

    </div>

    <div id="embedTrack"></div>
    <script src="//www.tracking.my/track-button.js"></script>
    <script>
        TrackButton.embed({
            selector: "#embedTrack",
            tracking_no: "{{ $parcel->tracking_no }}",
        });
    </script>
@endsection
