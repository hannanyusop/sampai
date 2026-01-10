@extends('frontend.layouts.app')
@section('title', __('My Parcels'))

@section('content')
    @livewire('parcel.parcel-index')
@endsection
