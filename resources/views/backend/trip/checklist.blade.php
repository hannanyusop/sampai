@extends('backend.layouts.app')

@section('title', __('Trip Checklist'))

@section('content')
    @livewire('backend.trip.trip-checklist', ['trip' => $trip])
@endsection
@push('after-scripts')

@endpush
