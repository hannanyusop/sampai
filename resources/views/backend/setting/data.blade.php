@extends('backend.layouts.app')

@section('title', __('Manage Data'))

@section('content')
    @livewire('setting.manage-data')
@endsection
@push('after-scripts')

@endpush
