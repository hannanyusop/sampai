<div>
    <div class="nk-content-wrap">
        <div class="nk-block">

            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Trip Batch View</h3>
                        <div class="nk-block-des text-soft">
                            <p>Receiver Office : <span class="text-base">{{ __(":code - :name", ["code" => $tripBatch?->office?->code, "name" => $tripBatch?->office?->name]) }}</span></p>
                            <p>Trip : <span class="text-base">{{ $tripBatch->number }}</span></p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="{{ route('admin.tripBatch.index') }}" class="btn btn-outline-light bg-warning d-none d-sm-inline-flex"><em class="icon ni ni-back-alt"></em><span>Back</span></a>
                        @can('admin.trip.master')
                            <a href="{{ route('admin.trip.masterList', $tripBatch->id) }}" class="btn btn-success d-none d-sm-inline-flex"><em class="icon ni ni-list-check"></em><span>Master List</span></a>
                        @endcan
                        @can('admin.trip.billing')
                            <a href="{{ route('admin.billing.view', $tripBatch) }}" class="btn btn-primary d-none d-sm-inline-flex"><em class="icon ni ni-money"></em>Billing</a>
                        @endcan
                        @can('staff.biacc')
                            <button wire:click="exportBiacc()" class="btn btn-outline-light bg-success"><em class="icon ni ni-download"></em>
                                <span>
                                     <div wire:loading>
                                        Exporting file...
                                    </div>
                                    <div wire:loading.remove>
                                        Export List (BIACC)
                                    </div>
                                </span>
                            </button>
                        @endcan
                        @can('staff.distributor')
                            @if($tripBatch->status == \App\Services\TripBatch\TripBatchHelperService::STATUS_PENDING)
                                <button wire:click="showUploadForm()" class="btn btn-outline-light bg-primary d-none d-sm-inline-flex"><em class="icon ni ni-upload-cloud"></em><span>Upload</span></button>
                            @endif
                            @can('admin.trip.close')
                                @if(!$tripBatch->is_closed)
                                    <a href="{{ route('admin.trip.close', $tripBatch->id) }}" onclick="return confirm('Are you sure want to close this trip?')" class="btn btn-light d-none d-sm-inline-flex"><em class="icon ni ni-clock"></em><span>Close Trip</span></a>
                                @endif
                            @endcan
                        @endcan
                        <div class="drodown m-2">
                            <button href="#" class="dropdown-toggle btn btn-info" data-toggle="dropdown">Checklist <em class="icon ni ni-caret-down"></em></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="link-list-opt no-bdr">
                                    <a href="{{ route('admin.trip.checklist-all', $tripBatch) }}">
                                        <em class="icon ni ni-list"></em>
                                        <span>All</span>
                                    </a>
                                </ul>
                                @foreach($tripBatch->trips as $trip)
                                    <ul class="link-list-opt no-bdr">
                                        <a href="{{ route('admin.trip.checklist', $trip) }}">
                                            <em class="icon ni ni-list"></em>
                                            <span>Only For {{ $trip->destination->code }}</span>
                                        </a>
                                    </ul>
                                @endforeach
                            </div>
                        </div>
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
                                </div>

                                <div class="tranx-list card card-bordered">
                                    <div class="tranx-item">
                                        <div class="tranx-col">
                                            <div class="tranx-info">
                                                <div class="tranx-data">
                                                    <div class="tranx-label"> Trip : {{ $tripBatch->number }} <em class="tranx-icon sm icon ni ni-truck"></em>
                                                    </div>
                                                    <div class="tranx-date">{{ reformatDatetime($tripBatch->date, 'd M, Y') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tranx-col">
                                            <div class="tranx-amount">
                                                <div class="number">Tax Rate : {{ $tripBatch->tax_rate_currency }} <span class="currency currency-btc"></span>
                                                </div>
                                                <div class="number-sm">Pos Rate : {{ $tripBatch->pos_rate_currency }}<span class="currency currency-usd"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .nk-block -->
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

                            @can('staff.distributor')
                                @if(!$showUploadForm)
                                    <div  class="nk-refwg-invite card-inner">
                                        <div class="nk-refwg-title">
                                            <div class="title-sub">Add Parcel</div>
                                        </div>
                                        <div class="nk-refwg-url">
                                            <div class="form-control-wrap">
                                                <div class="form-clip clipboard-init"><button wire:click="search()" class="btn"><em class="clipboard-icon icon ni ni-search"></em> <span class="clipboard-text"> Search</span></button></div>
                                                <div class="form-icon">
                                                    <em class="icon ni ni-tag-alt"></em>
                                                </div>
                                                <input type="text" class="form-control copy-text text-uppercase" id="tracking_no" name="tracking_no" placeholder="ER123456MY" wire:model="tracking_no">
                                            </div>
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
                                                                                {{ $last_parcel->dropPoint?->name }}
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="sp-plan-desc sp-plan-desc-mb">
                                                                    <ul class="row gx-1">
                                                                        <li class="col-sm-8">
                                                                            <p><span class="text-soft">Description</span>
                                                                                <small> {{ $last_parcel->description }}</small>
                                                                            </p>
                                                                        </li>
                                                                        <li class="col-sm-4">
                                                                            <p><span class="font-weight-bold">Parcel Code</span>
                                                                                {{ $last_parcel->coding }}
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="sp-plan-desc sp-plan-desc-mb">
                                                                    <ul class="row gx-1">
                                                                        <li class="col-sm-4">
                                                                            <p><span class="text-soft">Service Charge ($)</span>
                                                                                <input type="number" class="form-control" wire:model="service_charge">
                                                                            </p>
                                                                        </li>

                                                                        <li class="col-sm-4">
                                                                            <p><span class="text-soft">Guni</span>
                                                                                <input type="text" class="form-control" wire:model="guni">
                                                                            </p>
                                                                        </li>
                                                                        <li class="col-sm-4">
                                                                            <p><span class="text-soft">COD ($)</span>
                                                                                <input type="number" class="form-control" wire:model="cod_fee">
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="text-center my-2">
                                                                    <button wire:click="save()" class="btn btn-success me-2"><i class="icon ni ni-check"></i>Save</button>
                                                                    @if($last_parcel->pickup_id)
                                                                        <button wire:click="undo()" class="btn btn-danger me-2"><i class="icon ni ni-times"></i>Remove</button>
                                                                    @endif
                                                                    <button wire:click="cancel()" class="btn btn-warning me-2"><i class="icon ni ni-redo"></i>Cancel</button>
                                                                </div>

                                                            </div><!-- .card-inner -->

                                                        </div><!-- .card-inner-group -->
                                                    </div><!-- .card -->
                                                </div><!-- .col -->
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div  class="nk-refwg-invite card-inner">

                                        <div class="alert alert-info"><span class="ni ni-info"></span> Excel header must have <b class="font-italic">No Item,Name, Tracking No, Harga</b> </div>
                                        <div class="nk-refwg-title">
                                            <div class="title-sub">Upload Offline Parcel</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <input class="form-control-file" type="file" accept=".xlsx" wire:model="excel">
                                            </div>
                                        </div>

                                        <div class="text-center my-2">
                                            <button wire:click="hideUploadForm()" class="btn btn-danger me-2"><i class="icon ni ni-times"></i>Cancel</button>
                                            <button wire:click="upload()" class="btn btn-success me-2"><i class="icon ni ni-check"></i>Save</button>
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
                                                                                {{ $last_parcel->dropPoint?->name }}
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="sp-plan-desc sp-plan-desc-mb">
                                                                    <ul class="row gx-1">
                                                                        <li class="col-sm-8">
                                                                            <p><span class="text-soft">Description</span>
                                                                                <small> {{ $last_parcel->description }}</small>
                                                                            </p>
                                                                        </li>
                                                                        <li class="col-sm-4">
                                                                            <p><span class="font-weight-bold">Parcel Code</span>
                                                                                {{ $last_parcel->coding }}
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="sp-plan-desc sp-plan-desc-mb">
                                                                    <ul class="row gx-1">
                                                                        <li class="col-sm-4">
                                                                            <p><span class="text-soft">Service Charge ($)</span>
                                                                                <input type="number" class="form-control" wire:model="service_charge">
                                                                            </p>
                                                                        </li>
                                                                        <li class="col-sm-4">
                                                                            <p><span class="text-soft">Guni</span>
                                                                                <input type="text" class="form-control" wire:model="guni">
                                                                            </p>
                                                                        </li>

                                                                    </ul>
                                                                </div>

                                                                <div class="text-center my-2">
                                                                    <button wire:click="save()" class="btn btn-success me-2"><i class="icon ni ni-check"></i>Save</button>
                                                                    @if($last_parcel->pickup_id)
                                                                        <button wire:click="undo()" class="btn btn-danger me-2"><i class="icon ni ni-times"></i>Remove</button>
                                                                    @endif
                                                                    <button wire:click="cancel()" class="btn btn-warning me-2"><i class="icon ni ni-redo"></i>Cancel</button>
                                                                </div>

                                                            </div><!-- .card-inner -->

                                                        </div><!-- .card-inner-group -->
                                                    </div><!-- .card -->
                                                </div><!-- .col -->
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endcan
                        </div><!-- .card-inner -->
                    </div><!-- .card-content -->
                </div><!-- .card-aside-wrap -->
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">

            <div class="nk-block nk-block-lg">
                <div class="card card-bordered">
                    <div class="card-inner">

                        <div class="row my-4">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="ft" wire:model="filter_tracking_no" placeholder="{{ __('Tracking No') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="fn" wire:model="filter_name" placeholder="{{ __('Customer Name') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="fn" wire:model="filter_phone_no" placeholder="{{ __('Phone Number') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <button class="btn btn-warning" wire:click="resetFilter()"><span class="ni ni-redo mr-1"></span> {{ __('Reset') }}</button>
                                </div>
                            </div>
                        </div>



                        <table class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                            <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col"><span class="sub-text">Name</span></th>
                                <th class="nk-tb-col tb-col-md"><span class="sub-text">Tracking / Description</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Koding / Guni</span></th>
                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Parcel Price (RM)</span></th>

                                @cannot('staff.biacc')
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tax ($)</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">COD ($)</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Service Charge ($)</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Permit ($)</span></th>
                                    <th class="nk-tb-col"><span class="sub-text">Action</span></th>
                                @else
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Invoice</span></th>
                                @endcannot
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($parcels as $parcel)
                                <tr class="nk-tb-item">
                                    <td class="nk-tb-col tb-col-md">
                                        <span>{{ $parcel?->receiver_name }}</span><br>
                                        <small>{{ $parcel?->phone_number }}</small>
                                    </td>

                                    <td class="nk-tb-col">
                                        <b class="tb-lead">{{ $parcel->tracking_no }}</span></b>
                                        <small>{{ $parcel->description }}</small>
                                    </td>
                                    <td class="nk-tb-col">
                                        @if($parcel->id == $edit_parcel_id)
                                            <input type="text" class="form-control" value="{{ $parcel->guni }}" placeholder="Guni Number" wire:model="guni_edit">
                                            @error('guni_edit') <span class="text-danger">{{ $message }}</span> @enderror
                                        @else
                                            <span>{{ $parcel?->coding }}</span><br>
                                            <small>{{ $parcel?->guni ?? "-" }}</small>
                                        @endif
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ displayPriceFormat($parcel->price) }}</span>
                                    </td>
                                    @cannot('staff.biacc')

                                        <td class="nk-tb-col tb-col-lg">
                                            <span>{{ displayPriceFormat($parcel->tax, '$') }}</span>
                                        </td>
                                        <td class="nk-tb-col tb-col-lg">
                                            <span>{{ displayPriceFormat($parcel->cod_fee, '$') }}</span>
                                        </td>
                                        <td class="nk-tb-col tb-col-lg">
                                            @if($parcel->id == $edit_parcel_id)
                                                <input type="number" class="form-control" placeholder="$" wire:model="service_charge_edit">
                                                @error('service_charge_edit') <span class="text-danger">{{ $message }}</span> @enderror
                                            @else
                                            <span>{{ displayPriceFormat($parcel->service_charge, '$') }}</span>
                                            @endif
                                        </td>
                                        <td class="nk-tb-col tb-col-lg">
                                            <span>{{ displayPriceFormat($parcel?->permit, '$') }}</span>
                                        </td>

                                        <td class="nk-tb-col">

                                        @if($parcel->id == $edit_parcel_id)
                                            <button class="btn btn-sm btn-success" wire:click="updateParcel({{ $parcel }})"><em class="icon ni ni-check-circle"></em></button>
                                        @else
                                            <ul class="nk-tb-actions gx-1">
                                                <li>
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="link-list-opt no-bdr">
                                                                <a href="#" wire:click.prevent="editParcel({{ $parcel }})">
                                                                    <em class="icon ni ni-edit"></em>
                                                                    <span>Edit</span>
                                                                </a>
                                                            </ul>
                                                            <ul class="link-list-opt no-bdr">
                                                                <a href="#" wire:click.prevent="deleteParcel({{ $parcel->id }})"
                                                                   onclick="return confirm('Are you sure want to remove this parcel ({{ $parcel->tracking_no }})?')">
                                                                    <em class="icon ni ni-trash"></em>
                                                                    <span>Remove</span>
                                                                </a>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endif
                                    </td>
                                    @else
                                        <td class="nk-tb-col">
                                            <a href="{{ route('frontend.user.parcel.download',encrypt($parcel->id)) }}" class="btn btn-info btn-sm">
                                                <em class="icon ni ni-eye"></em>
                                                <span>Invoice</span>
                                            </a>
                                        </td>
                                    @endcannot
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="mt-2">
                            {{ $parcels->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
