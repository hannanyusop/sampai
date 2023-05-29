<div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">

                    <input class="form-control" wire:mode="tracking_no">
                    <button wire:click="search()">Search</button>
                </div>
            </div>
        </div>

        <div class="col-md-8">

            @if($parcel)
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-bordered">
                            <div class="card-inner-group">
                                <div class="card-inner">
                                    <div class="sp-plan-head">
                                        <h6 class="title">Parcel Details</h6>
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
                                </div><!-- .card-inner -->
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .col -->
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
                </div>
            @endif
        </div>
    </div>
</div>
