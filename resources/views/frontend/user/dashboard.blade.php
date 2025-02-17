@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

{{--@php--}}
{{--$dataUser = dataUserDashboard();--}}
{{--@endphp--}}

@section('content')
    <div class="nk-content-wrap">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h2 class="nk-block-title fw-normal">Welcome, {{ auth()->user()->name }}</h2>
                    <div class="nk-block-des">
                        <p>Welcome to our dashboard. Manage your account and your subscriptions.</p>
                    </div>
                </div>
            </div>
        </div><!-- .nk-block-head -->

    </div>

    <div class="modal fade" tabindex="-1" id="modalAlert">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                        <h4 class="nk-modal-title">Congratulations!</h4>
                        <div class="nk-modal-text">
                            <div class="caption-text">You’ve successfully bought <strong>0.5968</strong> BTC for <strong>200.00</strong> USD </div>
                            <span class="sub-text-sm">Learn when you reciveve bitcoin in your wallet. <a href="#"> Click here</a>
                </span>
                        </div>
                        <div class="nk-modal-action">
                            <a href="" class="btn btn-lg btn-mw btn-primary" data-bs-dismiss="modal">View</a>
                            <a href="#" class="btn btn-lg btn-mw btn-primary" data-bs-dismiss="modal">Close</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

{{--        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAlert"></button>--}}

        @endsection
@push('after-scripts')
    <script>
        // $(document).ready(function(){
        //     $('#modalAlert').modal('show');
        // });
    </script>
@endpush
