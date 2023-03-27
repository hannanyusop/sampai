@extends('frontend.layouts.app')

@section('title', __('Pickup List'))

@section('content')

    <div class="nk-block nk-block-lg">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item text-lg"><a href="#">Parcel Management</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('frontend.user.pickup.index') }}">Pickup List</a></li>
            </ol>
        </nav>
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
                        <th class="nk-tb-col"><span class="sub-text">Id</span></th>
                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Trip</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Office</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Code</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Pickup By</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Pickup Datetime</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                        <th class="nk-tb-col nk-tb-col-tools text-right">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pickups as $pickup)
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col nk-tb-col-check">
                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                    <input type="checkbox" class="custom-control-input" id="{{ $pickup->id }}">
                                    <label class="custom-control-label" for="{{ $pickup->id }}"></label>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-info">
                                        <span class="tb-lead">{{ $pickup->user->name }} <span class="dot dot-success d-md-none ml-1"></span></span>
                                        <span>{{ $pickup->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col tb-col-mb">
                                <span class="tb-amount">{{ $pickup->trip->code }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-mb">
                                <span class="tb-amount">{{ $pickup->dropPoint->name }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span>{{ $pickup->code }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ (!is_null($pickup->pickup_name))? $pickup->pickup_name : "" }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ (!is_null($pickup->pickup_name))? $pickup->pickup_datetime : "" }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span class="tb-status text-success">{{ getTripStatus($pickup->status) }}</span>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="{{ route('frontend.user.pickup.show',encrypt($pickup->id)) }}"><em class="icon ni ni-link-alt"></em><span>@lang('View')</span></a></li>
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
