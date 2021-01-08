@extends('frontend.layouts.app')

@section('title', __('Subscribe'))

@section('content')
    <div class="nk-content-wrap">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="card-head">
                    <h5 class="card-title">Update Subscribed Parcel</h5>
                </div>
                <x-forms.post :action="route('frontend.user.subscribe.update', $sub->tracking_no)" class="form-validate gy-3">
                <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="tracking_no">Tracking No</label>
                                <span class="form-note">Specify the Tracking Number | Max :50</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control text-uppercase" id="tracking_no" name="tracking_no" value="{{ old('tracking_no')? old('tracking_no') : $sub->tracking_no }}" placeholder="ER123456MY">
                                    @error('tracking_no')
                                        <span id="fv-tracking_no-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="remark">Remark</label>
                                <span class="form-note">For your own reference| Max:50</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="remark" name="remark" value="{{ old('remark')? old('remark') : $sub->remark }}" placeholder="Baju Shoppe">
                                    @error('remark')
                                        <span id="fv-remark-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="site-off">Notify</label>
                                <span class="form-note">Notify you via email</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="is_notify" id="is_notify" {{ old('is_notify')? "checked" : ($sub->is_notify == 1)? "checked" : "" }}>
                                    <label class="custom-control-label" for="is_notify">Notify</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-7 offset-lg-5">
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-lg btn-primary">Subscribe</button>
                            </div>
                        </div>
                    </div>
                </x-forms.post>
            </div>
        </div>
    </div>
@endsection
