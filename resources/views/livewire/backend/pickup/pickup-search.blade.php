<div>
    <div class="nk-content-wrap">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-sub">
                <a class="back-to" href="{{ route('admin.dashboard') }}">
                    <em class="icon ni ni-arrow-left"></em>
                    <span>Back To Dashboard</span>
                </a>
            </div>
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h2 class="nk-block-title fw-normal">Search Pickup List</h2>
                    <div class="nk-block-des">
                        <p>This page for search customer pickup list<span class="text-soft">(11 months 16 days remaining)</span>
                            <span class="text-primary">
              <em class="icon ni ni-info"></em>
            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible">
                <div class="alert-text">
                    {{ session('error') }}
                </div>
                <button class="close" data-dismiss="alert"></button>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible">
                <div class="alert-text">
                    {{ session('success') }}
                </div>
                <button class="close" data-dismiss="alert"></button>
            </div>
        @endif
        <div class="nk-block">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card card-bordered card-full d-none d-xl-block">
                        <div class="nk-help-plain card-inner text-center">
                            <div class="nk-help-text">
                                <h5>Search Pickup </h5>
                                <p class="text-soft">Insert customer pickup code Ex : KLN-1</p>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="code" name="code" placeholder="Pickup Code" wire:model="code">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="nk-help-action">
                                <button type="submit" class="btn btn-lg btn-primary" wire:click="search()">Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                @if($pickup)
                    <div class="col-xl-8">
                    <div class="card card-bordered">
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="sp-plan-head">
                                    <h6 class="title">Pickup Details</h6>
                                </div>
                                <div class="sp-plan-desc sp-plan-desc-mb">
                                    <ul class="row gx-1">
                                        <li class="col-sm-4">
                                            <p>
                                                <span class="text-soft">Code</span> {{ $pickup->code }}
                                            </p>
                                        </li>
                                        <li class="col-sm-4">
                                            <p>
                                                <span class="text-soft">Destination</span> {{ $pickup->dropPoint->name }}
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-inner">
                                <div class="sp-plan-head">
                                    <h6 class="title">Owner Details</h6>
                                </div>
                                <div class="sp-plan-desc sp-plan-desc-mb">
                                    <ul class="row gx-1">
                                        <li class="col-sm-4">
                                            <p>
                                                <span class="text-soft">Id</span> {{ $pickup->user->id }}
                                            </p>
                                        </li>
                                        <li class="col-sm-4">
                                            <p>
                                                <span class="text-soft">Customer Name</span> {{ $pickup->user->name }}
                                            </p>
                                        </li>
                                        <li class="col-sm-4">
                                            <p>
                                                <span class="text-soft">Customer Phone Number</span> {{ $pickup->user->phone_number }}
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-inner">
                                <div class="sp-plan-head">
                                    <h6 class="title">Handover Detail {!! $pickup->status_badge !!}</h6>
                                </div>
                                @if($pickup->status == \App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER && auth()->user()->can('staff.inhouse') && $pickup->office_id == auth()->user()->office_id)
                                <div class="sp-plan-desc sp-plan-desc-mb">
                                    <ul class="row gx-1">
                                        <li class="col-sm-4">
                                            <p>
                                                <span class="text-soft">PIC</span>
                                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                            </p>
                                        </li>
                                        <li class="col-sm-4">
                                            <p>
                                                <span class="text-soft">Picked On</span>
                                                <input type="text" class="form-control" value="{{ now() }}" disabled>
                                            </p>
                                        </li>
                                        <li class="col-sm-4">
                                            <p>
                                                <span class="text-soft">Receiver Name</span>
                                                <input type="text" class="form-control"  wire:model="pickup_name">

                                                @error('pickup_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </p>
                                        </li>
                                    </ul>

                                    <div class="nk-block-head-content my-2">
                                        <button class="btn btn-auto btn-dim btn-info"
                                           wire:click="deliver"
                                           onclick="return confirm('Are you sure want to hand over this parcel?')">
                                            <em class="icon ni ni-check-circle"></em>
                                            <span>Handover Parcel</span>
                                        </button>
                                    </div>
                                </div>
                                @else
                                    <div class="sp-plan-desc sp-plan-desc-mb">
                                        <ul class="row gx-1">
                                            <li class="col-sm-4">
                                                <p>
                                                    <span class="text-soft">PIC</span>
                                                    {{ $pickup?->pic?->name ?? "-" }}
                                                </p>
                                            </li>
                                            <li class="col-sm-4">
                                                <p>
                                                    <span class="text-soft">Picked On</span>
                                                    {{ $pickup->pickup_datetime ?? "-" }}
                                                </p>
                                            </li>
                                            <li class="col-sm-4">
                                                <p>
                                                    <span class="text-soft">Receiver Name</span>
                                                    {{ $pickup->pickup_name ?? "-" }}
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @if($pickup)
            <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner card-inner-md">
                    <div class="card-title-group">
                        <h6 class="card-title">Parcel List</h6>
{{--                        <div class="card-action">--}}
{{--                            <a href="/demo4/subscription/payments.html" class="link link-sm">Download Statement</a>--}}
{{--                        </div>--}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        @forelse($pickup->parcels as $parcel)
                            <div class="card card-bordered m-2">
                                <div class="card-inner-group">
                                    <div class="card-inner">
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
                                                        {{ displayPriceFormat($parcel->price) }}
                                                    </p>
                                                </li>

                                                <li class="col-sm-4">
                                                    <p><span class="text-soft">Tax</span>
                                                        {{ displayPriceFormat($parcel->tax, '$') }}
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
                                                        <a href="{{ \asset($parcel->invoice_url) }}" download><i class="fa fa-download me-2"></i> Download</a>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- .card-inner -->
                                </div>
                            </div>
                        @empty
                            <tr class="tb-tnx-item">
                                <td class="">
                                    <a href="#">
                                        <span>No Parcel Found</span>
                                    </a>
                                </td>

                            </tr>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
