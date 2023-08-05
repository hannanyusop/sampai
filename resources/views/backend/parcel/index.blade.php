@extends('backend.layouts.app')

@section('title', __('Parcel List'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')

    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="title nk-block-title">Parcel List / Form Response</h4>
            <div class="nk-block-des">
                <p>Parcel List/Form Response where you can search all registered parcel by customer.</p>
            </div>
        </div>
    </div>
    @livewire('backend.parcel.parcel-list')
@endsection
