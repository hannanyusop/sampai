@extends('backend.layouts.app')

@section('title', __('View Trip'))

@section('content')
    <div class="nk-content-wrap">
        <div class="nk-block">

            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Trip View</h3>
                        <div class="nk-block-des text-soft">
                            <p>Trip : <span class="text-base">#{{ $trip->code }}</span></p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="{{ route('admin.trip.index') }}" class="btn btn-outline-light bg-warning d-none d-sm-inline-flex"><em class="icon ni ni-back-alt"></em><span>Back</span></a>
                        @if(auth()->user()->can('staff.distributor') && $trip->status == 0)
                            <a href="{{ route('admin.trip.addParcel', $trip->id) }}" class="btn btn-success d-none d-sm-inline-flex"><em class="icon ni ni-plus"></em><span>Add Parcel</span></a>
                            <a href="{{ route('admin.trip.close', $trip->id) }}" onclick="return confirm('Are you sure want to close this trip?')" class="btn btn-light d-none d-sm-inline-flex"><em class="icon ni ni-clock"></em><span>Close Trip</span></a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card card-bordered">
                <div class="card-aside-wrap">
                    <div class="card-content">
                        <div class="card-inner">
                            <div class="nk-block">
                                <div class="nk-block-head">
                                    <h5 class="title">Trip Information</h5>
                                </div><!-- .nk-block-head -->
                                <div class="profile-ud-list">
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Trip ID.</span>
                                            <span class="profile-ud-value">#{{ $trip->code }}</span>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Destination</span>
                                            <span class="profile-ud-value">{{ $trip->destination->name }} </span>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Date</span>
                                            <span class="profile-ud-value">{{ reformatDatetime($trip->date, 'd M, Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Destination Code</span>
                                            <span class="profile-ud-value">{{ $trip->destination->coded }}</span>
                                        </div>
                                    </div>
                                </div><!-- .profile-ud-list -->
                            </div><!-- .nk-block -->
                            <div class="nk-block">
                                <div class="nk-block-head nk-block-head-line">
                                    <h6 class="title overline-title text-base">Parcel Information</h6>
                                </div><!-- .nk-block-head -->
                                <div class="profile-ud-list">
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Total</span>
                                            <span class="profile-ud-value">1</span>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Pending</span>
                                            <span class="profile-ud-value">1</span>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Received</span>
                                            <span class="profile-ud-value">0</span>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Return</span>
                                            <span class="profile-ud-value">0</span>
                                        </div>
                                    </div>
                                </div><!-- .profile-ud-list -->
                            </div><!-- .nk-block -->
                            <div class="nk-divider divider md"></div>
                            <div class="nk-block">
                                <div class="nk-block-head nk-block-head-sm nk-block-between">
                                    <h5 class="title">Admin Note</h5>
                                    <a href="#" data-toggle="modal" data-target="#add-remark" class="link link-sm">+ Add Note</a>
                                </div><!-- .nk-block-head -->

                                @foreach($trip->remarks as $remark)
                                    <div class="bq-note">
                                        <div class="bq-note-item">
                                            <div class="bq-note-text">
                                                <p>{{ $remark->text }}</p>
                                            </div>
                                            <div class="bq-note-meta">
                                                <span class="bq-note-added">Added on <span class="date">{{ reformatDatetime($remark->created_at, 'd M,Y') }}</span> at <span class="time">{{ reformatDatetime($remark->created_at, 'H:i A') }}</span></span>
                                                <span class="bq-note-sep sep">|</span>
                                                <span class="bq-note-by">By <span>{{ $remark->user->name }}</span></span>
                                                @if(auth()->user()->id == $remark->user_id)
                                                    <a href="{{ route('admin.trip-remark.delete', $remark->id) }}" onclick="return confirm('Are you sure want to delete this notes?')" class="link link-sm link-danger">Delete Note</a>
                                                @endif
                                            </div>
                                        </div><!-- .bq-note-item -->
                                    </div><!-- .bq-note -->
                                @endforeach
                            </div><!-- .nk-block -->
                        </div><!-- .card-inner -->
                    </div><!-- .card-content -->
                </div><!-- .card-aside-wrap -->
            </div>
        </div>
    </div>

    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title">Parcels</h4>
                <div class="nk-block-des">
                    <p>Notes : </p>
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
                        <th class="nk-tb-col"><span class="sub-text">Tracking No</span></th>
                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Last Transaction</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Created At</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></th>
                        <th class="nk-tb-col nk-tb-col-tools text-right">

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($parcels as $parcel)
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
                                    <span class="tb-lead">{{ $parcel->tracking_no }} <span class="dot dot-success d-md-none ml-1"></span></span>
                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-mb">
                            <span class="tb-amount">{{ $parcel->lastTransaction->remark }}</span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>{{ reformatDatetime($parcel->created_at, 'd-m H:i A') }}</span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>{!! getTripStatusBadge($parcel->status) !!}</span>
                        </td>
                        <td class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="{{ route('admin.trip.deleteParcel', $parcel->id) }}" onclick="return confirm('Are you sure want to remove this parcel ({{ $parcel->tracking_no }})?')"><em class="icon ni ni-trash"></em><span>Remove</span></a></li>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="add-remark">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <x-forms.post :action="route('admin.trip-remark.create', $trip->id)" class="row gy-4">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="text">@lang('Add Remark')</label>
                                    <textarea name="text" id="text" class="form-control" required>{{ old('text') }}</textarea>
                                    @error('text')
                                        <span id="fv-text-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 m-2">
                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                    <li>
                                        <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Add Remark')</button>
                                    </li>
                                    <li>
                                        <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                    </li>
                                </ul>
                            </div>
                        </x-forms.post>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->

@endsection
@push('after-scripts')

@endpush
