@extends('backend.layouts.app')

@section('title', __('Add Trip'))

@section('content')

    <div class="nk-block-head nk-block-head-lg wide-sm">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><a class="back-to" href="{{ route('admin.office.index') }}"><em class="icon ni ni-arrow-left"></em><span>Office List</span></a></div>
            <h2 class="nk-block-title fw-normal">Edit Office</h2>
            <div class="nk-block-des">
                <p class="lead"></p>
            </div>
        </div>
    </div>
    <div class="nk-content-wrap">
        <div class="card card-bordered">
            <div class="card-inner">
                <x-forms.post :action="route('admin.office.update', $office->id)" class="form-validate gy-3">
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="code">Code</label>
                                <span class="form-note">Required | Min:3 | Max:5</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="custom-control-wrap">
                                    <input type="text" name="code" id="code" class="form-control text-uppercase" value="{{ old('code')? old('code') : $office->code }}" required>
                                    @error('code')
                                    <span id="fv-type-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="name">Name</label>
                                <span class="form-note">Required | Max:50</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="custom-control-wrap">
                                    <input type="text" name="name" id="name" class="form-control text-uppercase" value="{{ old('name')? old('name') : $office->name }}" required>
                                    @error('name')
                                    <span id="fv-type-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="is_drop_point">Drop Point</label>
                                <span class="form-note"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="custom-control-wrap">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_drop_point" class="custom-control-input" value="1"  {{ (old('is_drop_point')? "checked" : ($office->is_drop_point == 1))? "checked" : "" }} id="is_drop_point">
                                        <label class="custom-control-label" for="is_drop_point">Yes</label>
                                    </div>
                                    @error('is_drop_point')
                                    <span id="fv-type-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="address">Address</label>
                                <span class="form-note"></span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <textarea id="address" name="address" placeholder="Insert your address here . . ." class="form-control" rows="5">{{ old('address')? old('address') : $office->address }}</textarea>
                                    @error('address')
                                        <span id="fv-destination_id-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-7 offset-lg-5">
                            <div class="form-group mt-2">
                                <button  class="btn btn-lg btn-primary submit">Update</button>
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
