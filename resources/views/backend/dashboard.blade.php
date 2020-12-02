@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-6">
                    <div class="row g-gs">
                        <div class="col-lg-6 col-xxl-12">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-2">
                                        <div class="card-title">
                                            <h6 class="title">Parcel Receive</h6>
                                            <p>Parcel received in last 30 days.</p>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Revenue from subscription"></em>
                                        </div>
                                    </div>
                                    <div class="align-end gy-3 gx-5 flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                        <div class="nk-sale-data-group flex-md-nowrap g-4">
                                            <div class="nk-sale-data">
                                                <span class="amount">14,299.59 <span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>16.93%</span></span>
                                                <span class="sub-title">This Month</span>
                                            </div>
                                            <div class="nk-sale-data">
                                                <span class="amount">7,299.59 <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>4.26%</span></span>
                                                <span class="sub-title">This Week</span>
                                            </div>
                                        </div>
                                        <div class="nk-sales-ck sales-revenue">
                                            <canvas class="sales-bar-chart" id="salesRevenue"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-12">
                            <div class="row g-gs">
                                <div class="col-sm-6 col-lg-12 col-xxl-6">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-2">
                                                <div class="card-title">
                                                    <h6 class="title">In Process Parcel</h6>
                                                </div>
                                                <div class="card-tools">
                                                    <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total active subscription"></em>
                                                </div>
                                            </div>
                                            <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                <div class="nk-sale-data">
                                                    <span class="amount">9.69K</span>
                                                    <span class="sub-title"><span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>1.93%</span>since last month</span>
                                                </div>
                                                <div class="nk-sales-ck">
                                                    <canvas class="sales-bar-chart" id="activeSubscription"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->
                                <div class="col-sm-6 col-lg-12 col-xxl-6">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-2">
                                                <div class="card-title">
                                                    <h6 class="title">Avg Parcel Received</h6>
                                                </div>
                                                <div class="card-tools">
                                                    <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Daily Avg. subscription"></em>
                                                </div>
                                            </div>
                                            <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                <div class="nk-sale-data">
                                                    <span class="amount">346.2</span>
                                                    <span class="sub-title"><span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>2.45%</span>since last week</span>
                                                </div>
                                                <div class="nk-sales-ck">
                                                    <canvas class="sales-bar-chart" id="totalSubscription"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->
                            </div><!-- .row -->
                        </div><!-- .col -->
                    </div>
                </div><!-- .col -->
            </div>
            <div class="row g-gs">
                <div class="col-xxl-8">
                    <div class="card card-bordered card-full">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title"><span class="mr-2">Transaction</span> <a href="#" class="link d-none d-sm-inline">See History</a></h6>
                                </div>
                                <div class="card-tools">
                                    <ul class="card-tools-nav">
                                        <li><a href="#"><span>Paid</span></a></li>
                                        <li><a href="#"><span>Pending</span></a></li>
                                        <li class="active"><a href="#"><span>All</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-inner p-0 border-top">
                            <div class="nk-tb-list nk-tb-orders">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col"><span>Trip No.</span></div>
                                    <div class="nk-tb-col tb-col-sm"><span>Destination</span></div>
                                    <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                    <div class="nk-tb-col"><span>Amount</span></div>
                                    <div class="nk-tb-col"><span class="d-none d-sm-inline">Status</span></div>
                                    <div class="nk-tb-col"><span class="d-none d-sm-inline">Current Location</span></div>
                                    <div class="nk-tb-col"><span>&nbsp;</span></div>
                                </div>
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <span class="tb-lead"><a href="#">#LES-201111-1</a></span>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <div class="user-card">
                                            <div class="user-name">
                                                <span class="tb-lead">Lestari</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span class="tb-sub">11/11/2020</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="tb-sub tb-amount">23 Parcels</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge badge-dot badge-dot-xs badge-success">In Transit</span>
                                    </div>
                                    <div class="nk-tb-col">Runner</div>
                                    <div class="nk-tb-col nk-tb-col-action">
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                                <ul class="link-list-plain">
                                                    <li><a href="#">View</a></li>
                                                    <li><a href="#">Invoice</a></li>
                                                    <li><a href="#">Print</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <span class="tb-lead"><a href="#">#FTMK-201111-1</a></span>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <div class="user-card">
                                            <div class="user-name">
                                                <span class="tb-lead">Fakulti Tenknologi Maklumat & Komunikasi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span class="tb-sub">11/11/2020</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="tb-sub tb-amount">1 Parcels</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge badge-dot badge-dot-xs badge-secondary">Open</span>
                                    </div>
                                    <div class="nk-tb-col">Unit Mel</div>
                                    <div class="nk-tb-col nk-tb-col-action">
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-sm">
                                                <ul class="link-list-plain">
                                                    <li><a href="user/admin-trip-view.php">View</a></li>
                                                    <li><a href="user/admin-trip-add-parcel.php">Add Add Parcel</a></li>
                                                    <li><a href="#">Ready To Pick</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-inner-sm border-top text-center d-sm-none">
                            <a href="#" class="btn btn-link btn-block">See History</a>
                        </div>
                    </div><!-- .card -->
                </div>
            </div>
        </div>

    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/js/charts/gd-general.js') }}?ver=1.4.0"></script>
@endpush
