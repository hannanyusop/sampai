<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="author" content="Inovatik">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
    <meta property="og:site_name" content="" /> <!-- website name -->
    <meta property="og:site" content="" /> <!-- website link -->
    <meta property="og:title" content=""/> <!-- title shown in the actual shared post -->
    <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
    <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
    <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
    <meta property="og:type" content="article" />

    <!-- Webpage Title -->
    <title>{{ env('APP_NAME') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('landing/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/css/swiper.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/css/styles.css') }}" rel="stylesheet">

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
</head>
<body data-spy="scroll" data-target=".fixed-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg fixed-top navbar-dark">
    <div class="container">

        <a class="navbar-brand logo-image" href="{{ route('frontend.index') }}"><img src="{{ asset('images/logo-dark.png') }}" style="height:40px;width: auto" alt="alternative"></a>

        <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">

                @if(auth()->user())
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="{{ route(homeRoute()) }}">Dashboard <span class="sr-only">Dashboard</span></a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="{{ route('frontend.index') }}">Main</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="{{ route('frontend.auth.login') }}">Login</a>
                    </li>
                    @if(registrationEnabled())
                        <li class="nav-item">
                            <a class="nav-link page-scroll" href="{{ route('frontend.auth.register') }}">Register</a>
                        </li>
                    @endif
                @endif
                @if(trackEnabled())
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="{{ route('frontend.track') }}">Track</a>
                    </li>
                @endif
            </ul>
        </div> <!-- end of navbar-collapse -->
    </div> <!-- end of container -->
</nav> <!-- end of navbar -->
<!-- end of navigation -->

@yield('content')


<div class="footer bg-dark-blue">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-col first">
                    <h6>About SAMPAI.MY</h6>
                    <p class="p-small">Sampai.com is a service to check the arrival of parcel at the UTeM Mel units. The system is create for students and staff</p>
                </div> <!-- end of footer-col -->
                <div class="footer-col second">
                    <h6>Links</h6>
                    <ul class="list-unstyled li-space-lg p-small">
                    </ul>
                </div> <!-- end of footer-col -->
                <div class="footer-col third">
                    <p class="p-small">We would love to hear from you <a href="mailto:admin@sampai.com"><strong>admin@sampai.com</strong></a></p>
                </div> <!-- end of footer-col -->
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of footer -->
<!-- end of footer -->


<!-- Copyright -->
<div class="copyright bg-dark-blue">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="p-small">Copyright © <a href="#">Sampai Team</a></p>
            </div> <!-- end of col -->
        </div> <!-- enf of row -->
    </div> <!-- end of container -->
</div> <!-- end of copyright -->
<!-- end of copyright -->



<script src="{{ asset('landing/js/jquery.min.js') }}"></script>
<script src="{{ asset('landing/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('landing/js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('landing/js/swiper.min.js') }}"></script>
<script src="{{ asset('landing/js/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('landing/js/morphext.min.js') }}"></script>
<script src="{{ asset('landing/js/validator.min.js') }}"></script>
<script src="{{ asset('landing/js/scripts.js') }}"></script>
</body>

</html>

