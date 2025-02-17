@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

<style>
    .menu-card {
        text-align: center;
        padding: 2em;
        border-radius: 10px;
        background-color: #f8f9fa;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        display: flex;
        justify-content: center;
        margin: 0.5em;
        width: 10em;
        height: 10em;
    }

    .menu-card:hover {
        background-color: #f1f1f1;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    .menu-icon {
        font-size: 3em;
    }
    .menu-label {
        font-size: 1em;
        margin-top: 1em;
    }
</style>
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="user-account-info between-center text-center">
                <div class="user-account-main">
                    <h6 class="overline-title-alt">Date & Time</h6>
                    <div class="user-balance" id="time"></div>
                    <div class="user-balance-alt" id="dates"> </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="">
            <a href="{{ route('frontend.user.parcel.create') }}" class="menu-card card-inner card-inner-lg">
                <div class="align-center">
                    <div class="nk-block-content">
                        <i class="icon ni ni-plus-circle menu-icon"></i>
                        <h5 class="menu-label">Add Parcel</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="">
            <a href="{{ route('frontend.user.parcel.index') }}" class="menu-card card-inner card-inner-lg">
                <div class="align-center">
                    <div class="nk-block-content">
                        <i class="icon ni ni-list menu-icon"></i>
                        <h5 class="menu-label">Parcel List</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="">
            <a href="{{ route('frontend.user.pickup.index') }}" class="menu-card card-inner card-inner-lg">
                <div class="align-center">
                    <div class="nk-block-content">
                        <i class="icon ni ni-tags menu-icon"></i>
                        <h5 class="menu-label">Pickup List</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="">
            <a href="{{ route('frontend.user.account') }}" class="menu-card card-inner card-inner-lg">
                <div class="align-center">
                    <div class="nk-block-content">
                        <i class="icon ni ni-user-circle menu-icon"></i>
                        <h5 class="menu-label">Account Setting</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="">
            <a href="{{ route('frontend.auth.logout') }}" class="menu-card card-inner card-inner-lg">
                <div class="align-center">
                    <div class="nk-block-content">
                        <i class="icon ni ni-lock-alt menu-icon"></i>
                        <h5 class="menu-label">Log out</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
@push('after-script')
    <script type="text/javascript">
        var printDate = function () {
            var d = new Date();
            var year = d.getFullYear();
            var month = d.getMonth() + 1;
            var date = d.getDate();
            var hour = d.getHours();
            var minute = d.getMinutes();
            var second = d.getSeconds();
            if (month < 10) {
                month = "0" + month;
            } else {
                month = month;
            }
            if (date < 10) {
                date = "0" + date;
            } else {
                date = date;
            }
            if (hour < 10) {
                hour = "0" + hour;
            } else {
                hour = hour;
            }
            if (minute < 10) {
                minute = "0" + minute;
            } else {
                minute = minute;
            }
            if (second < 10) {
                second = "0" + second;
            } else {
                second = second;
            }
            document.getElementById("dates").innerHTML = month + "-" + date + "-" + year;
            document.getElementById("time").innerHTML = hour + ":" + minute + ":" + second;
        };

        setInterval(printDate, 1000);
    </script>
@endpush
