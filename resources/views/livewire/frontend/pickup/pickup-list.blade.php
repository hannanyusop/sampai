
<div class="nk-block nk-block-lg">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item text-lg"><a href="{{ route('frontend.user.dashboard') }}">Dashboard</a></li>
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
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Trip</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Office</span></th>
                        <th class=""><span class="sub-text">Code</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Pickup By</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Pickup Datetime</span></th>
                        <th class=""><span class="sub-text">Status</span></th>
                        <th class="nk-tb-col nk-tb-col-tools text-right">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pickups as $pickup)
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col tb-col-lg">
                                <span class="tb-amount">{{ $pickup->trip->code }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span class="tb-amount">{{ $pickup->dropPoint->name }}</span>
                            </td>
                            <td class="">
                                <span>{{ $pickup->code }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ (!is_null($pickup->pickup_name))? $pickup->pickup_name : "" }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ (!is_null($pickup->pickup_name))? $pickup->pickup_datetime : "" }}</span>
                            </td>
                            <td class="">
                                <span class="tb-status text-success">{{ $pickup->status_label }}</span>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <a class="btn btn-primary btn-md" href="{{ route('frontend.user.pickup.show',encrypt($pickup->id)) }}">@lang('View')</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- .card-preview -->
</div> <!-- nk-block -->
