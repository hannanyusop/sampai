@extends('backend.layouts.app')

@section('title', __('Unregistered Parcel View'))

@section('content')
    <div class="nk-block nk-block-lg">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-lg"><a href="{{ route('admin.unregisteredParcel.index') }}">Unregistered Parcel List</a></li>
                <li class="breadcrumb-item text-lg"><a href="#">Parcel Information</a></li>
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
                    <div class="card-aside-wrap">
                        <div class="card-content">
                            <div class="card-inner">
                                <div class="nk-block">
                                    <div class="nk-block-head">
                                        <div class="flex flex-column">
                                            <h5 class="title">Parcel Information</h5>
                                            <div class="text-right mt-n5 mr-n2">
                                                <a href="{{ route('admin.unregisteredParcel.index') }}" class="btn btn-md btn-warning">Back</a>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="profile-ud-list">
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Tracking Number</span>
                                                <span class="text-left ml-4">{{ $unregisteredParcel->tracking_no }}</span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Order Origin</span>
                                                <span class="text-left ml-4">{{ $unregisteredParcel->order_origin }} </span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Remark</span>
                                                <span class="text-left ml-4">{{ $unregisteredParcel->remark }}</span>
                                            </div>
                                        </div>
                                    </div><!-- .profile-ud-list -->
                                </div><!-- .nk-block -->
                                <div class="nk-block">
                                    <div class="nk-block-head nk-block-head-line">
                                        <h5 class="title mt-2 mb-n4">Contact Information</h5>
                                    </div><!-- .nk-block-head -->
                                    <div class="profile-ud-list">
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Receiver Name</span>
                                                <span class="text-left ml-4">{{ $unregisteredParcel->receiver_name }}</span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Phone Number</span>
                                                <span class="text-left ml-4">{{ $unregisteredParcel->phone_number }}</span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">Address</span>
                                                <span class="text-left ml-4">{{ $unregisteredParcel->address }}</span>
                                            </div>
                                        </div>
                                    </div><!-- .profile-ud-list -->
                                </div><!-- .nk-block -->
                            </div><!-- .card-inner -->
                        </div><!-- .card-content -->
                    </div><!-- .card-aside-wrap -->
                        <div class="form-group flex flex-column">
                            <div class="center mb-4">
                                <a href="{{ route('admin.unregisteredParcel.edit', ['id' => encrypt($unregisteredParcel['id'])]) }}" class="btn btn-md btn-primary">Edit Parcel</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div> <!-- nk-block -->
@endsection
