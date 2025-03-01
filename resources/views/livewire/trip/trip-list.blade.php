<div class="card card-bordered">
    <div class="card-inner p-0 border-top">

        <table class="table table-orders">
            <thead class="tb-odr-head">
            <tr class="tb-odr-item">
                <th class="tb-odr-info">
                    <span class="tb-odr-id">Trip No.</span>
                    <span class="tb-odr-date d-none d-md-inline-block">Date</span>
                </th>
                <th class="tb-odr-amount">
                    <span class="tb-odr-total">Destination</span>
                    <span class="tb-odr-status d-none d-md-inline-block">Status</span>
                </th>
                <th class="tb-odr-amount">
                    <span class="tb-odr-total">Current Location</span>
                    <span class="tb-odr-status d-none d-md-inline-block">Total Parcel</span>
                </th>
                <th class="tb-odr-action">&nbsp;</th>
            </tr>
            </thead>
            <tbody class="tb-odr-body">
            @foreach($trips as $trip)

                <tr class="tb-odr-item">
                    <td class="tb-odr-info">
                        <span class="tb-odr-id"><a href="#">{{ $trip->code }}</a></span>
                        <span class="tb-odr-date">{{ $trip->date }}</span>
                    </td>
                    <td class="tb-odr-amount">
                                        <span class="tb-odr-total">
                                            <span class="amount">{{ $trip->destination->code }}</span>
                                        </span>
                        <span class="tb-odr-status">{!! $trip->status_badge !!}</span>
                    </td>
                    <td class="tb-odr-amount">
                                         <span class="tb-odr-total">
                                            <span class="amount">

                                            </span>
                                        </span>
                        <span class="tb-odr-status">{{ $trip->parcels_count }} Parcel(s)
                                        </span>
                    </td>
                    <td class="tb-odr-action">
                        <div class="dropdown">
                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-md">
                                <ul class="link-list-plain">
                                    <li><a href="{{ route('admin.trip.view', $trip->id) }}">View</a></li>

                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="m-2">
        {{ $trips->links() }}
    </div>
</div>
