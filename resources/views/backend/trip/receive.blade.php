@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <div class="preview-block">
                            <span class="preview-title-lg overline-title">Recieve Trip</span>
                            <x-forms.post :action="route('admin.trip.receiveSave')" class="form-validate gy-3">
                            <div class="row gy-4">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="code" name="code" placeholder="OTP">
                                        </div>
                                    </div>

                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-lg btn-primary">Receive Trip</button>
                                        <a href="{{ route('admin.trip.scan') }}" class="btn btn-lg btn-primary">Scan</a>
                                    </div>
                                </div>
                            </div>
                            </x-forms.post>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
@endpush
