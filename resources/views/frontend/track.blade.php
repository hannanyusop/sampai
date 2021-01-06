@extends('frontend.layouts.landing')


@section('content')
    <style>

        a {
            color: #ff6b6b;
        }
        a:hover {
            color: #ff9a9a;
            text-decoration: none;
        }
        .example-header h1 {
            color: #fff;
            font-weight: 300;
            margin-bottom: 20px;
        }
        .example-header p {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 700;
        }
        .container-fluid .row {
            padding: 0 0 4em 0;
        }
        .container-fluid .row:nth-child(even) {
            background: #f1f4f5;
        }
        .example-title {
            text-align: center;
            margin-bottom: 60px;
            padding: 3em 0;
            border-bottom: 1px solid #e4eaec;
        }
        .example-title p {
            margin: 0 auto;
            font-size: 16px;
            max-width: 400px;
        }
        /*================================== TIMELINE ==================================*/
        /*-- GENERAL STYLES ------------------------------*/
        .timeline {
            line-height: 1.4em;
            list-style: none;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        .timeline h1, .timeline h2, .timeline h3, .timeline h4, .timeline h5, .timeline h6 {
            line-height: inherit;
        }
        /*----- TIMELINE ITEM -----*/
        .timeline-item {
            padding-left: 40px;
            position: relative;
        }
        .timeline-item:last-child {
            padding-bottom: 0;
        }
        /*----- TIMELINE INFO -----*/
        .timeline-info {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 3px;
            margin: 0 0 0.5em 0;
            text-transform: uppercase;
            white-space: nowrap;
        }
        /*----- TIMELINE MARKER -----*/
        .timeline-marker {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 15px;
        }
        .timeline-marker:before {
            background: #ff6b6b;
            border: 3px solid transparent;
            border-radius: 100%;
            content: "";
            display: block;
            height: 15px;
            position: absolute;
            top: 4px;
            left: 0;
            width: 15px;
            transition: background 0.3s ease-in-out, border 0.3s ease-in-out;
        }
        .timeline-marker:after {
            content: "";
            width: 3px;
            background: #ccd5db;
            display: block;
            position: absolute;
            top: 24px;
            bottom: 0;
            left: 6px;
        }
        .timeline-item:last-child .timeline-marker:after {
            content: none;
        }
        .timeline-item:not(.period):hover .timeline-marker:before {
            background: transparent;
            border: 3px solid #ff6b6b;
        }
        /*----- TIMELINE CONTENT -----*/
        .timeline-content {
            padding-bottom: 40px;
        }
        .timeline-content p:last-child {
            margin-bottom: 0;
        }
        /*----- TIMELINE PERIOD -----*/
        .period {
            padding: 0;
        }
        .period .timeline-info {
            display: none;
        }
        .period .timeline-marker:before {
            background: transparent;
            content: "";
            width: 15px;
            height: auto;
            border: none;
            border-radius: 0;
            top: 0;
            bottom: 30px;
            position: absolute;
            border-top: 3px solid #ccd5db;
            border-bottom: 3px solid #ccd5db;
        }
        .period .timeline-marker:after {
            content: "";
            height: 32px;
            top: auto;
        }
        .period .timeline-content {
            padding: 40px 0 70px;
        }
        .period .timeline-title {
            margin: 0;
        }

    </style>
    <!-- Form -->
    <div class="ex-form-1 pt-6 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <p class="m-5">Track your parcel easily with Sampai.com. We provide a service to check the arrival of parcel at the UTeM Mel units. The system is create for students and staff</p>

                    <!-- Contact Form -->
                    <form method="get" class="mb-6" data-toggle="validator" data-focus="false">
                        <div class="form-group">
                            <input type="text" class="form-control-input" name="tracking_no" value="{{ request('tracking_no') }}" id="tracking_no" required>
                            <label class="label-control" for="tracking_no">Tracking Number</label>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">Search</button>
                        </div>
                    </form>

                    @if(request('tracking_no'))
                        @if(!$parcel)
                            <div class="container-fluid">
                                <div class="row example-basic">
                                    <div class="col-md-12 example-title">
                                        <p>No parcel found for <b>'{{ request('tracking_no') }}'</b></p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="container-fluid">
                                <div class="row example-basic">
                                    <div class="col-md-12 example-title">
                                        <h4>Parcel: #<b>{{ request('tracking_no') }}</b></h4>
                                    </div>
                                    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
                                        <ul class="timeline">
                                            @foreach($parcel->transactions as $transaction)
                                            <li class="timeline-item">
                                                <div class="timeline-info">
                                                    <span>{{ reformatDatetime($transaction->created_at, 'M d, Y') }}</span>
                                                </div>
                                                <div class="timeline-marker"></div>
                                                <div class="timeline-content">
                                                    <h3 class="timeline-title">{{ reformatDatetime($transaction->created_at, 'h:i A') }}</h3>
                                                    <p>{{ $transaction->remark }}</p>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    <!-- end of contact form -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-form-1 -->
    <!-- end of form -->
@endsection
