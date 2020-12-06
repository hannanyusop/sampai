@extends('backend.layouts.app')

@section('title', __('Add Trip'))

@section('content')
    <div class="nk-content-wrap">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="card-head">
                    <h5 class="card-title">Add Trip</h5>
                </div>
                <x-forms.post :action="route('admin.trip.insert')" class="form-validate gy-3">
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="destination_id">Drop Point</label>
                                <span class="form-note">Required</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <select class="form-select form-control form-control-lg" name="destination_id" id="destination_id" data-search="on" required>
                                        <option value="default_option">- Select Drop Point -</option>
                                        @foreach($drops as $drop)
                                            <option value="{{ $drop->id }}" {{ (in_array($drop->id, $opened_trip))? "disabled" : "" }}>{{ $drop->code." - ".$drop->name }} {{ (in_array($drop->id, $opened_trip))? "(Open)" : "" }}</option>
                                        @endforeach
                                    </select>
                                    @error('destination_id')
                                        <span id="fv-destination_id-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="remark">Remark</label>
                                <span class="form-note"></span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <textarea id="remark" name="remark" placeholder="Insert your remark here . . ." class="form-control" rows="5">{{ old('remark') }}</textarea>
                                    @error('destination_id')
                                        <span id="fv-destination_id-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="date">Date</label>
                                <span class="form-note">Required</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="custom-control-wrap">
                                    <input type="text" name="date" id="date" class="form-control date-picker-alt" value="{{ old('date')? old('date'): date('Y-m-d') }}" data-date-format="yyyy-mm-dd" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-7 offset-lg-5">
                            <div class="form-group mt-2">
                                <button  class="btn btn-lg btn-primary submit">Add</button>
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
