@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Ranged Sales Report</h3>
                        </div>

                    </div>
                </div>

                @livewire('backend.report.ranged-sales')

            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script type="text/javascript">

    </script>
@endpush
