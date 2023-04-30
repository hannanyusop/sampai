@extends('backend.layouts.app')

@section('title', __('System Setting'))

@section('content')
    <div class="nk-content-wrap">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="card-head">
                    <h5 class="card-title">System Setting</h5>
                </div>
                <x-forms.post :action="route('admin.setting.systemSave')" class="form-validate gy-3">

                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="">Allow Registration</label>
                                <span class="form-note"></span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="allow_registration" id="allow_registration" {{ (old('allow_registration')? "checked" : (getOption('allow_registration', true) == true))? "checked" : "" }}>
                                    <label class="custom-control-label" for="allow_registration">Enable</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="">Allow Tracking (On Landing Page)</label>
                                <span class="form-note"></span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="allow_tracking" id="allow_tracking" {{ (old('allow_tracking')? "checked" : (getOption('allow_tracking', true) == true))? "checked" : "" }}>
                                    <label class="custom-control-label" for="allow_tracking">Enable</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="tax_rate">Tax Rate (RM)</label>
                                <span class="form-note">Min: 0.01</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control text-uppercase" id="tax_rate" name="tax_rate" value="{{ old('tax_rate')? old('tax_rate') : getOption('tax_rate', 0.3017) }}">
                                    @error('tax_rate')
                                    <span id="fv-tax_rate-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="pos_rate">Pos Rate</label>
                                <span class="form-note">Min: 0.01</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control text-uppercase" id="pos_rate" name="pos_rate" value="{{ old('pos_rate')? old('pos_rate') : getOption('pos_rate', 2.80) }}">
                                    @error('pos_rate')
                                    <span id="fv-tax_rate-error" class="invalid">{{ $message }}</span>
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
