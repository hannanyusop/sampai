@extends('backend.layouts.app')

@section('title', __('Scan'))

@section('content')
    <div class="nk-content-wrap">
        @livewire('backend.parcel.parcel-pickup')
    </div>
@endsection
@push('after-scripts')
@endpush
