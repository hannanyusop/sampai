@extends('frontend.layouts.app')

@section('title', __('Pickup List'))


@section('content')


    <div class="nk-content-wrap">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item text-lg"><a href="#">Parcel Management</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.user.pickup.index') }}">Pickup List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Parcel</li>
            </ol>
        </nav>

        @foreach($pickups->parcels as $parcel)
        <h6>Parcel {{ $loop->iteration }}</h6>
          <?php $count = 1; ?>
        <div class="row mb-3">
            <div class="col-xl-12">
                @include('components.parcel.summary-box')
            </div><!-- .col -->
        </div>
        @endforeach
    </div>

{{--    <div id="embedTrack"></div>--}}
{{--    <script src="//www.tracking.my/track-button.js"></script>--}}
{{--    <script>--}}
{{--        TrackButton.embed({--}}
{{--            selector: "#embedTrack",--}}
{{--            tracking_no: "{{ $parcel->tracking_no }}",--}}
{{--        });--}}
{{--    </script>--}}
@endsection
