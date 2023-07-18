@extends('backend.layouts.app')

@section('title', __('Trip Checklist (All)'))

@section('content')
    @livewire('backend.trip.trip-checklist-all', ['tripBatch' => $tripBatch])
@endsection
@push('after-scripts')

@endpush
