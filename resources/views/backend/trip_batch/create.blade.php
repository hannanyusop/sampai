@extends('backend.layouts.app')

@section('title', __('Trip List'))

@section('content')
    @livewire('backend.trip-batch.trip-batch-create')
@endsection
@push('after-scripts')
    <script type="text/javascript">
        "use strict";
    </script>
@endpush
