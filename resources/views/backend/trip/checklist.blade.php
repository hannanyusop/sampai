@extends('backend.layouts.app')

@section('title', __('Trip Checklist By Pickup Point'))

@section('content')
    @livewire('backend.trip.trip-checklist', ['trip' => $trip])
@endsection
@push('after-scripts')

@endpush
