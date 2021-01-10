@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">
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
                                <a href="{{ route('frontend.user.subscribe.view', $subscribe->tracking_no) }}"><span class="title font-weight-bold">{{ $subscribe->tracking_no }}</span></a>
                            </div>
                            <div class="tb-tnx-date">
                                <span>{{ $subscribe->remark }}</span>
                                <span class="date"></span>
                            </div>
                        </td>
                        <td class="tb-tnx-amount">
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

                        <td class="tb-tnx-amount">
                            <div class="tb-tnx-total">
                                <span></span>
                            </div>
                            <div class="tb-tnx-status">
                                <a href="{{ route('frontend.user.subscribe.edit', $subscribe->tracking_no) }}" class="">Edit</a> |
                                <a onclick="return confirm('Are you sure want to remove this tracking from your list?')" href="{{ route('frontend.user.subscribe.delete', $subscribe->tracking_no) }}" class="text-danger">Delete</a>
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
