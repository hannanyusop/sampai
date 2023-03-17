@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">

        <div class="nk-block">
            @livewire('trip.master-list', ['trip_id' => $trip->id])
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
