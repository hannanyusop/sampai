<div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card card-bordered">
                <div class="card-inner-group">
                    <div class="card-inner">

                        <!-- Flash Messages -->
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">{{ __('Status') }}</label>
                                <select wire:model.lazy="filterStatus" class="form-select form-control">
                                    <option value="">{{ __('All Status') }}</option>
                                    @foreach($statuses as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('Destination') }}</label>
                                <select wire:model.lazy="filterDestination" class="form-select form-control">
                                    <option value="">{{ __('All Destinations') }}</option>
                                    @foreach($destinations as $destination)
                                        <option value="{{ $destination->id }}">{{ $destination->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" wire:model.lazy="filterNotYetNotified" class="custom-control-input" id="filterNotYetNotified">
                                    <label class="custom-control-label" for="filterNotYetNotified">{{ __('Not yet notified') }}</label>
                                </div>
                            </div>
                         </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model.lazy="filterInvalidPhone" class="custom-control-input" id="filterInvalidPhone">
                                    <label class="custom-control-label" for="filterInvalidPhone">{{ __('Invalid phone (no +6)') }}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" wire:click="clearFilters" class="btn btn-outline-secondary btn-sm">
                                    <em class="icon ni ni-reload"></em> {{ __('Clear Filters') }}
                                </button>
                            </div>
                        </div>

                        <!-- Bulk Actions -->
                        <div class="alert alert-light mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <span>
                                    @if(count($selectedPickups) > 0)
                                        {{ __(':count item(s) selected', ['count' => count($selectedPickups)]) }}
                                    @else
                                        {{ __('Select items for bulk action') }}
                                    @endif
                                </span>
                                <div>
                                    <button type="button" class="btn btn-primary btn-sm" {{ count($selectedPickups) == 0 ? 'disabled' : '' }}
                                            onclick="if(confirm('Send Email to {{ count($selectedPickups) }} selected items?')) { @this.bulkSendEmail() }">
                                        <em class="icon ni ni-mail"></em> {{ __('Bulk Send Email') }}
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" {{ count($selectedPickups) == 0 ? 'disabled' : '' }}
                                            onclick="if(confirm('Send WhatsApp to {{ count($selectedPickups) }} selected items?')) { @this.bulkSendWhatsApp() }">
                                        <em class="icon ni ni-whatsapp"></em> {{ __('Bulk Send WhatsApp') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="my-3">
                            {{ $pickups->links() }}
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-dark text-white">
                                <tr>
                                    <th style="width: 40px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" wire:model="selectAll" class="custom-control-input" id="selectAll">
                                            <label class="custom-control-label" for="selectAll"></label>
                                        </div>
                                    </th>
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
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" wire:model="selectedPickups" value="{{ $pickup->id }}" class="custom-control-input" id="pickup-{{ $pickup->id }}">
                                                <label class="custom-control-label" for="pickup-{{ $pickup->id }}"></label>
                                            </div>
                                        </td>
                                        <td>{{ $pickup?->user?->name }}</td>
                                        <td>
                                            @php
                                                $phone = $pickup?->user?->phone_number;
                                                $isInvalid = !$phone || !str_starts_with($phone, '+6');
                                            @endphp
                                            <span class="{{ $isInvalid ? 'text-danger' : '' }}">{{ $phone ?: '-' }}</span>
                                            @if($pickup->user)
                                                <button type="button" class="btn btn-xs btn-outline-primary ml-1" wire:click="editPhoneNumber({{ $pickup->id }})" title="{{ __('Edit') }}">
                                                    <em class="icon ni ni-edit"></em>
                                                </button>
                                            @endif
                                        </td>
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

    <!-- Edit Phone Number Modal -->
    <div class="modal fade" id="editPhoneModal" tabindex="-1" role="dialog" aria-labelledby="editPhoneModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPhoneModalLabel">{{ __('Edit Phone Number') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">{{ __('Phone Number') }}</label>
                        <input type="text" wire:model.defer="editingPhoneNumber" class="form-control" placeholder="+60123456789">
                        <small class="text-muted">{{ __('Must start with +6 (e.g. +60123456789)') }}</small>
                        @error('editingPhoneNumber') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="updatePhoneNumber">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('after-scripts')
<script>
    // Edit Phone Modal events
    window.addEventListener('show-edit-phone-modal', function() {
        $('#editPhoneModal').modal('show');
    });
    window.addEventListener('hide-edit-phone-modal', function() {
        $('#editPhoneModal').modal('hide');
    });

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
