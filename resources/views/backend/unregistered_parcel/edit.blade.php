@extends('backend.layouts.app')

@section('title', __('Unregistered Parcel View'))

@section('content')
    <div class="nk-block nk-block-lg">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-lg"><a href="{{ route('admin.unregisteredParcel.index') }}">Unregistered Parcel List</a></li>
                <li class="breadcrumb-item text-lg"><a href="{{ route('admin.unregisteredParcel.view',  ['id' => encrypt($unregisteredParcel['id'])]) }}">Parcel Information</a></li>
                <li class="breadcrumb-item text-lg"><a href="#">Edit Parcel</a></li>
            </ol>
        </nav>
        <div class="nk-content-wrap">
            <div class="nk-block">

                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                        </div>
                    </div>
                </div>

                <div class="card card-bordered">
                    <x-forms.post :action="route('admin.unregisteredParcel.update', $unregisteredParcel->id)" class="form-validate" enctype="multipart/form-data">
                        <div class="card-aside-wrap">
                        <div class="card-content">
                        <div class="card-inner">
                            <div class="nk-block">
                                <div class="nk-block-head">
                                    <div class="flex flex-column">
                                        <h5 class="title">Edit Parcel Information</h5>
                                        <div class="text-right mt-n5 mr-n2">
                                            <a href="{{ route('admin.unregisteredParcel.view',  ['id' => encrypt($unregisteredParcel['id'])]) }}" class="btn btn-md btn-warning">Back</a>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="profile-ud-list">
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider flex-column">
                                            <span class="profile-ud-label">Tracking Number</span>
                                            <input type="text" name="tracking_no" id="tracking_no" class="form-control" value="{{ old('tracking_no')? old('tracking_no') : $unregisteredParcel->tracking_no }}" required>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider flex-column">
                                            <span class="profile-ud-label">Order Origin</span>
                                            <input type="text" name="order_origin" id="order_origin" class="form-control" value="{{ old('order_origin')? old('order_origin') : $unregisteredParcel->order_origin }}" required>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider flex-column">
                                            <span class="profile-ud-label">Remark</span>
                                            <input type="text" name="remark" id="remark" class="form-control" value="{{ old('remark')? old('remark') : $unregisteredParcel->remark }}" required>
                                        </div>
                                    </div>
                                </div><!-- .profile-ud-list -->
                            </div><!-- .nk-block -->
                            <div class="nk-block">
                                <div class="nk-block-head nk-block-head-line">
                                    <h6 class="title mt-2 mb-n2">Contact Information</h6>
                                </div><!-- .nk-block-head -->
                                <div class="profile-ud-list">
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider flex-column">
                                            <span class="profile-ud-label">Receiver Name</span>
                                            <input type="text" name="receiver_name" id="receiver_name" class="form-control" value="{{ old('receiver_name')? old('receiver_name') : $unregisteredParcel->receiver_name }}" required>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider flex-column">
                                            <span class="profile-ud-label">Phone Number</span>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number')? old('phone_number') : $unregisteredParcel->phone_number }}" required>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider flex-column">
                                            <span class="profile-ud-label">Address</span>
                                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address')? old('address') : $unregisteredParcel->address }}" required>
                                        </div>
                                    </div>
                                </div><!-- .profile-ud-list -->
                            </div><!-- .nk-block -->
                        </div><!-- .card-inner -->
                    </div><!-- .card-content -->
                    </div><!-- .card-aside-wrap -->
                        <div class="form-group flex flex-column">
                            <div class="center mb-4">
                                <button type="submit" class="btn btn-md btn-primary">Update</button>
                            </div>
                        </div>
                    </x-forms.post>
            </div>
        </div>
    </div> <!-- nk-block -->
@endsection
