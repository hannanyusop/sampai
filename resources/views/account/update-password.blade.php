@php $extend = (auth()->user()->type == 'user')? 'frontend.layouts.app' :  'backend.layouts.app'; @endphp

@extends($extend)

@section('title', __('My Account'))

@section('content')
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><span>Account Setting</span></div>
            <h2 class="nk-block-title fw-normal">Update Password</h2>
        </div>
    </div>
    @livewire('account.update-password')
@endsection
@push('after-scripts')
@endpush
