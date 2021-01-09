@extends('frontend.layouts.app')

@section('title', __('Top-up Wallet'))

@section('content')
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-lg">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-sub"><span>Account Balance</span></div>
                    <div class="nk-block-between-md g-4">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title fw-normal">Wallet</h2>
                            <div class="nk-block-des">
                                <p>See full list of your wallet transaction</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="nk-block-tools gx-3">
                                <li class="btn-wrap"><a href="{{ route('frontend.user.wallet.toppup') }}" class="btn btn-icon btn-xl btn-success"><em class="icon ni ni-wallet-in"></em></a><span class="btn-extext">Top-up</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-bordered text-center">
                        <div class="nk-refwg-sub">
                            <div class="text-primary"><h2 class="text-success">{{ displayPriceFormat(auth()->user()->wallet) }}</h2></div>
                            <div class="sub-text">Current Balance</div>
                        </div>
                    </div><!-- .card -->
                </div>

                <div class="nk-block nk-block-sm">
                    <h6 class="lead-text text-soft">Transaction History</h6>
                    <div class="tranx-list tranx-list-stretch card card-bordered">
                        @foreach($transactions as $transaction)
                            <div class="tranx-item">
                            <div class="tranx-col">
                                <div class="tranx-info">
                                    <div class="tranx-badge">
                                        <span class="tranx-icon">
                                            <img src="{{ asset('images/toyyib-logo.jpg') }}" alt="">
                                        </span>
                                    </div>
                                    <div class="tranx-data">
                                        <div class="tranx-label">{{ displayPriceFormat($transaction->amount) }}</div>
                                        <div class="number">Txn ID :  <a href="{{ $transaction->receipt }}"><span class="currency currency-btc">{{ $transaction->txn_id }}</span></a> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tranx-col">
                                <div class="tranx-amount">
                                    <div class="tranx-date">{{ reformatDatetime($transaction->created_at , "M d, Y H:i A")  }}</div>
                                    <div class="number-sm">Status : {{ $transaction->status }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div><!-- .card -->
                    <div class="text-center pt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
