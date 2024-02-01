<div class="nk-block">

    <div class="card card-bordered my-2">
        <div class="card-inner">
            <div>
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label" for="date">From</label>
                            <div class="form-control-wrap">
                                <input type="date" class="form-control" name="date" id="date" value="{{ $from }}" wire:model="from">
                            </div>
                        </div>
                        @error('from')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label" for="date">From</label>
                            <div class="form-control-wrap">
                                <input type="date" class="form-control" name="date" id="date" value="{{ $to }}" wire:model="to">
                            </div>
                        </div>
                        @error('to')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Drop Point</label>
                            <ul class="custom-control-group g-3 align-center">
                                @foreach(dropPoints() as $dp)
                                    <li>
                                        <div class="custom-control custom-control-sm custom-radio">
                                            <input type="radio" class="custom-control-input" wire:model="office_id" name="office_id" value="{{ $dp->id }}" id="dp_{{ $dp->id }}" {{ ($dp->id == $office_id)? 'checked' : '' }}>
                                            <label class="custom-control-label" for="dp_{{ $dp->id }}">{{ $dp->name }}</label>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                            @error('office_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-lg-7 offset-lg-5">
                        <div class="form-group mt-2">
                            <button wire:click="filter()" class="btn btn-lg btn-primary">Get Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($sales) > 0)
        <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-title-group pb-3 g-2">
                        <div class="card-title card-title-sm">
                            <h6 class="title">Cumulative Sale</h6>
                            <p>Total Days : {{ $total_days }} days</p>
                        </div>

                    </div>
                    <div class="analytic-ov">
                        <div class="analytic-data-group analytic-ov-group g-3">
                            <div class="analytic-data analytic-ov-data">
                                <div class="title">Total Sales</div>
                                <div class="amount">{{ displayPriceFormat($total_sales, '$') }}</div>
                            </div>
                            <div class="analytic-data analytic-ov-data">
                                <div class="title">Expected Sales</div>
                                <div class="amount">{{ displayPriceFormat($expected_sales, '$') }}</div>

                            </div>
                            <div class="analytic-data analytic-ov-data">
                                <div class="title">Cash Received</div>
                                <div class="amount">{{ displayPriceFormat($cash_received, '$') }}</div>
                            </div>
                            <div class="analytic-data analytic-ov-data">
                                <div class="title">Direct Bank Transfer</div>
                                <div class="amount">{{ displayPriceFormat($bank_transfer, '$') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner mb-n2">
                    <div class="card-title-group">
                        <div class="card-title card-title-sm">
                            <h6 class="title">Sales Details</h6>
                        </div>
                    </div>
                </div>
                <div class="nk-tb-list is-loose traffic-channel-table">
                    <div class="nk-tb-item nk-tb-head">
                        <div class="nk-tb-col nk-tb-channel">
                            <span>Date</span>
                        </div>
                        <div class="nk-tb-col nk-tb-sessions">
                            <span>Total Sales</span>
                        </div>
                        <div class="nk-tb-col nk-tb-prev-sessions">
                            <span>Expected Sales</span>
                        </div>
                        <div class="nk-tb-col nk-tb-change">
                            <span>Cash Received</span>
                        </div>
                        <div class="nk-tb-col nk-tb-trend tb-col-sm text-end">
                            <span>Direct Bank Transfer</span>
                        </div>
                    </div>
                    @foreach($sales as $sale)
                    <div class="nk-tb-item">
                        <div class="nk-tb-col nk-tb-channel">
                            <span class="tb-lead">{{ $sale->sales_date }}</span>
                        </div>
                        <div class="nk-tb-col nk-tb-sessions">
                          <span class="tb-sub tb-amount">
                            <span>{{ displayPriceFormat($sale->total_sales, '$') }}</span>
                          </span>
                        </div>
                        <div class="nk-tb-col nk-tb-prev-sessions">
                          <span class="tb-sub tb-amount">
                            <span>{{ displayPriceFormat($sale->expected_sales, '$') }}</span>
                          </span>
                        </div>
                        <div class="nk-tb-col nk-tb-trend text-end">
                            {{ displayPriceFormat($sale->cash, '$') }}
                        </div>
                        <div class="nk-tb-col nk-tb-change">
                          <span class="tb-sub">
                            <span>{{ displayPriceFormat($sale->bank_transfer, '$') }}</span>
                          </span>
                        </div>

                    </div>
                    @endforeach
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
