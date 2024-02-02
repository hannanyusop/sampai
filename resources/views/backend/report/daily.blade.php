@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Daily Sales Report</h3>
                        </div>

                    </div>
                </div>

                <div class="card card-bordered my-2">
                    <div class="card-inner">
                        <form action="#">
                            <div class="row g-4">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label" for="date">Date</label>
                                        <div class="form-control-wrap">
                                            <input type="date" class="form-control" name="date" id="date" value="{{ $date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label class="form-label">Drop Point</label>
                                        <ul class="custom-control-group g-3 align-center">
                                            @foreach(dropPoints() as $dp)
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-radio">
                                                        <input type="radio" class="custom-control-input" name="office_id" value="{{ $dp->id }}" id="dp_{{ $dp->id }}" {{ ($dp->id == $office_id)? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="dp_{{ $dp->id }}">{{ $dp->name }}</label>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-lg-7 offset-lg-5">
                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn btn-lg btn-primary">Get Report</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if($sale)
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="user-card user-card-s2">
                                            <div class="user-info">
                                                <h5>{{ $sale->office->label }}</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-inner">
                                        <h6 class="overline-title mb-2">Short Details</h6>
                                        <div class="row g-3">
                                            <div class="col-sm-6 col-md-4 col-xl-12">
                                                <span class="sub-text">Manager:</span>
                                                <span>{{ $sale->office->manager() }}</span>
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-xl-12">
                                                <span class="sub-text">Sales Deposit Attachment:</span>
                                                <span>
                                                    @if($sale->sales_deposit_attachment)
                                                        <img width="100px" src="{{ asset($sale->deposit_receipt) }}"</img>
                                                    @else
                                                        No Attachment
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-xl-12">
                                                <span class="sub-text">Sales Deposit Received:</span>
                                                <span>
                                                    @if($sale->deposit_received)
                                                        <span class="badge badge-success">Yes</span> ({{ $sale->deposit_received }})
                                                    @else
                                                        <span class="badge badge-danger">No</span>
                                                    @endif
                                                </span>
                                            </div>

                                        </div>

                                        @if(is_null($sale->deposit_received))
                                            <hr>
                                            <h6 class="lead-text">Already received payment? If yes mark as received.</h6>
                                            <div class="nk-block-actions flex-shrink-0">
                                                <form action="{{ route('admin.report.dailyUpdate', $sale->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="deposit_received" value="1">
                                                    <button type="submit" class="btn btn-lg btn-dim btn-primary" onclick="confirm('Are you sure?')">Received</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="nk-block">
                                        <div class="overline-title-alt mb-2 mt-2">Sales</div>
                                        <div class="profile-balance">
                                            <div class="profile-balance-group gx-4">
                                                <div class="profile-balance-sub">
                                                    <div class="profile-balance-amount">
                                                        <div class="number">{{ displayPriceFormat($sale->total_sales, '$') }}</div>
                                                    </div>
                                                    <div class="profile-balance-subtitle">Total Sales</div>
                                                </div>
                                                <div class="profile-balance-sub">
                                                    <div class="profile-balance-amount">
                                                        <div class="number">{{ displayPriceFormat($sale->expected_sales, '$') }}</div>
                                                    </div>
                                                    <div class="profile-balance-subtitle">Expected Sales</div>
                                                </div>
                                                <div class="profile-balance-sub">
                                                    <div class="profile-balance-amount">
                                                        <div class="number">{{ displayPriceFormat($sale->cash, '$') }}</div>
                                                    </div>
                                                    <div class="profile-balance-subtitle">Cash Received</div>
                                                </div>
                                                <div class="profile-balance-sub">
                                                    <div class="profile-balance-amount">
                                                        <div class="number">{{ displayPriceFormat($sale->bank_transfer, '$') }}</div>
                                                    </div>
                                                    <div class="profile-balance-subtitle">Direct Bank Transfer</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-block">
                                        <h6 class="lead-text mb-3">Sales Log</h6>
                                        <div class="nk-tb-list nk-tb-ulist is-compact card">
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col">
                                                    <span class="sub-text">Pickup Code</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-sm">
                                                    <span class="sub-text">Total Price</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-xxl">
                                                    <span class="sub-text">Payment Receive</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="sub-text">Method</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="sub-text">Stafg</span>
                                                </div>
                                            </div>
                                            @foreach($sale->pickups as $pickup)
                                            <div class="nk-tb-item {{ ($pickup->total != $pickup->total_payment)? "bg-danger text-white" : "" }}">
                                                <div class="nk-tb-col">
                                                    <span class="fw-bold">{{ $pickup->code }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-sm">
                                                    <span class="fw-bold">{{ displayPriceFormat($pickup->total, '$') }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-xxl">
                                                    <span class="fw-bold">{{ displayPriceFormat($pickup->total_payment, '$') }}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="fw-bold">{{ $pickup->payment_method_label }}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="sub-text">
                                                        {{ $pickup?->pic?->name }}
                                                    </span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <p class="h-100 w-100 bg-white border border-dashed round-xl p-4 d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#add-card">
                        <span class="text-soft">No Data</span>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script type="text/javascript">

    </script>
@endpush
