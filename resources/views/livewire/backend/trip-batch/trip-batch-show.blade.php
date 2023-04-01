<div>
    <div class="nk-content-wrap">
        <div class="nk-block">

            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Trip View</h3>
                        <div class="nk-block-des text-soft">
                            <p>Trip : <span class="text-base">#{{ $tripBatch->number }}</span></p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="{{ route('admin.trip.index') }}" class="btn btn-outline-light bg-warning d-none d-sm-inline-flex"><em class="icon ni ni-back-alt"></em><span>Back</span></a>
                        @can('staff.distributor')
                            <a href="{{ route('admin.trip.masterList', $tripBatch->id) }}" class="btn btn-success d-none d-sm-inline-flex"><em class="icon ni ni-list-check"></em><span>Master List</span></a>
                        @endcan
                        @if(auth()->user()->can('staff.distributor') && $tripBatch->status == 0)
                            <a href="{{ route('admin.trip.addParcel', $tripBatch->id) }}" class="btn btn-success d-none d-sm-inline-flex"><em class="icon ni ni-plus"></em><span>Add Parcel</span></a>
                            <a href="{{ route('admin.trip.close', $tripBatch->id) }}" onclick="return confirm('Are you sure want to close this trip?')" class="btn btn-light d-none d-sm-inline-flex"><em class="icon ni ni-clock"></em><span>Close Trip</span></a>
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
                                            <span class="profile-ud-value">#{{ $tripBatch->code }}</span>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Destination</span>
{{--                                            <span class="profile-ud-value">{{ $tripBatch->destination->name }} </span>--}}
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Date</span>
                                            <span class="profile-ud-value">{{ reformatDatetime($tripBatch->date, 'd M, Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Destination Code</span>
{{--                                            <span class="profile-ud-value">{{ $tripBatch->destination->coded }}</span>--}}
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

                                <div  class="nk-refwg-invite card-inner">
                                    <div class="nk-refwg-head g-3">
                                        <div class="nk-refwg-title">
                                            <h5 class="title">Add Parcel</h5>
                                            <div class="title-sub">Only Registered Parcel Will be ~.</div>
                                        </div>
                                    </div>
                                    <div class="nk-refwg-url">
                                        <div class="form-control-wrap">
                                            <div class="form-clip clipboard-init"><button wire:click="insert()" class="btn"><em class="clipboard-icon icon ni ni-search"></em> <span class="clipboard-text"> Search</span></button></div>
                                            <div class="form-icon">
                                                <em class="icon ni ni-tag-alt"></em>
                                            </div>
                                            <input type="text" class="form-control copy-text text-uppercase" id="tracking_no" name="tracking_no" placeholder="ER123456MY" wire:model="tracking_no">
                                        </div>
                                    </div>

                                    <div class="my-2">
                                        @if(session()->get('insert_success'))
                                            <div class="alert alert-success">
                                                <i class="icon ni ni-check me-2"></i> {{ session()->get('insert_success') }}
                                            </div>
                                        @endif
                                        @if(session()->get('insert_error'))
                                            <div class="alert alert-danger">
                                                <i class="icon ni ni-bell me-2"></i> {{ session()->get('insert_error') }}
                                            </div>
                                        @endif
                                    </div>

                                    @if($last_parcel)
                                        <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card card-bordered">
                                                <div class="card-inner-group">
                                                    <div class="card-inner">
                                                        <div class="sp-plan-head">
                                                            <h6 class="title">Parcel Details</h6>
                                                        </div>
                                                        <div class="sp-plan-desc sp-plan-desc-mb">
                                                            <ul class="row gx-1">
                                                                <li class="col-sm-4">
                                                                    <p><span class="text-soft">Tracking No.</span>
                                                                        {{ $last_parcel->tracking_no }}
                                                                    </p>
                                                                </li>
                                                                <li class="col-sm-4">
                                                                    <p><span class="text-soft">Date Received</span>
                                                                        {{ $last_parcel->created_at }}
                                                                    </p>
                                                                </li>
                                                                <li class="col-sm-4">
                                                                    <p><span class="text-soft">Destination</span>
                                                                        {{ $last_parcel?->trip?->destination?->name }}
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="text-center my-2">
                                                            <button wire:click="undo()" class="btn btn-warning"><i class="icon ni ni-redo"></i>Undo</button>
                                                        </div>

                                                    </div><!-- .card-inner -->

                                                </div><!-- .card-inner-group -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        </div>
                                    @endif
                                </div>

                            </div><!-- .nk-block -->
                        </div><!-- .card-inner -->
                    </div><!-- .card-content -->
                </div><!-- .card-aside-wrap -->
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @foreach($tripBatch->trips as $trip)
            <div class="col-md-6">
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered card-preview">

                        <p class="m-3">Destination : {{ $trip->destination->coded }} - {{ $trip->destination->name }} </p>

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
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></th>
                                    <th class="nk-tb-col nk-tb-col-tools text-right">
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($trip->parcels as $parcel)
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
                                                                <a href="#" wire:click.prevent="deleteParcel({{ $parcel->id }})"
                                                                   onclick="return confirm('Are you sure want to remove this parcel ({{ $parcel->tracking_no }})?')">
                                                                    <em class="icon ni ni-trash"></em>
                                                                    <span>Remove</span>
                                                                </a>

{{--                                                                <li><a href="{{ route('admin.trip.deleteParcel', $parcel->id) }}" onclick="return confirm('Are you sure want to remove this parcel ({{ $parcel->tracking_no }})?')"><em class="icon ni ni-trash"></em><span>Remove</span></a></li>--}}
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
                </div>
            </div>
        @endforeach
    </div>


</div>
