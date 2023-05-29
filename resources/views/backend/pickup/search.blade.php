@extends('backend.layouts.app')

@section('title', __('Search'))

@section('content')
    <div class="nk-content-wrap">
        @livewire('backend.pickup.pickup-search')
    </div>
@endsection
@push('after-scripts')
@endpush
