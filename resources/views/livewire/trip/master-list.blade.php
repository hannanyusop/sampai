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
                        <a href="#" wire:click="exportWhatsappBot()" class="btn btn-success d-none d-sm-inline-flex"><em class="icon ni ni-download-cloud"></em><span>Whatsapp Bot Export</span></a>
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
                                                <span class="profile-ud-value">{{ $trip_batch->tax_rate_currency }}</span>
                                            @else
                                                <input type="number" class="form-control" wire:model="tax_rate">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Pos Rate</span>
                                            @if(!$edit_rate)
                                                <span class="profile-ud-value">{{ $trip_batch->pos_rate_currency }}</span>
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
                                        <div class="title-sub">Search Parcel</div>
                                    </div>
                                    <div class="nk-refwg-url">
                                        <div class="form-control-wrap">
                                            <div class="form-icon">
                                                <em class="icon ni ni-tag-alt"></em>
                                            </div>
                                            <input type="text" class="form-control copy-text text-uppercase" id="tracking_no" name="tracking_no" placeholder="ER123456MY" wire:model="tracking_no">
                                        </div>
                                    </div>
                                </div>

                            </div><!-- .nk-block -->
                        </div><!-- .card-inner -->
                    </div><!-- .card-content -->
                </div><!-- .card-aside-wrap -->
            </div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">

                    <div class="my-2">
                        @if(session()->get('success'))
                            <div class="alert alert-success">
                                <i class="icon ni ni-check me-2"></i> {{ session()->get('success') }}
                            </div>
                        @endif
                        @if(session()->get('error'))
                            <div class="alert alert-danger">
                                <i class="icon ni ni-bell me-2"></i> {{ session()->get('error') }}
                            </div>
                        @endif
                    </div>

                    Selected Parcel : {{ $selected_parcel?->tracking_no ?? __("No Parcel Selected") }}

                    <table class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                        <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col"><span class="sub-text">Name</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Description</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Koding/Guni</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Parcel Price (RM)</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Parcel Price / {{ ($currency_exchange) }} ($)</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Tax Percentage (%)</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tax ($)</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">COD (RM)</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">COD Converted ($)</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Service Charge ($)</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Permit ($)</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Action</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parcels as $parcel)
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col tb-col-md">
                                    <span>{{ $parcel?->user?->name }}</span><br>
                                    <small>{{ $parcel?->user?->phone_number }}</small>
                                </td>

                                <td class="nk-tb-col">
                                    <b class="tb-lead">{{ $parcel->tracking_no }}</span></b>
                                    <small>{{ $parcel->description }}</small>
                                </td>
                                <td class="nk-tb-col tb-col-md">
                                    <span>{{ $parcel?->coding }}</span><br>
                                    <small>{{ $parcel?->pickup->code }}</small>
                                </td>

                                @if($edited_id != $parcel->id)
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ displayPriceFormat($parcel->price) }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ displayPriceFormat($parcel->price/$trip_batch->pos_rate, '$') }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ $parcel->percent }}%</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ displayPriceFormat($parcel->tax, '$') }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ displayPriceFormat($parcel->cod_fee_ori, 'RM') }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ displayPriceFormat($parcel->cod_fee, '$') }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ displayPriceFormat($parcel->service_charge, '$') }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ displayPriceFormat($parcel->permit, '$') }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <button class="btn btn-info" wire:click="changeEditedId({{ $parcel->id }})"><em class="icon ni ni-edit"></em></button>
                                    </td>
                                @else
                                    <td class="nk-tb-col tb-col-lg">
                                        <input type="number" class="form-control" value="{{ $parcel->price }}" wire:change="updateTaxValue()" min="0.00" placeholder="Price (RM)" wire:model="price">
                                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ displayPriceFormat($parcel->price/$trip_batch->pos_rate, '$') }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <input type="number" class="form-control" value="{{ $parcel->percent }}" wire:change="updateTaxValue()" min="0.00" placeholder="Percent (%)" wire:model="percent">
                                        @error('percent') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ displayPriceFormat($parcel->tax, '$') }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <input type="number" class="form-control" value="{{ $parcel->cod_fee_ori }}" min="0.00" placeholder="COD Fee ($)" wire:model="cod_fee_ori">
                                        @error('cod_fee_ori') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td> - </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <input type="number" class="form-control" value="{{ $parcel->cod_fee }}" min="0.00" placeholder="COD ($)" wire:model="service_charge">
                                        @error('service_charge') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <input type="number" class="form-control" value="{{ $parcel->permit }}" min="0.00" placeholder="Service Charge ($)" wire:model="permit">
                                        @error('service_charge') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <button class="btn btn-success" wire:click="updateTax()">
                                            <em class="icon ni ni-check"  ></em>
                                        </button>
                                    </td>
                                @endif
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
