<div>
    <div class="nk-content-wrap">
        <div class="nk-block">

            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Master List</h3>
                        <div class="nk-block-des text-soft">
                            <p>Trip : <span class="text-base">{{ $trip_batch->number }}</span></p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="{{ route('admin.tripBatch.show', $trip_batch) }}" class="btn btn-outline-light bg-warning d-none d-sm-inline-flex"><em class="icon ni ni-back-alt"></em><span>Back</span></a>
                        <a href="#" wire:click="export()" class="btn btn-success d-none d-sm-inline-flex"><em class="icon ni ni-download-cloud"></em><span>Export</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-gs">
        <div class="col-md-12 mt-3">
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
                                            <span class="profile-ud-value">{{ $trip_batch->number }}</span>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Date</span>
                                            <span class="profile-ud-value">{{ reformatDatetime($trip_batch->date, 'd M, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-ud-list">
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Tax Rate</span>
                                            @if(!$edit_rate)
                                                <span class="profile-ud-value">{{ money($trip_batch->tax_rate, "BND") }}</span>
                                            @else
                                                <input type="number" class="form-control" wire:model="tax_rate">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Pos Rate</span>
                                            @if(!$edit_rate)
                                                <span class="profile-ud-value">{{ money($trip_batch->pos_rate, "BND") }}</span>
                                            @else
                                                <input type="number" class="form-control" wire:model="pos_rate">
                                            @endif
                                        </div>
                                        @if(!$edit_rate)
                                            <button wire:click="editRate()" class="btn btn-warning"><i class="ni ni-edit me-2"></i> Edit Rate</button>
                                        @else
                                            <button wire:click="saveRate()" class="btn btn-success"><i class="ni ni-save me-2"></i> Save Rate</button>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- .nk-block -->
                            <div class="nk-divider divider md"></div>
                            <div class="nk-block">
                                <div  class="nk-refwg-invite card-inner">
                                    <div class="nk-refwg-title">
                                        <div class="title-sub">Add Parcel</div>
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
                                </div>

                            </div><!-- .nk-block -->
                        </div><!-- .card-inner -->
                    </div><!-- .card-content -->
                </div><!-- .card-aside-wrap -->
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
