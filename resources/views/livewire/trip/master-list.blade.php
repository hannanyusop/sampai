<div>
    <div class="nk-content-wrap">
        <div class="nk-block">

            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Master List</h3>
                        <div class="nk-block-des text-soft">
                            <p>Trip : <span class="text-base">#{{ $trip->code }}</span></p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="{{ route('admin.trip.index') }}" class="btn btn-outline-light bg-warning d-none d-sm-inline-flex"><em class="icon ni ni-back-alt"></em><span>Back</span></a>
                        <a href="#" wire:click="export()" class="btn btn-success d-none d-sm-inline-flex"><em class="icon ni ni-download-cloud"></em><span>Export</span></a>
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
                                            <span class="profile-ud-value">{{ $trip->destination->code }}</span>
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

    <div class="row g-gs">
        <div class="col-md-12 mt-3">
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

                    <form class="form-inline">
                        <div class="form-group mb-2">
                            <input type="text" class="form-control" placeholder="Tracking No." wire:model="tracking_no">
                        </div>
                    </form>

                    <table class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                        <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col"><span class="sub-text">Tracking No</span></th>
                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Order Origin</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Description</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Price</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tax</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parcels as $parcel)
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col">
                                    <div class="user-card">
                                        <div class="user-info">
                                            <span class="tb-lead">{{ $parcel->tracking_no }} <span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col tb-col-mb">
                                    <span class="tb-amount">{{ $parcel->order_origin }}</span>
                                </td>
                                <td class="nk-tb-col tb-col-md">
                                    <span>{{ $parcel->description }}</span>
                                </td>
                                <td class="nk-tb-col tb-col-lg">
                                    <span>{{ displayPriceFormat($parcel->price) }}</span>
                                </td>
                                <td class="nk-tb-col tb-col-lg">


                                @can('staff.distributor')
                                    @if($edited_id != $parcel->id)
                                            <span>{{ displayPriceFormat($parcel->tax, '$') }} <em wire:click="changeEditedId({{ $parcel->id }})" class="icon ni ni-edit"></em></span>
                                    @else
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">BND ($)</span>
                                            </div>
                                            <input type="text" class="form-control" value="{{ $parcel->tax }}" min="0.00" placeholder="Tax" wire:model="tax">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" wire:click="updateTax()"><em class="icon ni ni-check"></em></button>
                                            </div>
                                        </div>
                                        @error('tax')<small class="text-danger">{{ $message }}</small>@enderror
                                    @endif
                                @else
                                    <span>{{ displayPriceFormat($parcel->tax, '$') }}</span>
                                @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
