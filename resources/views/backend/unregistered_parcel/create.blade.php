@extends('backend.layouts.app')

@section('title', __('Add Unregistered Parcel'))

@section('content')
    <div class="nk-block">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item text-lg"><a href="{{ route('admin.unregisteredParcel.index') }}">Unregistered Parcel List</a></li>
                <li class="breadcrumb-item text-lg"><a href="{{ route('admin.unregisteredParcel.create') }}">Add Unregistered Parcel</a></li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">Add Parcel</h5>
                        </div>
                        <x-forms.post :action="route('admin.unregisteredParcel.store')" class="form-validate" enctype="multipart/form-data">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="tracking_no">Tracking No</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control text-uppercase" id="tracking_no" name="tracking_no">
                                            @error('tracking_no')
                                            <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="receiver_name">Receiver Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" list="prevUser" class="form-control text-uppercase" id="receiver_name" name="receiver_name">
                                            {{--                                            <datalist id="prevUser">--}}
                                            {{--                                                @foreach($sName as $suggestion)--}}
                                            {{--                                                    <option value="{{ $suggestion['receiver_name'] }}">--}}
                                            {{--                                                @endforeach--}}
                                            {{--                                            </datalist>--}}
                                            @error('receiver_name')
                                            <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="receiver_name">Phone Number</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control text-uppercase" name="phone_number">
                                            @error('phone_number')
                                            <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="receiver_name">Address Information(Keterangan Alamat)</label>
                                        <div class="form-control-wrap">
                                            <textarea class="form-control" rows="3" name="address"></textarea>
                                            <small class="text-info font-weight-bold">an address for the recipient's name, street address, or province, postal code.<br> It may also include optional fields for additional information, such as apartment or unit number, phone number, or email address.</small><br>
                                            @error('address')
                                            <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="receiver_name">Origin</label>
                                        <div class="form-control-wrap">
                                            <input type="text" list="prevUser" class="form-control text-uppercase" id="order_origin" name="order_origin">
                                            <small class="text-info font-weight-bold">Ex: Shoppe, Lazada</small><br>
                                            {{--                                            <datalist id="prevUser">--}}
                                            {{--                                                @foreach($sName as $suggestion)--}}
                                            {{--                                                    <option value="{{ $suggestion['receiver_name'] }}">--}}
                                            {{--                                                @endforeach--}}
                                            {{--                                            </datalist>--}}
                                            @error('order_origin')
                                            <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="receiver_name">Remark</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control text-uppercase mb-6" name="remark">
                                            @error('remark')
                                            <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1">
                                <div class="col-12">
                                    <div class="form-group flex flex-column">
                                        <div class="center">
                                            <a href="{{ route('admin.unregisteredParcel.index') }}" class="btn btn-outline-light bg-warning d-none d-sm-inline-flex"><em class="icon ni ni-back-alt"></em><span>Back</span></a>
                                            <button type="submit" class="btn btn-md btn-success ml-4">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </x-forms.post>
                    </div>
                </div>
            </div><!-- .col -->
        </div>
    </div>
@endsection
