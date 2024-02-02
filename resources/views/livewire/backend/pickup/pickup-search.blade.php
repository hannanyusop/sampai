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
                <div class="col-md-4">
                    <div class="card card-bordered">
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

                        @if($pickup)
                            <div class="nk-block m-4">
                                <div class="">
                                    <h5 class="title">Handover Detail {!! $pickup->status_badge !!}</h5>
                                </div>

                                @if($pickup->status == \App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER && auth()->user()->can('staff.inhouse') && $pickup->office_id == auth()->user()->office_id)

                                    <div class="row">

                                        <div class="col-md-6 mb-2">
                                            <span class="text-soft">PIC</span>
                                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <span class="text-soft">Picked On</span>
                                            <input type="text" class="form-control" value="{{ now() }}" disabled>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <span class="text-soft">Receiver Name</span>
                                            <input type="text" class="form-control"  wire:model="pickup_name">

                                            @error('pickup_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <p>
                                                <span class="text-soft">Payment Type</span>
                                            </p>
                                            @error('payment_method')<span class="text-danger">{{ $message }}</span>@enderror
                                            @foreach(\App\Services\Pickup\PickupHelperService::paymentMethodLabel() as $key => $value)
                                                <div class="g">
                                                    <div class="custom-control custom-control-sm custom-radio">
                                                        <input type="radio" class="custom-control-input" name="payment_type" id="payment_method_{{ $key }}" wire:change="getBalance()"  wire:model="payment_method" value="{{ $key }}">
                                                        <label class="custom-control-label" for="payment_method_{{ $key }}">{{ $value }}</label>
                                                    </div>
                                                </div>
                                            @endforeach

                                            @error('payment_method')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td>Total Billing</td>
                                                        <td>{{ displayPriceFormat($pickup->total, '$') }}</td>
                                                    </tr>
                                                    @if(in_array($payment_method, [\App\Services\Pickup\PickupHelperService::PAYMENT_METHOD_BANK_TRANSFER, \App\Services\Pickup\PickupHelperService::PAYMENT_METHOD_BOTH]))
                                                    <tr>
                                                        <td>Bank Transfer</td>
                                                        <td>
                                                            <div class="col-md-12">
                                                                <div class="form-control-wrap">
                                                                    <div class="form-icon form-icon-left"> $
                                                                    </div>
                                                                    <input type="number" min="0.00" step="0.01" class="form-control" wire:change="getBalance()"  wire:model="bank_transfer_received">
                                                                </div>
                                                                @error('bank_transfer_received')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if(in_array($payment_method, [\App\Services\Pickup\PickupHelperService::PAYMENT_METHOD_CASH, \App\Services\Pickup\PickupHelperService::PAYMENT_METHOD_BOTH]))
                                                    <tr>
                                                        <td>Cash Receive</td>
                                                        <td>
                                                                <div class="col-md-12">
                                                                    <span class="text-soft"></span>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-left"> $
                                                                        </div>
                                                                        <input type="number" min="0.00" step="0.01" class="form-control" wire:change="getBalance()"  wire:model="cash_received">
                                                                    </div>
                                                                    @error('cash_received')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td>Total Payment</td>
                                                        <td class="text-right font-weight-bold">{{ displayPriceFormat($total_payment, '$') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Balance</td>
                                                        <td class="text-right font-weight-bold {{ $balance == 0 ? "text-success" : "text-danger" }}">{{ displayPriceFormat($balance, '$') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-2">
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
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            @if ($prof_of_delivery)
                                                Invoice Preview:<br>
                                                <img width="200px" src="{{ $prof_of_delivery->temporaryUrl() }}">
                                            @endif
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <span class="text-soft">Note</span>
                                            <textarea class="form-control" wire:model="notes" placeholder="You can put any payment remark here ... "></textarea>

                                            @error('notes')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <button class="btn btn-auto btn-dim btn-info"
                                                    wire:click="deliver"
                                                    onclick="return confirm('Are you sure want to hand over this parcel?')">
                                                <em class="icon ni ni-check-circle"></em>
                                                <span>Handover Parcel</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-8">
                    @if($pickup)
                        <div class="card">
                            <div class="card-aside-wrap">
                                <div class="card-content">

                                    <div class="card-inner">
                                        <div class="nk-block">
                                            <div class="nk-block-head">
                                                <h5 class="title">Pickup Information</h5>
                                            </div>

                                            <div class="nk-block-head nk-block-head-line">
                                                <h6 class="title overline-title text-base">Owner Detail</h6>
                                            </div>
                                            <div class="sp-plan-desc sp-plan-desc-mb">
                                                <ul class="row gx-1">
                                                    <li class="col-sm-4">
                                                        <p>
                                                            <span class="text-soft">Name</span>
                                                            {{ $pickup->user->name }}
                                                        </p>
                                                    </li>
                                                    <li class="col-sm-4">
                                                        <p>
                                                            <span class="text-soft">Phone Number</span>
                                                            {{ $pickup->user->phone_number }}
                                                        </p>
                                                    </li>
                                                    <li class="col-sm-4">
                                                        <p>
                                                            <span class="text-soft">Email</span>
                                                            {{ $pickup->user_email ?? "-" }}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>

                                            <hr>

                                            <div class="nk-block-head nk-block-head-line mt-2">
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

                                        <hr>
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

                                        <hr>

                                        @if($pickup->status == \App\Services\Pickup\PickupHelperService::STATUS_DELIVERED)


                                        <div class="nk-block-head nk-block-head-line">
                                            <h6 class="title overline-title text-base">Handover Detail</h6>
                                        </div>
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

                                        <hr>

                                        @endif

                                        <div class="nk-block">
                                            <div class="nk-block-head nk-block-head-sm nk-block-between">
                                                <h5 class="title">Parcel List</h5>
                                            </div>

                                            @include('components.parcel.summary-box')
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
