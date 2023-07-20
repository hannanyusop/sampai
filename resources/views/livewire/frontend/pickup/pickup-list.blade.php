
<div class="nk-block nk-block-lg">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item text-lg"><a href="#">Parcel Management</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('frontend.user.pickup.index') }}">Pickup List</a></li>
        </ol>
    </nav>
    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <div class="table-responsive">

                <div class="row gy-4">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span class="preview-title overline-title">{{ __('Pickup Code') }}</span>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="default-01" placeholder="{{ __('Pickup Code') }}" wire:model="code">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="preview-block">
                            <span class="preview-title overline-title">Display All</span>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" wire:model="showAll">
                                <label class="custom-control-label" for="customSwitch1"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table mt-5" data-auto-responsive="false">
                    <thead>
                    <tr class="nk-tb-item nk-tb-head">
                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Trip</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Office</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Code</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Pickup By</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Pickup Datetime</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                        <th class="nk-tb-col nk-tb-col-tools text-right">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pickups as $pickup)
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col tb-col-mb">
                                <span class="tb-amount">{{ $pickup->trip->code }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-mb">
                                <span class="tb-amount">{{ $pickup->dropPoint->name }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span>{{ $pickup->code }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ (!is_null($pickup->pickup_name))? $pickup->pickup_name : "" }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ (!is_null($pickup->pickup_name))? $pickup->pickup_datetime : "" }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span class="tb-status text-success">{{ $pickup->status_label }}</span>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="{{ route('frontend.user.pickup.show',encrypt($pickup->id)) }}"><em class="icon ni ni-link-alt"></em><span>@lang('View')</span></a></li>
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
        </div>
    </div><!-- .card-preview -->
</div> <!-- nk-block -->
