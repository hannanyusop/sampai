@extends('backend.layouts.app')

@section('title', __('Add Trip'))

@section('content')
    <div class="nk-block-head nk-block-head-lg wide-sm">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><a class="back-to" href="{{ route('admin.auth.user.index') }}"><em class="icon ni ni-arrow-left"></em><span>Users List</span></a></div>
            <h2 class="nk-block-title fw-normal">Assign Office</h2>
            <div class="nk-block-des">
                <p class="lead"></p>
            </div>
        </div>
    </div>

    <div class="nk-content-wrap">
        <div class="card card-bordered">
            <div class="card-inner">
                <x-forms.post :action="route('admin.auth.user.assignSave', $user->id)" class="form-validate gy-3">
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="name">Staff Name</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" name="name" id="name" class="form-control text-uppercase" value="{{ $user->name }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="office">Office</label>
                                <span class="form-note">Required</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <select class="form-select form-control form-control-lg" name="office" id="office" data-search="on" required>
                                        <option value="default_option">- Select Drop Point -</option>
                                        @foreach($offices as $office)
                                            <option value="{{ $office->id }}" {{ ($user->office_id == $office->id)? "selected" : "" }}>{{ $office->code." - ".$office->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('office')
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
