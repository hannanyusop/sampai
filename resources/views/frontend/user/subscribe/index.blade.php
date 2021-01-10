@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">

        <div class="nk-block nk-block-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Subscription List</h4>
                    <div class="nk-block-des">
                        <p></p>
                    </div>
                </div>
            </div>
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
                            <th class="nk-tb-col"><span class="sub-text">TRACKING NUMBER</span></th>
                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">TAG</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">COST</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">DESTINATION</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">STATUS</span></th>
                            <th class="nk-tb-col nk-tb-col-tools text-right">
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subscribes as $key => $subscribe)
                            <tr class="nk-tb-item">
                            <td class="nk-tb-col nk-tb-col-check">
                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                    <input type="checkbox" class="custom-control-input" id="uid1">
                                    <label class="custom-control-label" for="uid1"></label>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-info">
                                        <span class="tb-lead">{{ $subscribe->tracking_no }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col tb-col-mb">
                                <span>{{ $subscribe->remark }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span class="tb-amount">{{ displayPriceFormat($subscribe->cost) }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                @if($subscribe->parcel)
                                    <div class="tb-tnx-total">
                                        <span>{{ $subscribe->parcel->trip->destination->name }}</span>
                                    </div>
                                    <div class="tb-tnx-status">
                                        {!! getParcelStatusBadge($subscribe->parcel->status) !!}
                                    </div>
                                @else
                                    <div class="tb-tnx-total">
                                        <span></span>
                                    </div>
                                    <div class="tb-tnx-status">
                                        <span class="badge badge-dot badge-danger">Pending</span>
                                    </div>
                                @endif
                            </td>
                            <td class="nk-tb-col tb-col-md">

                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="{{ route('frontend.user.subscribe.view', $subscribe->tracking_no) }}"><em class="icon ni ni-focus"></em><span>View</span></a></li>
                                                    <li><a href="{{ route('frontend.user.subscribe.edit', $subscribe->tracking_no) }}"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                    <li class="divider"></li>
                                                    <li><a onclick="return confirm('Are you sure want to remove this tracking from your list?')" href="{{ route('frontend.user.subscribe.delete', $subscribe->tracking_no) }}"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
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

        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner card-inner-md">
                    <div class="card-title-group">
                        <h6 class="card-title">Subscription List</h6>
                        <div class="card-action">
                            <a href="#" class="link link-sm">See All <em class="icon ni ni-chevron-right"></em></a>
                        </div>
                    </div>
                </div>
                <table class="table table-tranx">
                    <thead>
                    <tr class="tb-tnx-head">
                        <th class="tb-tnx-id"><span class="">#</span></th>
                        <th class="tb-tnx-info">
                            <span class="tb-tnx-desc d-none d-sm-inline-block">
                                <span>Tracking Number</span>
                            </span>
                            <span class="tb-tnx-date d-md-inline-block d-none">
                                <span class="d-md-none">Date</span>
                                <span class="d-none d-md-block">
                                    <span>Tag</span>
                                    <span>Received Date</span>
                                </span>
                            </span>
                        </th>
                        <th class="tb-tnx-amount">
                            <span class="tb-tnx-total">Destination</span>
                            <span class="tb-tnx-status d-none d-md-inline-block">Status</span>
                        </th>
                        <th class="tb-tnx-amount">
                            <span class="tb-tnx-total"></span>
                            <span class="tb-tnx-status d-none d-md-inline-block">Action</span>
                        </th>
                    </tr></thead>
                    <tbody>
                    @foreach($subscribes as $key => $subscribe)
                    <tr class="tb-tnx-item">
                        <td class="tb-tnx-id"><span>{{ $key+1 }}</span></td>
                        <td class="tb-tnx-info">
                            <div class="tb-tnx-desc">
                                <a href=""><span class="title font-weight-bold">{{ $subscribe->tracking_no }}</span></a>
                            </div>
                            <div class="tb-tnx-date">

                                <span class="date"></span>
                            </div>
                        </td>
                        <td class="tb-tnx-amount">


                        </td>

                        <td class="tb-tnx-amount">
                            <div class="tb-tnx-total">
                                <span></span>
                            </div>
                            <div class="tb-tnx-status">
                                <a href="" class="">Edit</a> |
                                <a  class="text-danger">Delete</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- .card -->
        </div>
    </div>
@endsection
