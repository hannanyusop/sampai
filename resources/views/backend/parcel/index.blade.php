@extends('backend.layouts.app')

@section('title', __('User Management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')

    <div class="nk-block nk-block-lg">
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                @if ($logged_in_user->can('staff.inhouse'))
                    <div class="row text-right">
                        <div class="m-2 float-right">
                            <a href="{{ route('admin.parcel.scan') }}" class="btn btn-primary"><span>Scan User QRCode</span><em class="icon ni ni-qr"></em></a>
                        </div>
                    </div>
                @endif
                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                    <tr class="nk-tb-item nk-tb-head">
                        <th class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid">
                                <label class="custom-control-label" for="uid"></label>
                            </div>
                        </th>
                        <th class="nk-tb-col"><span class="sub-text">Tracking No</span></th>
                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Receiver Name</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Receiver Info</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Pickup By</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Pickup Datetime</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                        <th class="nk-tb-col nk-tb-col-tools text-right">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($parcels as $parcel)
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col nk-tb-col-check">
                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                    <input type="checkbox" class="custom-control-input" id="{{ $parcel->id }}">
                                    <label class="custom-control-label" for="{{ $parcel->id }}"></label>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-info">
                                        <span class="tb-lead">{{ $parcel->tracking_no }} <span class="dot dot-success d-md-none ml-1"></span></span>
{{--                                        <span>{{ $user->email }}</span>--}}
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col tb-col-mb">
                                <span class="tb-amount">{{ $parcel->receiver_name }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span>{{ $parcel->receiver_info }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ (!is_null($parcel->pickup_name))? $parcel->pickup_name : "" }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ (!is_null($parcel->pickup_name))? $parcel->pickup_datetime : "" }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span class="tb-status text-success">{{ getTripStatus($parcel->status) }}</span>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="{{ route('admin.parcel.view', ['tracking_no' => $parcel->tracking_no]) }}"><em class="icon ni ni-link-alt"></em><span>@lang('View')</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- .card-preview -->
    </div> <!-- nk-block -->

@endsection
