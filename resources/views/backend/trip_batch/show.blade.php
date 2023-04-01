@extends('backend.layouts.app')

@section('title', __('Show Trip'))

@section('content')
    @livewire('backend.trip-batch.trip-batch-show', ['tripBatch' => $tripBatch])
@endsection
@push('after-scripts')
    <script type="text/javascript">
        "use strict";
    </script>
@endpush
