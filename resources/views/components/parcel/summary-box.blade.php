
<div class="nk-block">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr class="nk-tb-item nk-tb-head">
                <th class="nk-tb-col">
                    <h6 class="overline-title">Tracking No / Coding</h6>
                </th>
                @if(auth()->user()->type == \App\Domains\Auth\Models\User::TYPE_ADMIN)
                    <th class="nk-tb-col">
                        <h6 class="overline-title">Guni</h6>
                    </th>
                @endif
                @if(auth()->user()->type == \App\Domains\Auth\Models\User::TYPE_USER && !in_array($pickup->status, [\App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER, \App\Services\Pickup\PickupHelperService::STATUS_DELIVERED]))
                @else
                    <th class="nk-tb-col">
                        <h6 class="overline-title">COD Charge</h6>
                    </th>
                    <th class="nk-tb-col">
                        <h6 class="overline-title">Tax</h6>
                    </th>
                    <th class="nk-tb-col">
                        <h6 class="overline-title">Service Charge</h6>
                    </th>
                    <th class="nk-tb-col">
                        <h6 class="overline-title">Permit</h6>
                    </th>
                    <th class="nk-tb-col">
                        <h6 class="overline-title">Total</h6>
                    </th>
                @endif
                <th class="nk-tb-col">
                    <h6 class="overline-title">Invoice</h6>
                </th>
                {{--                <th class="nk-tb-col"></th>--}}
            </tr>
            </thead>
            <tbody>
            @forelse($pickup->parcels as $parcel)
                <tr class="nk-tb-item">
                    <td class="nk-tb-col">
                        <div class="sub-text">
                            <div>{{ $parcel->tracking_no }}</div>
                            <div class="font-weight-bold">{{ $parcel->coding }}</div>
                        </div>
                    </td>
                    @if(auth()->user()->type == \App\Domains\Auth\Models\User::TYPE_ADMIN)
                        <td class="nk-tb-col">
                            <div class="sub-text">
                                <div>{{ $parcel->guni }}</div>
                            </div>
                        </td>
                    @endif
                    @if(auth()->user()->type == \App\Domains\Auth\Models\User::TYPE_USER && !in_array($pickup->status, [\App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER, \App\Services\Pickup\PickupHelperService::STATUS_DELIVERED]))
                    @else
                        <td class="nk-tb-col">
                            <div class="sub-text">
                                <div>{{ displayPriceFormat($parcel->cod_fee, '$')}}</div>
                            </div>
                        </td>
                        <td class="nk-tb-col">
                            <div class="sub-text">
                                <div>{{ displayPriceFormat($parcel->tax, '$')}}</div>
                            </div>
                        </td>
                        <td class="nk-tb-col">
                            <div class="sub-text">
                                <div>{{ displayPriceFormat($parcel->service_charge, '$')}}</div>
                            </div>
                        </td>
                        <td class="nk-tb-col">
                            <div class="sub-text">
                                <div>{{ displayPriceFormat($parcel->permit, '$')}}</div>
                            </div>
                        </td>
                        <td class="nk-tb-col">
                            <div class="sub-text">
                                <div>{{ displayPriceFormat($parcel->total_billing, '$')}}</div>
                            </div>
                        </td>
                    @endif
                    <td class="nk-tb-col">
                        <a href="{{ route('frontend.user.parcel.download',encrypt($parcel->id)) }}" class="btn btn-info btn-sm">
                            <em class="icon ni ni-eye"></em>
                            <span>Invoice</span>
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="nk-tb-item">
                    <td class="nk-tb-col" colspan="4">
                        <div class="caption-text">{{ __('No Parcel') }}</div>
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>
    </div>
</div>

{{--<div class="card card-bordered">--}}
{{--    <div class="card-inner-group">--}}
{{--        <div class="card-inner">--}}
{{--            <div class="sp-plan-head">--}}
{{--                <h6 class="title">Parcel Details</h6>--}}
{{--            </div>--}}
{{--            <div class="sp-plan-desc sp-plan-desc-mb">--}}
{{--                <ul class="row gx-1">--}}
{{--                    <li class="col-sm-4">--}}
{{--                        <p><span class="text-soft">Tracking No .</span>--}}
{{--                            {{ $parcel->tracking_no }}--}}
{{--                        </p>--}}
{{--                    </li>--}}
{{--                    <li class="col-sm-4">--}}
{{--                        <p><span class="text-soft">Coding</span>--}}
{{--                            {{ $parcel->coding }}--}}
{{--                        </p>--}}
{{--                    </li>--}}

{{--                    <li class="col-sm-4">--}}
{{--                        <p><span class="text-soft">Destination</span>--}}
{{--                            {{ $parcel?->dropPoint?->name }}--}}
{{--                        </p>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--            <div class="sp-plan-desc sp-plan-desc-mb">--}}
{{--                <ul class="row gx-1">--}}
{{--                    <li class="col-sm-4">--}}
{{--                        <p>--}}
{{--                            <span class="text-soft">Latest Status</span>--}}
{{--                            <b><span class="ni ni-alert-circle"></span>{{ $parcel->status_label }}</b>--}}
{{--                        </p>--}}
{{--                    </li>--}}
{{--                    <li class="col-sm-4">--}}
{{--                        <p><span class="text-soft">Invoice</span>--}}
{{--                            <a href="{{ route('frontend.user.parcel.download',encrypt($parcel->id)) }}" download><i class="fa fa-download me-2"></i> Download</a>--}}
{{--                        </p>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--            <hr>--}}
{{--            @if(auth()->user()->type == \App\Domains\Auth\Models\User::TYPE_USER && !in_array($parcel->status, [\App\Services\Parcel\ParcelHelperService::STATUS_READY_TO_COLLECT, \App\Services\Parcel\ParcelHelperService::STATUS_DELIVERED]))--}}

{{--            @else--}}
{{--                <div class="sp-plan-desc sp-plan-desc-mb">--}}
{{--                    <ul class="row gx-1">--}}
{{--                        <li class="col-sm-3">--}}
{{--                            <p><span class="text-soft">Service Charge</span>--}}
{{--                                {{ displayPriceFormat($parcel->service_charge, '$') }}--}}
{{--                            </p>--}}
{{--                        </li>--}}

{{--                        <li class="col-sm-3">--}}
{{--                            <p><span class="text-soft">Tax</span>--}}
{{--                                {{ displayPriceFormat($parcel->tax, '$') }}--}}
{{--                            </p>--}}
{{--                        </li>--}}

{{--                        <li class="col-sm-3">--}}
{{--                            <p><span class="text-soft">Permit</span>--}}
{{--                                {{  displayPriceFormat($parcel->permit, '$') }}--}}
{{--                            </p>--}}
{{--                        </li>--}}

{{--                        <li class="col-sm-3">--}}
{{--                            <p><span class="text-soft">Cod Fee <small><i>(For COD Only)</i></small></span>--}}
{{--                                {{ $parcel->cod_fee > 0 ? displayPriceFormat($parcel->cod_fee, '$') : __('-NA-') }}--}}
{{--                            </p>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="sp-plan-desc sp-plan-desc-mb">--}}
{{--                    <ul class="row gx-1">--}}

{{--                        <li class="col-sm-4">--}}
{{--                            <div class="text-success font-weight-bold"><span>Total Billing </span>--}}
{{--                                <h4 class="text-success">--}}
{{--                                    {{ displayPriceFormat($parcel->total_billing, '$') }}--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div><!-- .card-inner -->--}}
{{--    </div><!-- .card-inner-group -->--}}
{{--</div>--}}
