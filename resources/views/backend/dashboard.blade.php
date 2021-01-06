@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-head-sub"><span>Welcome!</span>
                </div>
                <div class="nk-block-between-md g-4">
                    <div class="nk-block-head-content">
                        <h2 class="nk-block-title fw-normal">{{ auth()->user()->name }}</h2>
                        <div class="nk-block-des">
                            <p>Drop Point Officer (Office : {{ auth()->user()->office() }})<br>
                            Position : {{ auth()->user()->can('staff.manager')? "Manager" : "Staff" }}</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools gx-3">
                            <li><a href="{{ route('admin.parcel.scan') }}" class="btn btn-primary"><span>Scan User QR</span> <em class="icon ni ni-qr"></em></a></li>
                            <li><a href="{{ route('admin.trip.receive') }}" class="btn btn-success"><span>Receive Parcel</span> <em class="icon ni ni-gift"></em></a></li>
                            <li class="opt-menu-md dropdown">
                                <a href="#" class="btn btn-white btn-light btn-icon" data-toggle="dropdown"><em class="icon ni ni-setting"></em></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="link-list-opt no-bdr">
                                        @if(auth()->user()->can('staff.manager'))
                                        <li><a href="{{ route('admin.office.edit') }}"><em class="icon ni ni-setting"></em><span>Manage Office</span></a></li>
                                        @endif
                                        <li><a href="{{ route('admin.office.staff') }}"><em class="icon ni ni-user-list"></em><span>Staff List</span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->

            <div class="nk-block">
                <div class="row g-2">
                    <div class="col-sm-3 col-md-4">
                        <div class="card bg-light">
                            <div class="nk-wgw sm">
                                <a class="nk-wgw-inner" href="#">
                                    <div class="nk-wgw-name">
                                        <div class="nk-wgw-icon">
                                            <em class="icon ni ni-search"></em>
                                        </div>
                                        <h5 class="nk-wgw-title title">OTW</h5>
                                    </div>
                                    <div class="nk-wgw-balance">
                                        <div class="amount">{{ $data['otw'] }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div><!-- .col -->
                    <div class="col-sm-3 col-md-4">
                        <div class="card bg-light">
                            <div class="nk-wgw sm">
                                <a class="nk-wgw-inner" href="#">
                                    <div class="nk-wgw-name">
                                        <div class="nk-wgw-icon">
                                            <em class="icon ni ni-truck"></em>
                                        </div>
                                        <h5 class="nk-wgw-title title">Ready To Collect</h5>
                                    </div>
                                    <div class="nk-wgw-balance">
                                        <div class="amount">{{ $data['ready'] }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-4">
                        <div class="card bg-light">
                            <div class="nk-wgw sm">
                                <a class="nk-wgw-inner" href="#">
                                    <div class="nk-wgw-name">
                                        <div class="nk-wgw-icon">
                                            <em class="icon ni ni-text-rich"></em>
                                        </div>
                                        <h5 class="nk-wgw-title title">Delivered</h5>
                                    </div>
                                    <div class="nk-wgw-balance">
                                        <div class="amount">{{ $data['delivered'] }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-6">
                        <div class="card bg-light">
                            <div class="nk-wgw sm">
                                <a class="nk-wgw-inner" href="#">
                                    <div class="nk-wgw-name">
                                        <div class="nk-wgw-icon">
                                            <em class="icon ni ni-text-rich"></em>
                                        </div>
                                        <h5 class="nk-wgw-title title">Returned</h5>
                                    </div>
                                    <div class="nk-wgw-balance">
                                        <div class="amount">{{ $data['return'] }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-6">
                        <div class="card bg-light">
                            <div class="nk-wgw sm">
                                <a class="nk-wgw-inner" href="#">
                                    <div class="nk-wgw-name">
                                        <div class="nk-wgw-icon">
                                            <em class="icon ni ni-check-thick"></em>
                                        </div>
                                        <h5 class="nk-wgw-title title">All</h5>
                                    </div>
                                    <div class="nk-wgw-balance">
                                        <div class="amount">{{ $data['all'] }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div><!-- .col -->
                </div><!-- .row -->
            </div>

            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-xxl-8">

                        <div class="card card-bordered">
                            <div class="card-inner p-0 border-top">

                                <table class="table table-orders">
                                    <thead class="tb-odr-head">
                                    <tr class="tb-odr-item">
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-id">Trip No.</span>
                                            <span class="tb-odr-date d-none d-md-inline-block">Date</span>
                                        </th>
                                        <th class="tb-odr-amount">
                                            <span class="tb-odr-total">Destination</span>
                                            <span class="tb-odr-status d-none d-md-inline-block">Status</span>
                                        </th>
                                        <th class="tb-odr-amount">
                                            <span class="tb-odr-total">Current Location</span>
                                            <span class="tb-odr-status d-none d-md-inline-block">Total Parcel</span>
                                        </th>
                                        <th class="tb-odr-action">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tb-odr-body">
                                    @foreach($trips as $trip)

                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-id"><a href="#">{{ $trip->code }}</a></span>
                                                <span class="tb-odr-date">{{ $trip->date }}</span>
                                            </td>
                                            <td class="tb-odr-amount">
                                        <span class="tb-odr-total">
                                            <span class="amount">{{ $trip->destination->code }}</span>
                                        </span>
                                                <span class="tb-odr-status">{!! getTripStatusBadge($trip->status) !!}</span>
                                            </td>
                                            <td class="tb-odr-amount">
                                         <span class="tb-odr-total">
                                            <span class="amount">Runner</span>
                                        </span>
                                                <span class="tb-odr-status">{{ $trip->parcels->count() }} Parcel(s)
                                        </span>
                                            </td>
                                            <td class="tb-odr-action">
                                                <div class="dropdown">
                                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-md">
                                                        <ul class="link-list-plain">
                                                            <li><a href="{{ route('admin.trip.view', $trip->id) }}">View</a></li>

                                                            @if(auth()->user()->can('staff.distributor'))
                                                                @if($trip->status == 0)
                                                                    <li><a href="{{ route('admin.trip.addParcel', $trip->id)  }}">Add Parcel</a></li>
                                                                    <li><a href="{{ route('admin.trip.close', $trip->id) }}" onclick="return confirm('Are you sure want to close this trip?')">Closed</a></li>
                                                                @endif
                                                            @endif
                                                            @if(auth()->user()->can('staff.runner'))
                                                                @if($trip->status == 1)
                                                                    <li><a href="{{ route('admin.trip.picked', $trip->id) }}">Pick</a></li>
                                                                @elseif($trip->status == 2 && $trip->runner_id == auth()->user()->id)
                                                                    <li><a href="{{ route('admin.trip.transferCode', $trip->id) }}">Transfer Trip</a></li>
                                                                @endif
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@push('after-scripts')
    <script type="text/javascript">
        "use strict";

        !function (NioApp, $) {
            "use strict"; //////// for developer - User Balance ////////
            // Avilable options to pass from outside
            // labels: array,
            // legend: false - boolean,
            // dataUnit: string, (Used in tooltip or other section for display)
            // datasets: [{label : string, color: string (color code with # or other format), data: array}]

            var profileBalance = {
                labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30"],
                dataUnit: 'BTC',
                lineTension: 0.15,
                datasets: [{
                    label: "Total Received",
                    color: "#798bff",
                    background: NioApp.hexRGB('#798bff', .3),
                    data: [111, 80, 125, 75, 95, 75, 90, 111, 80, 125, 75, 95, 75, 90, 111, 80, 125, 75, 95, 75, 90, 111, 80, 125, 75, 95, 75, 90, 75, 90]
                }]
            };

            function lineProfileBalance(selector, set_data) {
                var $selector = selector ? $(selector) : $('.profile-balance-chart');
                $selector.each(function () {
                    var $self = $(this),
                        _self_id = $self.attr('id'),
                        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;

                    var selectCanvas = document.getElementById(_self_id).getContext("2d");
                    var chart_data = [];

                    for (var i = 0; i < _get_data.datasets.length; i++) {
                        chart_data.push({
                            label: _get_data.datasets[i].label,
                            tension: _get_data.lineTension,
                            backgroundColor: _get_data.datasets[i].background,
                            borderWidth: 2,
                            borderColor: _get_data.datasets[i].color,
                            pointBorderColor: "transparent",
                            pointBackgroundColor: "transparent",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: _get_data.datasets[i].color,
                            pointBorderWidth: 2,
                            pointHoverRadius: 3,
                            pointHoverBorderWidth: 2,
                            pointRadius: 3,
                            pointHitRadius: 3,
                            data: _get_data.datasets[i].data
                        });
                    }

                    var chart = new Chart(selectCanvas, {
                        type: 'line',
                        data: {
                            labels: _get_data.labels,
                            datasets: chart_data
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            maintainAspectRatio: false,
                            tooltips: {
                                enabled: true,
                                callbacks: {
                                    title: function title(tooltipItem, data) {
                                        return false;
                                    },
                                    label: function label(tooltipItem, data) {
                                        return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                                    }
                                },
                                backgroundColor: '#eff6ff',
                                titleFontSize: 11,
                                titleFontColor: '#6783b8',
                                titleMarginBottom: 4,
                                bodyFontColor: '#9eaecf',
                                bodyFontSize: 10,
                                bodySpacing: 3,
                                yPadding: 8,
                                xPadding: 8,
                                footerMarginTop: 0,
                                displayColors: false
                            },
                            scales: {
                                yAxes: [{
                                    display: false
                                }],
                                xAxes: [{
                                    display: false
                                }]
                            }
                        }
                    });
                });
            } // init chart


            NioApp.coms.docReady.push(function () {
                lineProfileBalance();
            });
            var orderOverview = {
                labels: ["19 Dec", "20 Dec", "21 Dec", "22 Dec", "23 Dec", "24 Dec", "25 Dec", "26 Dec", "27 Dec", "28 Dec", "29 Dec", "30 Dec", "31 Dec", "01 Jan"],
                dataUnit: 'USD',
                datasets: [{
                    label: "Buy Orders",
                    color: "#8feac5",
                    data: [1740, 2500, 1820, 1200, 1600, 2500, 1820, 1200, 1700, 1820, 1400, 1600, 1930, 2100]
                }, {
                    label: "Sell Orders",
                    color: "#9cabff",
                    data: [2420, 1820, 3000, 5000, 2450, 1820, 2700, 5000, 2400, 2600, 4000, 2380, 2120, 1700]
                }]
            };

            function orderOverviewChart(selector, set_data) {
                var $selector = selector ? $(selector) : $('.order-overview-chart');
                $selector.each(function () {
                    var $self = $(this),
                        _self_id = $self.attr('id'),
                        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
                        _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

                    var selectCanvas = document.getElementById(_self_id).getContext("2d");
                    var chart_data = [];

                    for (var i = 0; i < _get_data.datasets.length; i++) {
                        chart_data.push({
                            label: _get_data.datasets[i].label,
                            data: _get_data.datasets[i].data,
                            // Styles
                            backgroundColor: _get_data.datasets[i].color,
                            borderWidth: 2,
                            borderColor: 'transparent',
                            hoverBorderColor: 'transparent',
                            borderSkipped: 'bottom',
                            barPercentage: .8,
                            categoryPercentage: .6
                        });
                    }

                    var chart = new Chart(selectCanvas, {
                        type: 'bar',
                        data: {
                            labels: _get_data.labels,
                            datasets: chart_data
                        },
                        options: {
                            legend: {
                                display: _get_data.legend ? _get_data.legend : false,
                                labels: {
                                    boxWidth: 30,
                                    padding: 20,
                                    fontColor: '#6783b8'
                                }
                            },
                            maintainAspectRatio: false,
                            tooltips: {
                                enabled: true,
                                callbacks: {
                                    title: function title(tooltipItem, data) {
                                        return data.datasets[tooltipItem[0].datasetIndex].label;
                                    },
                                    label: function label(tooltipItem, data) {
                                        return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                                    }
                                },
                                backgroundColor: '#eff6ff',
                                titleFontSize: 13,
                                titleFontColor: '#6783b8',
                                titleMarginBottom: 6,
                                bodyFontColor: '#9eaecf',
                                bodyFontSize: 12,
                                bodySpacing: 4,
                                yPadding: 10,
                                xPadding: 10,
                                footerMarginTop: 0,
                                displayColors: false
                            },
                            scales: {
                                yAxes: [{
                                    display: true,
                                    stacked: _get_data.stacked ? _get_data.stacked : false,
                                    ticks: {
                                        beginAtZero: true,
                                        fontSize: 11,
                                        fontColor: '#9eaecf',
                                        padding: 10,
                                        callback: function callback(value, index, values) {
                                            return '$ ' + value;
                                        },
                                        min: 100,
                                        max: 5000,
                                        stepSize: 1200
                                    },
                                    gridLines: {
                                        color: "#e5ecf8",
                                        tickMarkLength: 0,
                                        zeroLineColor: '#e5ecf8'
                                    }
                                }],
                                xAxes: [{
                                    display: true,
                                    stacked: _get_data.stacked ? _get_data.stacked : false,
                                    ticks: {
                                        fontSize: 9,
                                        fontColor: '#9eaecf',
                                        source: 'auto',
                                        padding: 10
                                    },
                                    gridLines: {
                                        color: "transparent",
                                        tickMarkLength: 0,
                                        zeroLineColor: 'transparent'
                                    }
                                }]
                            }
                        }
                    });
                });
            } // init chart


            NioApp.coms.docReady.push(function () {
                orderOverviewChart();
            });
            var userActivity = {
                labels: ["01 Nov", "02 Nov", "03 Nov", "04 Nov", "05 Nov", "06 Nov", "07 Nov", "08 Nov", "09 Nov", "10 Nov", "11 Nov", "12 Nov", "13 Nov", "14 Nov", "15 Nov", "16 Nov", "17 Nov", "18 Nov", "19 Nov", "20 Nov", "21 Nov"],
                dataUnit: 'USD',
                stacked: true,
                datasets: [{
                    label: "Direct Join",
                    color: "#9cabff",
                    data: [110, 80, 125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90]
                }, {
                    label: "Referral Join",
                    color: "#ccd4ff",
                    data: [125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90, 75, 90]
                }]
            };

            function userActivityChart(selector, set_data) {
                var $selector = selector ? $(selector) : $('.usera-activity-chart');
                $selector.each(function () {
                    var $self = $(this),
                        _self_id = $self.attr('id'),
                        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
                        _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

                    var selectCanvas = document.getElementById(_self_id).getContext("2d");
                    var chart_data = [];

                    for (var i = 0; i < _get_data.datasets.length; i++) {
                        chart_data.push({
                            label: _get_data.datasets[i].label,
                            data: _get_data.datasets[i].data,
                            // Styles
                            backgroundColor: _get_data.datasets[i].color,
                            borderWidth: 2,
                            borderColor: 'transparent',
                            hoverBorderColor: 'transparent',
                            borderSkipped: 'bottom',
                            barPercentage: .7,
                            categoryPercentage: .7
                        });
                    }

                    var chart = new Chart(selectCanvas, {
                        type: 'bar',
                        data: {
                            labels: _get_data.labels,
                            datasets: chart_data
                        },
                        options: {
                            legend: {
                                display: _get_data.legend ? _get_data.legend : false,
                                labels: {
                                    boxWidth: 30,
                                    padding: 20,
                                    fontColor: '#6783b8'
                                }
                            },
                            maintainAspectRatio: false,
                            tooltips: {
                                enabled: true,
                                callbacks: {
                                    title: function title(tooltipItem, data) {
                                        return data.datasets[tooltipItem[0].datasetIndex].label;
                                    },
                                    label: function label(tooltipItem, data) {
                                        return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                                    }
                                },
                                backgroundColor: '#eff6ff',
                                titleFontSize: 13,
                                titleFontColor: '#6783b8',
                                titleMarginBottom: 6,
                                bodyFontColor: '#9eaecf',
                                bodyFontSize: 12,
                                bodySpacing: 4,
                                yPadding: 10,
                                xPadding: 10,
                                footerMarginTop: 0,
                                displayColors: false
                            },
                            scales: {
                                yAxes: [{
                                    display: false,
                                    stacked: _get_data.stacked ? _get_data.stacked : false,
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }],
                                xAxes: [{
                                    display: false,
                                    stacked: _get_data.stacked ? _get_data.stacked : false
                                }]
                            }
                        }
                    });
                });
            } // init chart


            NioApp.coms.docReady.push(function () {
                userActivityChart();
            });
            var coinOverview = {
                labels: ["Bitcoin", "Ethereum", "NioCoin", "Litecoin", "Bitcoin"],
                stacked: true,
                datasets: [{
                    label: "Buy Orders",
                    color: ["#f98c45", "#9cabff", "#8feac5", "#6b79c8", "#79f1dc"],
                    data: [1740, 2500, 1820, 1200, 1600, 2500]
                }, {
                    label: "Sell Orders",
                    color: [NioApp.hexRGB('#f98c45', .2), NioApp.hexRGB('#9cabff', .4), NioApp.hexRGB('#8feac5', .4), NioApp.hexRGB('#6b79c8', .4), NioApp.hexRGB('#79f1dc', .4)],
                    data: [2420, 1820, 3000, 5000, 2450, 1820]
                }]
            };

            function coinOverviewChart(selector, set_data) {
                var $selector = selector ? $(selector) : $('.coin-overview-chart');
                $selector.each(function () {
                    var $self = $(this),
                        _self_id = $self.attr('id'),
                        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
                        _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

                    var selectCanvas = document.getElementById(_self_id).getContext("2d");
                    var chart_data = [];

                    for (var i = 0; i < _get_data.datasets.length; i++) {
                        chart_data.push({
                            label: _get_data.datasets[i].label,
                            data: _get_data.datasets[i].data,
                            // Styles
                            backgroundColor: _get_data.datasets[i].color,
                            borderWidth: 2,
                            borderColor: 'transparent',
                            hoverBorderColor: 'transparent',
                            borderSkipped: 'bottom',
                            barThickness: '8',
                            categoryPercentage: 0.5,
                            barPercentage: 1.0
                        });
                    }

                    var chart = new Chart(selectCanvas, {
                        type: 'horizontalBar',
                        data: {
                            labels: _get_data.labels,
                            datasets: chart_data
                        },
                        options: {
                            legend: {
                                display: _get_data.legend ? _get_data.legend : false,
                                labels: {
                                    boxWidth: 30,
                                    padding: 20,
                                    fontColor: '#6783b8'
                                }
                            },
                            maintainAspectRatio: false,
                            tooltips: {
                                enabled: true,
                                callbacks: {
                                    title: function title(tooltipItem, data) {
                                        return data['labels'][tooltipItem[0]['index']];
                                    },
                                    label: function label(tooltipItem, data) {
                                        return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + data.datasets[tooltipItem.datasetIndex]['label'];
                                    }
                                },
                                backgroundColor: '#eff6ff',
                                titleFontSize: 13,
                                titleFontColor: '#6783b8',
                                titleMarginBottom: 6,
                                bodyFontColor: '#9eaecf',
                                bodyFontSize: 12,
                                bodySpacing: 4,
                                yPadding: 10,
                                xPadding: 10,
                                footerMarginTop: 0,
                                displayColors: false
                            },
                            scales: {
                                yAxes: [{
                                    display: false,
                                    stacked: _get_data.stacked ? _get_data.stacked : false,
                                    ticks: {
                                        beginAtZero: true,
                                        padding: 0
                                    },
                                    gridLines: {
                                        color: "#e5ecf8",
                                        tickMarkLength: 0,
                                        zeroLineColor: '#e5ecf8'
                                    }
                                }],
                                xAxes: [{
                                    display: false,
                                    stacked: _get_data.stacked ? _get_data.stacked : false,
                                    ticks: {
                                        fontSize: 9,
                                        fontColor: '#9eaecf',
                                        source: 'auto',
                                        padding: 0
                                    },
                                    gridLines: {
                                        color: "transparent",
                                        tickMarkLength: 0,
                                        zeroLineColor: 'transparent'
                                    }
                                }]
                            }
                        }
                    });
                });
            } // init chart


            NioApp.coms.docReady.push(function () {
                coinOverviewChart();
            });
            var salesRevenue = {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                dataUnit: 'USD',
                stacked: true,
                datasets: [{
                    label: "Sales Revenue",
                    color: ["#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#6576ff"],
                    data: [11000, 8000, 12500, 5500, 9500, 14299, 11000, 8000, 12500, 5500, 9500, 14299]
                }]
            };
            var activeSubscription = {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                dataUnit: 'USD',
                stacked: true,
                datasets: [{
                    label: "Active User",
                    color: ["#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#6576ff"],
                    data: [8200, 7800, 9500, 5500, 9200, 9690]
                }]
            };
            var totalSubscription = {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                dataUnit: 'USD',
                stacked: true,
                datasets: [{
                    label: "Active User",
                    color: ["#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#aea1ff"],
                    data: [8200, 7800, 9500, 5500, 9200, 9690]
                }]
            };

            function salesBarChart(selector, set_data) {
                var $selector = selector ? $(selector) : $('.sales-bar-chart');
                $selector.each(function () {
                    var $self = $(this),
                        _self_id = $self.attr('id'),
                        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
                        _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

                    var selectCanvas = document.getElementById(_self_id).getContext("2d");
                    var chart_data = [];

                    for (var i = 0; i < _get_data.datasets.length; i++) {
                        chart_data.push({
                            label: _get_data.datasets[i].label,
                            data: _get_data.datasets[i].data,
                            // Styles
                            backgroundColor: _get_data.datasets[i].color,
                            borderWidth: 2,
                            borderColor: 'transparent',
                            hoverBorderColor: 'transparent',
                            borderSkipped: 'bottom',
                            barPercentage: .7,
                            categoryPercentage: .7
                        });
                    }

                    var chart = new Chart(selectCanvas, {
                        type: 'bar',
                        data: {
                            labels: _get_data.labels,
                            datasets: chart_data
                        },
                        options: {
                            legend: {
                                display: _get_data.legend ? _get_data.legend : false,
                                labels: {
                                    boxWidth: 30,
                                    padding: 20,
                                    fontColor: '#6783b8'
                                }
                            },
                            maintainAspectRatio: false,
                            tooltips: {
                                enabled: true,
                                callbacks: {
                                    title: function title(tooltipItem, data) {
                                        return false;
                                    },
                                    label: function label(tooltipItem, data) {
                                        return data['labels'][tooltipItem['index']] + ' ' + data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']];
                                    }
                                },
                                backgroundColor: '#eff6ff',
                                titleFontSize: 11,
                                titleFontColor: '#6783b8',
                                titleMarginBottom: 4,
                                bodyFontColor: '#9eaecf',
                                bodyFontSize: 10,
                                bodySpacing: 3,
                                yPadding: 8,
                                xPadding: 8,
                                footerMarginTop: 0,
                                displayColors: false
                            },
                            scales: {
                                yAxes: [{
                                    display: false,
                                    stacked: _get_data.stacked ? _get_data.stacked : false,
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }],
                                xAxes: [{
                                    display: false,
                                    stacked: _get_data.stacked ? _get_data.stacked : false
                                }]
                            }
                        }
                    });
                });
            } // init chart


            NioApp.coms.docReady.push(function () {
                salesBarChart();
            });
            var salesOverview = {
                labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30"],
                dataUnit: 'BTC',
                lineTension: 0.1,
                datasets: [{
                    label: "Sales Overview",
                    color: "#798bff",
                    background: NioApp.hexRGB('#798bff', .3),
                    data: [8200, 7800, 9500, 5500, 9200, 9690, 8200, 7800, 9500, 5500, 9200, 9690, 8200, 7800, 9500, 5500, 9200, 9690, 8200, 7800, 9500, 5500, 9200, 9690, 8200, 7800, 9500, 5500, 9200, 9690]
                }]
            };

            function lineSalesOverview(selector, set_data) {
                var $selector = selector ? $(selector) : $('.sales-overview-chart');
                $selector.each(function () {
                    var $self = $(this),
                        _self_id = $self.attr('id'),
                        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;

                    var selectCanvas = document.getElementById(_self_id).getContext("2d");
                    var chart_data = [];

                    for (var i = 0; i < _get_data.datasets.length; i++) {
                        chart_data.push({
                            label: _get_data.datasets[i].label,
                            tension: _get_data.lineTension,
                            backgroundColor: _get_data.datasets[i].background,
                            borderWidth: 2,
                            borderColor: _get_data.datasets[i].color,
                            pointBorderColor: "transparent",
                            pointBackgroundColor: "transparent",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: _get_data.datasets[i].color,
                            pointBorderWidth: 2,
                            pointHoverRadius: 3,
                            pointHoverBorderWidth: 2,
                            pointRadius: 3,
                            pointHitRadius: 3,
                            data: _get_data.datasets[i].data
                        });
                    }

                    var chart = new Chart(selectCanvas, {
                        type: 'line',
                        data: {
                            labels: _get_data.labels,
                            datasets: chart_data
                        },
                        options: {
                            legend: {
                                display: _get_data.legend ? _get_data.legend : false,
                                labels: {
                                    boxWidth: 30,
                                    padding: 20,
                                    fontColor: '#6783b8'
                                }
                            },
                            maintainAspectRatio: false,
                            tooltips: {
                                enabled: true,
                                callbacks: {
                                    title: function title(tooltipItem, data) {
                                        return data['labels'][tooltipItem[0]['index']];
                                    },
                                    label: function label(tooltipItem, data) {
                                        return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                                    }
                                },
                                backgroundColor: '#eff6ff',
                                titleFontSize: 13,
                                titleFontColor: '#6783b8',
                                titleMarginBottom: 6,
                                bodyFontColor: '#9eaecf',
                                bodyFontSize: 12,
                                bodySpacing: 4,
                                yPadding: 10,
                                xPadding: 10,
                                footerMarginTop: 0,
                                displayColors: false
                            },
                            scales: {
                                yAxes: [{
                                    display: true,
                                    stacked: _get_data.stacked ? _get_data.stacked : false,
                                    ticks: {
                                        beginAtZero: true,
                                        fontSize: 11,
                                        fontColor: '#9eaecf',
                                        padding: 10,
                                        callback: function callback(value, index, values) {
                                            return '$ ' + value;
                                        },
                                        min: 100,
                                        stepSize: 3000
                                    },
                                    gridLines: {
                                        color: "#e5ecf8",
                                        tickMarkLength: 0,
                                        zeroLineColor: '#e5ecf8'
                                    }
                                }],
                                xAxes: [{
                                    display: true,
                                    stacked: _get_data.stacked ? _get_data.stacked : false,
                                    ticks: {
                                        fontSize: 9,
                                        fontColor: '#9eaecf',
                                        source: 'auto',
                                        padding: 10
                                    },
                                    gridLines: {
                                        color: "transparent",
                                        tickMarkLength: 0,
                                        zeroLineColor: 'transparent'
                                    }
                                }]
                            }
                        }
                    });
                });
            } // init chart


            NioApp.coms.docReady.push(function () {
                lineSalesOverview();
            });
            var supportStatus = {
                labels: ["Bitcoin", "Ethereum", "NioCoin", "Feature Request", "Bug Fix"],
                stacked: true,
                datasets: [{
                    label: "Solved",
                    color: ["#f98c45", "#9cabff", "#8feac5", "#6b79c8", "#79f1dc"],
                    data: [66, 74, 92, 142, 189]
                }, {
                    label: "Open",
                    color: [NioApp.hexRGB('#f98c45', .4), NioApp.hexRGB('#9cabff', .4), NioApp.hexRGB('#8feac5', .4), NioApp.hexRGB('#6b79c8', .4), NioApp.hexRGB('#79f1dc', .4)],
                    data: [66, 74, 92, 32, 26]
                }, {
                    label: "Pending",
                    color: [NioApp.hexRGB('#f98c45', .2), NioApp.hexRGB('#9cabff', .2), NioApp.hexRGB('#8feac5', .2), NioApp.hexRGB('#6b79c8', .2), NioApp.hexRGB('#79f1dc', .2)],
                    data: [66, 74, 92, 21, 9]
                }]
            };

            function supportStatusChart(selector, set_data) {
                var $selector = selector ? $(selector) : $('.support-status-chart');
                $selector.each(function () {
                    var $self = $(this),
                        _self_id = $self.attr('id'),
                        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
                        _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

                    var selectCanvas = document.getElementById(_self_id).getContext("2d");
                    var chart_data = [];

                    for (var i = 0; i < _get_data.datasets.length; i++) {
                        chart_data.push({
                            label: _get_data.datasets[i].label,
                            data: _get_data.datasets[i].data,
                            // Styles
                            backgroundColor: _get_data.datasets[i].color,
                            borderWidth: 2,
                            borderColor: 'transparent',
                            hoverBorderColor: 'transparent',
                            borderSkipped: 'bottom',
                            barThickness: '8',
                            categoryPercentage: 0.5,
                            barPercentage: 1.0
                        });
                    }

                    var chart = new Chart(selectCanvas, {
                        type: 'horizontalBar',
                        data: {
                            labels: _get_data.labels,
                            datasets: chart_data
                        },
                        options: {
                            legend: {
                                display: _get_data.legend ? _get_data.legend : false,
                                labels: {
                                    boxWidth: 30,
                                    padding: 20,
                                    fontColor: '#6783b8'
                                }
                            },
                            maintainAspectRatio: false,
                            tooltips: {
                                enabled: true,
                                callbacks: {
                                    title: function title(tooltipItem, data) {
                                        return data['labels'][tooltipItem[0]['index']];
                                    },
                                    label: function label(tooltipItem, data) {
                                        return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + data.datasets[tooltipItem.datasetIndex]['label'];
                                    }
                                },
                                backgroundColor: '#eff6ff',
                                titleFontSize: 13,
                                titleFontColor: '#6783b8',
                                titleMarginBottom: 6,
                                bodyFontColor: '#9eaecf',
                                bodyFontSize: 12,
                                bodySpacing: 4,
                                yPadding: 10,
                                xPadding: 10,
                                footerMarginTop: 0,
                                displayColors: false
                            },
                            scales: {
                                yAxes: [{
                                    display: true,
                                    stacked: _get_data.stacked ? _get_data.stacked : false,
                                    ticks: {
                                        beginAtZero: true,
                                        padding: 16,
                                        fontColor: "#8094ae"
                                    },
                                    gridLines: {
                                        color: "transparent",
                                        tickMarkLength: 0,
                                        zeroLineColor: 'transparent'
                                    }
                                }],
                                xAxes: [{
                                    display: false,
                                    stacked: _get_data.stacked ? _get_data.stacked : false,
                                    ticks: {
                                        fontSize: 9,
                                        fontColor: '#9eaecf',
                                        source: 'auto',
                                        padding: 0
                                    },
                                    gridLines: {
                                        color: "transparent",
                                        tickMarkLength: 0,
                                        zeroLineColor: 'transparent'
                                    }
                                }]
                            }
                        }
                    });
                });
            } // init chart


            NioApp.coms.docReady.push(function () {
                supportStatusChart();
            });
        }(NioApp, jQuery);
    </script>
{{--    <script src="{{ asset('assets/js/charts/gd-general.js') }}?ver=1.4.0"></script>--}}
@endpush
