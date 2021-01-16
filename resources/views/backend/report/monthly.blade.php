@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@php

$office_id = [];
if(request('office_id')){
    $office_id = request('office_id');
    $office_id = array_flip($office_id);
}
@endphp

@section('content')
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-8">

                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Monthly Report</h5>
                            </div>
                            <form action="#">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="year">Year</label>
                                            <div class="form-control-wrap">
                                                <select id="year" name="year" class="form-select">
                                                    @foreach(getYear() as $y)
                                                        <option value="{{ $y }}" {{ (request('year') == $y)? "selected" : "" }}>{{ $y }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Drop Point</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                @foreach(dropPoints() as $dp)
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="office_id[]" value="{{ $dp->id }}" id="dp_{{ $dp->id }}" {{ (array_key_exists($dp->id, $office_id))? "checked" : "" }}>
                                                        <label class="custom-control-label" for="dp_{{ $dp->id }}">{{ $dp->name }}</label>
                                                    </div>
                                                </li>
                                                @endforeach

                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-lg-7 offset-lg-5">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary">Get Report</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="row-12">
                                <h4 class="text-center m-4">Parcel Report For {{ $year }}</h4>
                            </div>
                            <div class="nk-ck-sm">
                                <canvas class="line-chart" id="straightLineChart"></canvas>
                            </div>

                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="bg-primary text-white text-center">
                                        <th class="text-left">Month</th>
                                        <th>In Process</th>
                                        <th>Pending</th>
                                        <th>Completed</th>
                                        <th>Return</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    @foreach($table as $key => $i)
                                        <tr>
                                            <td class="text-left">{{ $key }}</td>
                                            <td>{{ $i['process'] }}</td>
                                            <td>{{ $i['pending'] }}</td>
                                            <td>{{ $i['completed'] }}</td>
                                            <td>{{ $i['return'] }}</td>
                                            <td>{{ $i['total'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
{{--    <script src="{{ asset('assets/js/example-chart.js') }}?ver=1.4.0"></script>--}}

    <script type="text/javascript">
        "use strict";
        ! function(NioApp, $) {

            var straightLineChart = {
                    labels: @json(getMonthName()),
                    dataUnit: "BTC",
                    lineTension: 0,
                    datasets: [{
                        label: "Total Received",
                        color: "#798bff",
                        background: NioApp.hexRGB("#798bff", .3),
                        data: @json($data)
                    }]
                };

            function lineChart(selector, set_data) {
                var $selector = $(selector || ".line-chart");
                $selector.each(function() {
                    for (var $self = $(this), _self_id = $self.attr("id"), _get_data = void 0 === set_data ? eval(_self_id) : set_data, selectCanvas = document.getElementById(_self_id).getContext("2d"), chart_data = [], i = 0; i < _get_data.datasets.length; i++) chart_data.push({
                        label: _get_data.datasets[i].label,
                        tension: _get_data.lineTension,
                        backgroundColor: _get_data.datasets[i].background,
                        borderWidth: 2,
                        borderColor: _get_data.datasets[i].color,
                        pointBorderColor: _get_data.datasets[i].color,
                        pointBackgroundColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: _get_data.datasets[i].color,
                        pointBorderWidth: 2,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 2,
                        pointRadius: 4,
                        pointHitRadius: 4,
                        data: _get_data.datasets[i].data
                    });
                    var chart = new Chart(selectCanvas, {
                        type: "line",
                        data: {
                            labels: _get_data.labels,
                            datasets: chart_data
                        },
                        options: {
                            legend: {
                                display: !!_get_data.legend && _get_data.legend,
                                labels: {
                                    boxWidth: 12,
                                    padding: 20,
                                    fontColor: "#6783b8"
                                }
                            },
                            maintainAspectRatio: !1,
                            tooltips: {
                                enabled: !0,
                                callbacks: {
                                    title: function(a, t) {
                                        return t.labels[a[0].index]
                                    },
                                    label: function(a, t) {
                                        return t.datasets[a.datasetIndex].data[a.index] + " " + _get_data.dataUnit
                                    }
                                },
                                backgroundColor: "#eff6ff",
                                titleFontSize: 13,
                                titleFontColor: "#6783b8",
                                titleMarginBottom: 6,
                                bodyFontColor: "#9eaecf",
                                bodyFontSize: 12,
                                bodySpacing: 4,
                                yPadding: 10,
                                xPadding: 10,
                                footerMarginTop: 0,
                                displayColors: !1
                            },
                            scales: {
                                yAxes: [{
                                    display: !0,
                                    ticks: {
                                        beginAtZero: !1,
                                        fontSize: 12,
                                        fontColor: "#9eaecf",
                                        padding: 10
                                    },
                                    gridLines: {
                                        color: "#e5ecf8",
                                        tickMarkLength: 0,
                                        zeroLineColor: "#e5ecf8"
                                    }
                                }],
                                xAxes: [{
                                    display: !0,
                                    ticks: {
                                        fontSize: 12,
                                        fontColor: "#9eaecf",
                                        source: "auto",
                                        padding: 5
                                    },
                                    gridLines: {
                                        color: "transparent",
                                        tickMarkLength: 10,
                                        zeroLineColor: "#e5ecf8",
                                        offsetGridLines: !0
                                    }
                                }]
                            }
                        }
                    })
                })
            }
            lineChart();

        }(NioApp, jQuery);
    </script>
@endpush
