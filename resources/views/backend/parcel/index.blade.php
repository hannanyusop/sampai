@extends('backend.layouts.app')

@section('title', __('User Management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')

    <div class="nk-block nk-block-lg">
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                    <tr class="nk-tb-item nk-tb-head">
                        <th class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid">
                                <label class="custom-control-label" for="uid"></label>
                            </div>
                        </th>
                        <th class="nk-tb-col"><span class="sub-text">Tracking No / roF</span></th>
                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Owner</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Item Description</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Delivery Information</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Collection Point</span></th>
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
                                        <span>{{  reformatDatetime($parcel->created_at)  }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col tb-col-mb">
                                <span class="tb-lead">{{ $parcel?->user->name }} <span class="dot dot-success d-md-none ml-1"></span></span>
                                <small>{{ $parcel?->user->phone_number }}</small>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <small>{{ displayPriceFormat($parcel->price) }}</small><br>
                                <small>{{ $parcel->description }}</small>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                @if((!is_null($parcel->pickup_name)))
                                    <span class="tb-sub">{{ $parcel->pickup_name }}</span>
                                    <span>{{ $parcel->pickup_datetime }}</span>
                                @endif
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                {!! $parcel->status_label !!}
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                {!! $parcel->dropPoint->code !!}
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
