<!DOCTYPE html>
<html lang="eb" class="js">

@include('frontend.includes.header1')

<body class="nk-body npc-subscription has-aside ui-clean ">
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap ">
            @include('frontend.includes.topbar')
            <div class="nk-content">
                <div class="nk-content-inner">
                    @include('frontend.includes.menu')
                    <div class="nk-content-body">
                        @include('includes.partials.messages')
                        @include('includes.partials.logged-in-as')
                        @yield('content')

                        @include('frontend.includes.footer')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="{{ asset('assets/js/charts/gd-general.js') }}?ver=1.4.0"></script>
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
</html>
