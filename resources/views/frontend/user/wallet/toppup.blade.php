@extends('frontend.layouts.app')

@section('title', __('Top-up Wallet'))

@section('content')
    <div class="buysell wide-xs m-auto">
        <div class="buysell-title text-center">
            <h2 class="title">Top-up Wallet</h2>
        </div><!-- .buysell-title -->
        <div class="buysell-block">
            <x-forms.post :action="route('frontend.user.wallet.insert')" class="buysell-form">
                <div class="buysell-field form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="buysell-amount">Amount to Top-up</label>
                    </div>
                    <div class="form-control-group">
                        <input type="text" class="form-control form-control-lg form-control-number" id="amount" name="amount" value="{{ old('amount') ?? $min }}" placeholder="{{ "Insert Amount" }}">
                        <div class="form-dropdown">
                            <div class="text">RM</div>
                            <div class="dropdown">
                                <a href="#" class="dropdown-indicator-caret" data-toggle="dropdown" data-offset="0,2"></a>
                                <div class="dropdown-menu dropdown-menu-xxs dropdown-menu-right text-center">
                                    <ul class="link-list-plain">
                                        <li><a href="#">RM</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-note-group">
                        <span class="buysell-min form-note-alt">Minimum: {{ displayPriceFormat($min)   }}</span>
                    </div>
                    @error('amount')
                        <span id="fv-amount-error" class="invalid">{{ $message }}</span>
                    @enderror
                </div><!-- .buysell-field -->
                <div class="buysell-field form-group">
                    <div class="form-label-group">
                        <label class="form-label">Payment Method</label>
                    </div>
                    <div class="form-pm-group">
                        <ul class="buysell-pm-list">
                            <li class="buysell-pm-item">
                                <input class="buysell-pm-control" type="radio" name="bs-method" id="pm-paypal"  checked disabled>
                                <label class="buysell-pm-label" for="pm-paypal">
                                    <span class="pm-name">ToyyibPay</span>
                                    <img src="{{ asset('images/toyyib-logo.jpg') }}" class="" style="width: 100px" alt="toyyib-icon">
                                </label>
                            </li>
                        </ul>
                    </div>
                </div><!-- .buysell-field -->
                <div class="buysell-field form-action">
                    <button type="submit" class="btn btn-lg btn-block btn-primary">Continue to Payment Site</button>
                </div><!-- .buysell-field -->
                <div class="form-note text-base text-center">Note: {{ displayPriceFormat(1) }} will be charge for every transaction, <a href="#">see our fees</a>.</div>
            </x-forms.post><!-- .buysell-form -->
        </div><!-- .buysell-block -->
    </div><!-- .buysell -->

@endsection
