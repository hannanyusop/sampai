@extends('backend.layouts.app')

@section('title', __('Unregistered Parcel List'))

@section('content')
    <div class="nk-block nk-block-lg">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item text-lg"><a href="{{ route('admin.unregisteredParcel.index') }}">Unregistered Parcel List</a></li>
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
                    <div class="form-group">
                        <a href="{{ route('admin.unregisteredParcel.create') }}" class="btn btn-lg btn-primary">Add Parcel</a>
                    </div>
                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                    <tr class="nk-tb-item nk-tb-head">
                        <th class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid">
                                <label class="custom-control-label" for="uid"></label>
                            </div>
                        </th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Tracking Number</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Receiver Name</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Phone Number</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Address</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Order Origin</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Created At</span></th>
                        <th class="nk-tb-col nk-tb-col-tools text-right">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($unregisteredParcels as $unregisteredParcel)
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col nk-tb-col-check">
                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                    <label class="custom-control-label" for="{{ $unregisteredParcel->id }}"></label>
                                </div>
                            </td>

                            <td class="nk-tb-col tb-col-mb">
                                <span class="tb-amount">{{ $unregisteredParcel->tracking_no }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-mb">
                                <span class="tb-amount">{{ $unregisteredParcel->receiver_name }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span>{{ $unregisteredParcel->phone_number }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ $unregisteredParcel->address }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ $unregisteredParcel->order_origin }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span class="tb-status text-success">{{ reformatDatetime($unregisteredParcel->created_at, 'd-m H:i A') }}</span>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href={{ route('admin.unregisteredParcel.view', ['id' => encrypt($unregisteredParcel['id'])] ) }}><em class="icon ni ni-link-alt"></em><span>@lang('View')</span></a></li>
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
