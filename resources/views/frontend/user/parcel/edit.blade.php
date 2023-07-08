@extends('frontend.layouts.app')

@section('title', __('Edit Parcel'))


@section('content')
    <div class="nk-content-wrap">

        <div class="row">
            <div class="col-xl-12">
                <x-forms.post :action="route('frontend.user.parcel.update', $parcel->id)" class="form-validate" enctype="multipart/form-data">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="sp-plan-head">
                                <h6 class="title">Parcel Details</h6>
                                <div class="text-right mt-n5 mr-n2">
                                    <a href="{{ route('frontend.user.parcel.show',encrypt($parcel->id)) }}" class="btn btn-md btn-warning">Back</a>
                                </div>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-4">
                                    <li class="col-sm-6">
                                        <p><span class="text-soft">Tracking No.</span>
                                            <input type="text" name="tracking_no" id="tracking_no" class="form-control" value="{{ old('tracking_no')? old('tracking_no') : $parcel->tracking_no }}" required>
                                        </p>
                                    </li>
                                    <li class="col-sm-6">
                                        <p><span class="text-soft">Date Created</span>
                                            <span class="font-weight-bold mt-1">{{ $parcel->created_at }}</span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb my-1">
                                <ul class="row gx-4">
                                    <li class="col-sm-6">
                                        <p><span class="text-soft">Recipient Name (On Parcel)</span>
                                            <input type="text" name="receiver_name" id="receiver_name" class="form-control text-uppercase" value="{{ old('receiver_name')? old('receiver_name') : $parcel->receiver_name }}" required>
                                        </p>
                                    </li>
                                    <li class="col-sm-6">
                                        <p><span class="text-soft">Recipient Phone Number</span>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number')? old('phone_number') : $parcel->phone_number }}" required>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb my-1">
                                <ul class="row gx-4">
                                    <li class="col-sm-12">
                                        <p><span class="text-soft">Item Description (Keterangan barang)</span>
                                            <textarea type="text" name="description" id="description" class="form-control">{{ old('description')? old('description') : $parcel->description }}</textarea>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb my-1">
                                <ul class="row gx-4">
                                    <li class="col-sm-6">
                                        <p><span class="text-soft mb-n3">Destination</span>
                                        @foreach($drop_points as $drop_point)
                                            <div class="form-check mt-n1">
                                                <input type="radio" name="office_id" id="office_id" value="{{ $drop_point->id }}" class="form-check-input" {{ $parcel->office_id == $drop_point->id ? "checked" : ""  }}>
                                                <lable class="form-check-label">{{ $drop_point->code." - ".$drop_point->name }}</lable>
                                            </div>
                                            @endforeach
                                            </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-4">
                                    <li class="col-sm-6">
                                        <p><span class="text-soft">Quantity</span>
                                            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity')? old('quantity') : $parcel->quantity }}" required>
                                        </p>
                                    </li>

                                    <li class="col-sm-6">
                                        <p><span class="text-soft">Price</span>
                                            <input type="number" name="price" id="price" class="form-control" value="{{ old('price')? old('price') : $parcel->price }}" required>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="sp-plan-desc sp-plan-desc-mb">
                                <ul class="row gx-1">

                                    <li class="col-sm-4">
                                        <p><span class="text-soft">Invoice</span>
                                            <input type="file" id="invoice_url" name="invoice_url" class="mb-1" value="{{ old('invoice_url') }}">
                                            <a href="{{ route('frontend.user.parcel.download',encrypt($parcel->id)) }}" download><i class="fa fa-download me-2"></i> Download</a>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group flex flex-column">
                                <div class="center">
                                    <button type="submit" class="btn btn-md btn-primary">Update</button>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
                </x-forms.post>
            </div><!-- .col -->
        </div>
    </div>
@endsection
