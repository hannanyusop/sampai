@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    @php $data = parcelData() @endphp

    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-head-sub"><span>Welcome!</span>
                </div>
                <div class="nk-block-between-md g-4">
                    <div class="nk-block-head-content">
                        <h2 class="nk-block-title fw-normal">{{ auth()->user()->name }}</h2>
                        <div class="nk-block-des">
                            <p>Role : Finance</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->


            <div class="">
                <h5>Total Sale by Office</h5>
                <p>Date : <b>{{ $today }}</b></p>
            </div>

            <div class="nk-block mt-5">


                <div class="row g-gs">
                    @foreach($daily_sales as $sale)
                        <div class="col-md-4">
                            <div class="card card-full">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <h6 class="subtitle">{{ $sale->office->label }}</h6>
                                        </div>
                                        <div class="card-tools">
                                            @if(is_null($sale->deposit_received))
                                                <em class="card-hint icon ni ni-alert-circle text-danger"></em>
                                            @else
                                                <em class="card-hint icon ni ni-check-circle text-success"></em>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount">{{ displayPriceFormat($sale->total_sales, '$') }}</span>
                                    </div>
                                    <div class="invest-data">
                                        <div class="invest-data-amount g-2">
                                            <div class="invest-data-history">
                                                <div class="title">Cash</div>
                                                <div class="amount">{{ displayPriceFormat($sale->cash, '$') }}</div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title">Bank Transfer</div>
                                                <div class="amount">{{ displayPriceFormat($sale->cash, '$') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invest-data-ck">
                                            <canvas class="iv-data-chart" id="totalDeposit" style="display: block; box-sizing: border-box; height: 68px; width: 88px;" width="176" height="136"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

@endsection
@push('after-scripts')
@endpush
