@extends('frontend.layouts.app')
@section('title', __('Parcel List'))

@section('content')
    <div class="nk-block nk-block-lg">
        @livewire('parcel.parcel-index')
    </div>
@endsection
