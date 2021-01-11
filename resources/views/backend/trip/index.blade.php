@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-8">

                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Trip List</h5>
                            </div>
                            <form action="#" id="trip">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="trip_no">Trip No</label>
                                            <div class="form-control-wrap">
                                                <input id="code" name="code" type="text" class="form-control" placeholder="Ex: LES-11111-1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                @foreach(getTripStatus() as $key => $status)
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="status[]" value="{{ $key }}" id="status_{{ $key }}">
                                                            <label class="custom-control-label" for="status_{{ $key }}">{{ $status }}</label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Drop Point</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                @foreach($dps as $dp)
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="office_id[]" value="{{ $dp->id }}" id="dp_{{ $dp->id }}" checked>
                                                        <label class="custom-control-label" for="dp_{{ $dp->id }}">{{ $dp->code }}</label>
                                                    </div>
                                                </li>
                                                @endforeach

                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

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
                                <tbody class="tb-odr-body" id="data">
                                </tbody>
                            </table>
                        </div>
                    </div><!-- .card -->
                </div>
            </div>
        </div>

    </div>
@endsection
@push('after-scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            function getTrip(){

                var form = $("#trip");
                $.ajax({
                    url:"{{ route('admin.trip.search') }}",
                    type:"GET",
                    data: form.serialize(),
                    success:function (data) {
                        $('#data').html(data);
                    }
                })
            }

            getTrip();

            $("#trip").submit(function( event ) {
                getTrip();
                event.preventDefault();
            });


            $(document).on('click', 'li', function(){

                var value = $(this).text();
                $('#country').val(value);
                $('#data').html("");
            });
        });
    </script>
@endpush
