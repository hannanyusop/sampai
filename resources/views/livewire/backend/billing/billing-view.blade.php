<div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card card-bordered">
                <div class="card-inner-group">
                    <div class="card-inner">

                        <div class="my-3">
                            {{ $pickups->links() }}
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-dark text-white">
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <td>{{ __('Phone Number') }}</td>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Parcel Coding') }}</th>
                                    <td>{{ __('Quantity') }}</td>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('COD') }}</th>
                                    <th>{{ __('Tax') }}</th>
                                    <th>{{ __('Permit') }}</th>
                                    <th>{{ __('Service Charge') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    <th>{{ __('Location') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pickups as $pickup)
                                    <tr>
                                        <td>{{ $pickup?->user?->name }}</td>
                                        <td>{{ $pickup?->user?->phone_number }}</td>
                                        <td>{{ $pickup->code }}</td>
                                        <td>
                                            @foreach($pickup->parcels as $parcel)
                                                <small>{{ __(':coding - :price', ['coding' => $parcel->coding, 'price' => displayPriceFormat($parcel->total_billing, '$')]) }}</small><br>
                                            @endforeach
                                        </td>
                                        <td>{{ $pickup->parcels->count() }}</td>
                                        <td>{{ displayPriceFormat($pickup->gross_price, '$') }}</td>
                                        <td>{{ displayPriceFormat($pickup->cod, '$') }}</td>
                                        <td>{{ displayPriceFormat($pickup->tax, '$') }}</td>
                                        <td>{{ displayPriceFormat($pickup->permit, '$') }}</td>
                                        <td>{{ displayPriceFormat($pickup?->service_charge, '$') }}</td>
                                        <td>{{ displayPriceFormat($pickup?->total, '$') }}</td>
                                        <td>{{ $pickup?->dropPoint->code }}</td>
                                        <td>{!! $pickup?->status_badge !!}</td>
                                        <td>
                                            <a href="{{ route('admin.billing.resendNotification', $pickup) }}" class="btn btn-primary btn-sm">{{ __('Send Notification') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>



                    </div><!-- .card-inner -->
                </div><!-- .card-inner-group -->
            </div><!-- .card -->
        </div><!-- .col -->
    </div>
</div>
