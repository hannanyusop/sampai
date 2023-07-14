<div class="card card-bordered">
    <div class="card-inner-group">
        <div class="card-inner">
            <div class="sp-plan-head">
                <h6 class="title">Parcel Details</h6>
            </div>
            <div class="sp-plan-desc sp-plan-desc-mb">
                <ul class="row gx-1">
                    <li class="col-sm-4">
                        <p><span class="text-soft">Tracking No .</span>
                            {{ $parcel->tracking_no }}
                        </p>
                    </li>
                    <li class="col-sm-4">
                        <p><span class="text-soft">Coding</span>
                            {{ $parcel->coding }}
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
                        <p>
                            <span class="text-soft">Latest Status</span>
                            <b><span class="ni ni-alert-circle"></span>{{ $parcel->status_label }}</b>
                        </p>
                    </li>
                    <li class="col-sm-4">
                        <p><span class="text-soft">Invoice</span>
                            <a href="{{ route('frontend.user.parcel.download',encrypt($parcel->id)) }}" download><i class="fa fa-download me-2"></i> Download</a>
                        </p>
                    </li>
                </ul>
            </div>
            <hr>
            @if(auth()->user()->type == \App\Domains\Auth\Models\User::TYPE_USER && !in_array($parcel->status, [\App\Services\Parcel\ParcelHelperService::STATUS_READY_TO_COLLECT, \App\Services\Parcel\ParcelHelperService::STATUS_DELIVERED]))

            @else
                <div class="sp-plan-desc sp-plan-desc-mb">
                    <ul class="row gx-1">
                        <li class="col-sm-3">
                            <p><span class="text-soft">Service Charge</span>
                                {{ displayPriceFormat($parcel->service_charge, '$') }}
                            </p>
                        </li>

                        <li class="col-sm-3">
                            <p><span class="text-soft">Tax</span>
                                {{ displayPriceFormat($parcel->tax, '$') }}
                            </p>
                        </li>

                        <li class="col-sm-3">
                            <p><span class="text-soft">Permit</span>
                                {{  displayPriceFormat($parcel->permit, '$') }}
                            </p>
                        </li>

                        <li class="col-sm-3">
                            <p><span class="text-soft">Cod Fee <small><i>(For COD Only)</i></small></span>
                                {{ $parcel->cod_fee > 0 ? displayPriceFormat($parcel->cod_fee, '$') : __('-NA-') }}
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="sp-plan-desc sp-plan-desc-mb">
                    <ul class="row gx-1">

                        <li class="col-sm-4">
                            <div class="text-success font-weight-bold"><span>Total Billing </span>
                                <h4 class="text-success">
                                    {{ displayPriceFormat($parcel->total_billing, '$') }}
                                </h4>
                            </div>
                        </li>
                    </ul>
                </div>
            @endif
        </div><!-- .card-inner -->
    </div><!-- .card-inner-group -->
</div>
