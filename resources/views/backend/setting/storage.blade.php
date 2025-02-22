@extends('backend.layouts.app')

@section('title', __('Payment Setting'))

@section('content')
    @livewire('setting.manage-storage')
@endsection
@push('after-scripts')

@endpush
