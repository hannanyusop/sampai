<div>
    <div class="nk-content-wrap">
        <div class="nk-block">

            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Parcel Checklist By Drop Point</h3>
                        <div class="nk-block-des text-soft">
                            <p>Trip : <span class="text-base">{{ $trip->destination->name }}</span></p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="{{ route('admin.tripBatch.show', $trip->trip_batch_id) }}" class="btn btn-outline-light bg-warning d-none d-sm-inline-flex"><em class="icon ni ni-back-alt"></em><span>Back</span></a>
                        <a wire:click="resetList"  class="btn btn-danger d-none d-sm-inline-flex"><em class="icon ni ni-redo"></em><span>Reset List</span></a>
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
                                            <span class="profile-ud-value">{{ $trip->number }}</span>
                                        </div>
                                    </div>
                                    <div class="profile-ud-item">
                                        <div class="profile-ud wider">
                                            <span class="profile-ud-label">Date</span>
                                            <span class="profile-ud-value">{{ reformatDatetime($trip->date, 'd M, Y') }}</span>
                                        </div>
                                    </div>
                                </div><!-- .profile-ud-list -->
                            </div><!-- .nk-block -->
                            <div class="nk-divider divider md"></div>

                            <div class="text-center">
                                <h4>{{ __(":checked of  :total checked", ['checked' => $checked, 'total' => $total ]) }}</h4>
                                <p>{{ __(':unchecked parcels missing', ['unchecked' => $unchecked]) }}</p>
                            </div>
                            <div class="nk-block">
                                <div  class="nk-refwg-invite card-inner">
                                    <div class="nk-refwg-url">
                                        <div class="form-control-wrap">
                                            <div class="form-clip clipboard-init"><button wire:click="search()" class="btn"><em class="clipboard-icon icon ni ni-search"></em> <span class="clipboard-text"> Search</span></button></div>
                                            <div class="form-icon">
                                                <em class="icon ni ni-tag-alt"></em>
                                            </div>
                                            <input type="text" autofocus class="form-control copy-text text-uppercase" id="tracking_no" name="tracking_no" placeholder="ER123456MY" wire:model="tracking_no">
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


                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="bg-dark text-white">
                                            <th>Tracking No.</th>
                                            <th>Pickup Code</th>
                                            <th>Receiver Name</th>
                                            <th>Description</th>
                                            <th>Origin</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Tax</th>
                                            <th>Permit</th>
                                            <th>Checked</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($parcels as $parcel)
                                            <tr>
                                                <td>{{ $parcel->tracking_no }}</td>
                                                <td>{{ $parcel->pickup->code }}</td>
                                                <td>{{ $parcel->receiver_name }}</td>
                                                <td>{{ $parcel->description }}</td>
                                                <td>{{ $parcel->order_origin }}</td>
                                                <td>{{ $parcel->quantity }}</td>
                                                <td>{{ money($parcel->price) }}</td>
                                                <td>{{ money($parcel->tax) }}</td>
                                                <td>{{ money($parcel->permit) }}</td>
                                                <td>
                                                    @if($parcel->checked)
                                                        <span class="badge badge-success">Checked</span>
                                                    @else
                                                        <span class="badge badge-warning">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div><!-- .nk-block -->
                        </div><!-- .card-inner -->
                    </div><!-- .card-content -->
                </div><!-- .card-aside-wrap -->
            </div>
        </div>
    </div>
</div>
