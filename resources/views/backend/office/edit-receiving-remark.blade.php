@extends('backend.layouts.app')

@section('title', __('Edit Receiving Remark'))

@section('content')
    <div class="nk-block-head nk-block-head-lg wide-sm">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><a class="back-to" href="{{ route('admin.office.index') }}"><em class="icon ni ni-arrow-left"></em><span>Office List</span></a></div>
            <h2 class="nk-block-title fw-normal">Edit Receiving Remark</h2>
            <div class="nk-block-des">
                <p class="lead"></p>
            </div>
        </div>
    </div>

    @livewire('office.receiving-remark', ['office' => $office])
@endsection
