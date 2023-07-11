@extends('frontend.layouts.app')

@section('title', __('Search Parcel'))

@section('content')

    <div class="nk-block">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">Add Parcel</h5>
                        </div>
                        <x-forms.post :action="route('frontend.user.parcel.store')" class="form-validate" enctype="multipart/form-data">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="tracking_no">Tracking No</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control text-uppercase" id="tracking_no" name="tracking_no" value="{{ old('tracking_no') }}" required>
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
                                            <input type="text" list="prevUser" class="form-control text-uppercase" id="receiver_name" name="receiver_name" value="{{ old('receiver_name') ?? auth()->user()->name }}">
{{--                                            <datalist id="prevUser">--}}
{{--                                                @foreach($sName as $suggestion)--}}
{{--                                                    <option value="{{ $suggestion['receiver_name'] }}">--}}
{{--                                                @endforeach--}}
{{--                                            </datalist>--}}
                                            @error('name')
                                            <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="receiver_name">Phone Number</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control text-uppercase" name="phone_number" value="{{ old('phone_number') ?? auth()->user()->phone_number }}">
                                            <small class="text-info">*Go to profile to update your phone number</small><br>
                                            @error('phone_number')
                                                <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h5>{{ __('Item Information') }}</h5>
                            <div class="row g-4">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="receiver_name">Item Description (Keterangan barang)</label>
                                        <div class="form-control-wrap">
                                            <textarea class="form-control" rows="4" name="description">{{ old('description') }}</textarea>
                                            <small class="text-info font-weight-bold">*Simple description of every items, quantity & price, example: Shirt 2pcs RM10. (Keterangan ringkas setiap barang, contoh: Baju 2pcs RM10)</small><br>
                                            @error('description')
                                                <span id="fv-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="quantity">Quantity</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="quantity" value="{{ old('quantity') }}">
                                            @error('quantity')
                                                <span id="fv-quantity-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="price">Price (Harga) RM</label>
                                        <div class="form-control-wrap">
                                            <input class="form-control" name="price" min="1" value="{{ old('price') }}">
                                            @error('price')
                                            <span id="fv-price-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="invoice">Invoice</label>
                                        <div class="form-control-wrap">
                                            <input type="file" id="invoice" name="invoice_url" value="{{ old('invoice_url') }}">
                                            @error('invoice_url')
                                                <br><small id="fv-invoice-error" class="invalid text-danger font-weight-bold"><span class="ni ni-alert-circle"></span>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="order_origin">Product Remark (Order origin)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" list="order_origin" class="form-control" id="order_origin" name="order_origin" value="{{ old('order_origin') }}">
                                                <datalist id="order_origin">
                                                    @foreach($origins as $origin)
                                                        <option value="{{ $origin }}">
                                                    @endforeach
                                                </datalist>
                                            @error('order_origin')
                                            <span id="fv-order_origin-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="identification">Collection point</label>
                                        </div>

                                        <div class="mb-3">
                                            @foreach($drop_points as $drop_point)
                                                <div class="form-check">
                                                    <input type="radio" name="office_id" id="drop_point_{{ $drop_point->id }}" value="{{ $drop_point->id }}" class="form-check-input" {{ old('office_id') == $drop_point->id ?? "checked" }}>
                                                    <lable class="form-check-label">{{ $drop_point->code." - ".$drop_point->name }}</lable>
                                                </div>
                                            @endforeach
                                            @error('office_id')
                                                <small id="fv-office_id-error" class="invalid text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary">Submit</button>
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
