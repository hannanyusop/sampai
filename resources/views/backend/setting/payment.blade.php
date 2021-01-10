@extends('backend.layouts.app')

@section('title', __('Payment Setting'))

@section('content')
    <div class="nk-content-wrap">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="card-head">
                    <h5 class="card-title">Payment Setting</h5>
                </div>
                <x-forms.post :action="route('admin.setting.paymentSave')" class="form-validate gy-3">

                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="">Enable Payment</label>
                                <span class="form-note"></span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="payment_enabled" id="payment_enabled" {{ (old('payment_enabled')? "checked" : (getOption('payment_enabled', true) == true))? "checked" : "" }}>
                                    <label class="custom-control-label" for="payment_enabled">Enable</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="payment_cost">Cost Per Subscription</label>
                                <span class="form-note">Min: 0.01</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control text-uppercase" id="payment_cost" name="payment_cost" value="{{ old('payment_cost')? old('payment_cost') : getOption('payment_cost', 0.10) }}">
                                    @error('payment_cost')
                                        <span id="fv-tracking_no-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="payment_limit_top_up">Minimum Top-up</label>
                                <span class="form-note">Min: 2</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control text-uppercase" id="payment_limit_top_up" name="payment_limit_top_up" value="{{ old('payment_limit_top_up')? old('payment_limit_top_up') : getOption('payment_limit_top_up', 2) }}">
                                    @error('payment_limit_top_up')
                                    <span id="fv-payment_limit_top_up-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="payment_limit_query">Query Limit Per Day</label>
                                <span class="form-note">Min: 0</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control text-uppercase" id="payment_limit_query" name="payment_limit_query" value="{{ old('payment_limit_query')? old('payment_limit_query') : getOption('payment_limit_query', 2) }}">
                                    @error('payment_limit_query')
                                    <span id="fv-tracking_no-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="payment_limit_query">Toyyib Collection ID</label>
                                <span class="form-note">Required</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control text-uppercase" id="payment_collection_id" name="payment_collection_id" value="{{ old('payment_collection_id')? old('payment_collection_id') : getOption('payment_collection_id', '') }}">
                                    <small class="help-block">
                                        *Please provide valid collection id to prevent error on payment gateway site.
                                    </small>
                                    @error('payment_limit_query')
                                    <span id="fv-tracking_no-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row g-3">
                        <div class="col-lg-7 offset-lg-5">
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-lg btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </x-forms.post>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')

@endpush
