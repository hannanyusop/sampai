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
                                    <th>{{ __('Last Notification') }}</th>
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
                                            @if($pickup->latestNotification)
                                                <div class="text-center">
                                                    {!! $pickup->latestNotification->via_badge !!}<br>
                                                    {!! $pickup->latestNotification->status_badge !!}<br>
                                                    <small class="text-muted">{{ $pickup->latestNotification->created_at->format('d/m/Y H:i') }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical">
                                                <a href="{{ route('admin.billing.resendNotification', $pickup) }}" class="btn btn-primary btn-sm">
                                                    <em class="icon ni ni-mail"></em> {{ __('Email') }}
                                                </a>
                                                @if($pickup->user?->phone_number)
                                                    <a href="{{ route('admin.billing.sendWhatsAppNotification', $pickup) }}"
                                                       class="btn btn-success btn-sm"
                                                       onclick="return confirm('Send WhatsApp to {{ $pickup->user->phone_number }}?')">
                                                        <em class="icon ni ni-whatsapp"></em> {{ __('WhatsApp') }}
                                                    </a>
                                                @endif
                                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                                        onclick="showNotificationHistory({{ $pickup->id }})">
                                                    <em class="icon ni ni-history"></em> {{ __('History') }}
                                                </button>
                                            </div>
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

    <!-- Notification History Modal -->
    <div class="modal fade" id="notificationHistoryModal" tabindex="-1" role="dialog" aria-labelledby="notificationHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationHistoryModalLabel">{{ __('Notification History') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="notificationHistoryContent">
                        <div class="text-center py-4">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('after-scripts')
<script>
    function showNotificationHistory(pickupId) {
        var modalEl = document.getElementById('notificationHistoryModal');
        var contentDiv = document.getElementById('notificationHistoryContent');

        contentDiv.innerHTML = '<div class="text-center py-4"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';

        // Use jQuery modal (Bootstrap 4 style used by DashLite theme)
        $(modalEl).modal('show');

        fetch('{{ url("admin/billing/notificationHistory") }}/' + pickupId)
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.notifications.length === 0) {
                    contentDiv.innerHTML = '<div class="alert alert-info">{{ __("No notification history found.") }}</div>';
                    return;
                }

                var html = '<p class="mb-3"><strong>{{ __("Pickup Code") }}:</strong> ' + data.pickup_code + '</p>';
                html += '<div class="table-responsive"><table class="table table-bordered table-sm">';
                html += '<thead class="bg-light"><tr>';
                html += '<th>{{ __("Date") }}</th>';
                html += '<th>{{ __("Via") }}</th>';
                html += '<th>{{ __("Address") }}</th>';
                html += '<th>{{ __("Status") }}</th>';
                html += '<th>{{ __("Remark") }}</th>';
                html += '</tr></thead><tbody>';

                data.notifications.forEach(function(n) {
                    html += '<tr>';
                    html += '<td>' + n.created_at + '</td>';
                    html += '<td>' + n.via_badge + '</td>';
                    html += '<td><small>' + n.address + '</small></td>';
                    html += '<td>' + n.status_badge + '</td>';
                    html += '<td><small>' + (n.provider_remark || '-') + '</small></td>';
                    html += '</tr>';
                });

                html += '</tbody></table></div>';
                contentDiv.innerHTML = html;
            })
            .catch(function(error) {
                contentDiv.innerHTML = '<div class="alert alert-danger">{{ __("Failed to load notification history.") }}</div>';
                console.error('Error:', error);
            });
    }
</script>
@endpush
