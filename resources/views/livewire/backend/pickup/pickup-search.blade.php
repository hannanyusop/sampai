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
                        <p>This page for search customer pickup list
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
                <div class="col-md-12">
                    <div class="card card-bordered mb-2">
                        <div class="nk-help-plain card-inner text-center">
                            <div class="nk-help-text">
                                <h5>Search Pickup </h5>
                                <p class="text-soft">Insert customer pickup code Ex : K-1</p>
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

                    @if($pickup)
                        <div class="card">
                            <div class="card-aside-wrap">
                                <div class="card-content">

                                    <div class="card-inner">
                                        <div class="nk-block">
                                            <div class="nk-block-head">
                                                <h5 class="title">Parcel Information</h5>
                                            </div>

                                            <div class="nk-block-head nk-block-head-line">
                                                <h6 class="title overline-title text-base">Pickup Detail</h6>
                                            </div>
                                            <div class="profile-ud-list">
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Code</span>
                                                        <span class="profile-ud-value">{{ $pickup->code }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Total Parcel</span>
                                                        <span class="profile-ud-value">{{ $pickup->parcels->count() }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Destination</span>
                                                        <span class="profile-ud-value">{{ $pickup->dropPoint->label }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-block">
                                            <div class="nk-block-head nk-block-head-line">
                                                <h6 class="title overline-title text-base">Billing Detail</h6>
                                            </div>
                                            <div class="profile-ud-list">
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Total Billing (Actual)</span>
                                                        <span class="profile-ud-value">{{ displayPriceFormat($pickup->total, '$') }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Payment Status</span>
                                                        <span class="profile-ud-value">{{ $pickup->payment_status_label }}</span>
                                                    </div>
                                                </div>
                                                @if($pickup->payment_status == \App\Services\Pickup\PickupHelperService::PAYMENT_STATUS_PAID)
                                                    <div class="profile-ud-item">
                                                        <div class="profile-ud wider">
                                                            <span class="profile-ud-label">Payment Received Detail</span>
                                                            <span class="profile-ud-value">
                                                                Method : {{ $pickup->payment_method_label }}<br>
                                                            Amount : {{ displayPriceFormat($pickup->total_payment, '$') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="nk-divider divider md"></div>
                                        <div class="nk-block">
                                            <div class="nk-block-head nk-block-head-sm nk-block-between">
                                                <h5 class="title">Handover Detail {!! $pickup->status_badge !!}</h5>
                                            </div>

                                            <div class="my-2">
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

                                                    <ul class="row gx-1">
                                                        <li class="col-sm-4">
                                                            <p>
                                                                <span class="text-soft">Payment Type</span>
                                                            </p>
                                                            <div class="g-4 align-center flex-wrap">
                                                                @foreach(\App\Services\Pickup\PickupHelperService::paymentMethodLabel() as $key => $value)
                                                                    <div class="g">
                                                                        <div class="custom-control custom-control-sm custom-radio">
                                                                            <input type="radio" class="custom-control-input" name="payment_type" id="payment_method_{{ $key }}"  wire:model="payment_method" value="{{ $key }}">
                                                                            <label class="custom-control-label" for="payment_method_{{ $key }}">{{ $value }}</label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            @error('payment_method')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </li>
                                                        <li class="col-sm-4">
                                                            <p>
                                                                <span class="text-soft">Total Payment Receive</span>
                                                            </p>
                                                            <div class="form-control-wrap">
                                                                <div class="form-icon form-icon-left"> $
                                                                </div>
                                                                <input type="number" min="0.00" step="0.01" class="form-control"  wire:model="total_payment">
                                                            </div>
                                                            @error('total_payment')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </li>
                                                        <li class="col-sm-4">
                                                            <p>
                                                                <span class="text-soft">Prof Of Delivery</span>
                                                            </p>
                                                            <div class="form-control-wrap">
                                                                <div class="form-file">
                                                                    <input type="file" accept="image/*" class="form-file-input" id="customFile" wire:model="prof_of_delivery">
                                                                    <br>@error('prof_of_delivery')<span class="text-danger">{{ $message }}</span>@enderror
                                                                    <small>* Only Image Allowed</small>
                                                                </div>

                                                            </div>


                                                        </li>
                                                        <li class="col-sm-4">
                                                            @if ($prof_of_delivery)
                                                                Invoice Preview:<br>
                                                                <img width="200px" src="{{ $prof_of_delivery->temporaryUrl() }}">
                                                            @endif
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

                                        <hr>

                                        <div class="nk-block">
                                            <div class="nk-block-head nk-block-head-sm nk-block-between">
                                                <h5 class="title">Parcel List</h5>
                                            </div>

                                            @include('components.parcel.summary-box')
                                        </div>
                                    </div>
                                </div>
                                <div class="card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-xxl toggle-screen-xxl" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
                                    <div class="card-inner-group" data-simplebar="init">
                                        <div class="simplebar-wrapper" style="margin: 0px;">
                                            <div class="simplebar-height-auto-observer-wrapper">
                                                <div class="simplebar-height-auto-observer"></div>
                                            </div>
                                            <div class="simplebar-mask">
                                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                                        <div class="simplebar-content" style="padding: 0px;">
                                                            <div class="card-inner">
                                                                <div class="user-card user-card-s2">
                                                                    <img src="{{ asset($pickup->user->avatar) }}" class="user-avatar lg bg-primary"></img>
                                                                    <div class="user-info">
                                                                        <div class="badge bg-outline-light rounded-pill ucap">Investor</div>
                                                                        <h5>{{ $pickup->user->name }}</h5>
                                                                        <span class="sub-text">{{ $pickup->user->phone_number }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-inner">
                                                                <h6 class="overline-title-alt mb-3">Parcels List </h6>
                                                                <ul class="g-1">
                                                                    @forelse($pickup->parcels as $parcel)
                                                                        <li class="btn-group">
                                                                            <a class="btn btn-xs btn-light btn-dim" href="#">{{ $parcel->tracking_no }}</a>
                                                                            <a class="btn btn-xs btn-icon btn-light btn-dim" href="#">
                                                                                <em class="icon ni ni-cross"></em>
                                                                            </a>
                                                                        </li>
                                                                    @empty
                                                                        - No Parcel -
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="simplebar-placeholder" style="width: auto; height: 868px;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                            <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
