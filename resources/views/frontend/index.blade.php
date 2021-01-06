@extends('frontend.layouts.landing')


@section('content')
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-container">
                        <h1>SAMPAI <br>FOR <span id="js-rotating">TRUST, FAST, SATISFIED</span></h1>
                        <p class="p-large">Sampai.com is a service to check the arrival of parcel at the UTeM Mel units. The system is create for students and staff.</p>
                        <a class="btn-solid-lg" href="{{ route('frontend.auth.login') }}"><i class="fa fa-sign-in-alt"></i> Login</a>
                        <a class="btn-solid-lg" href="{{ route('frontend.auth.register') }}"><i class="fa fa-user-friends"></i> Sign Up</a>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6">
                    <img class="img-fluid" src="{{ asset('landing/images/header-smartphones.png') }}" alt="alternative">
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header>

    <div class="tabs">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="h2-heading">FEATURES</h2>
                    <div class="p-heading">There are several unique services and features to boost up your eCommerce operation.
                        With this system, we can easily managing your store order to keeping your receivers informed on delivering statuses
                    </div>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">

                <!-- Tabs Links -->
                <ul class="nav nav-tabs" id="templateTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="nav-tab-1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true"><i class="fas fa-cog"></i>CONFIGURING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-tab-2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false"><i class="fas fa-binoculars"></i>TRACKING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-tab-3" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false"><i class="fas fa-search"></i>MONITORING</a>
                    </li>
                </ul>
                <!-- end of tabs links -->


                <!-- Tabs Content-->
                <div class="tab-content" id="templateTabsContent">

                    <!-- Tab -->
                    <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab-1">
                        <div class="container">
                            <div class="row">

                                <!-- Icon Cards Pane -->
                                <div class="col-lg-4">
                                    <ul class="list-unstyled li-space-lg first">
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="far fa-compass fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Goal Setting</h4>
                                                <p>Like any self improving process, everything starts with setting your goals and committing to them</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-code fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Visual Editor</h4>
                                                <p>Leno provides a well designed and ergonomic visual editor for you to edit your quick notes</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="far fa-gem fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Refined Options</h4>
                                                <p>Each option packaged in the app's menus is provided in order to improve you personally</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div> <!-- end of col -->
                                <!-- end of icon cards pane -->

                                <!-- Image Pane -->
                                <div class="col-lg-4">
                                    <img class="img-fluid" src="{{ asset('landing/images/features-smartphone-1.png') }}" alt="alternative">
                                </div> <!-- end of col -->
                                <!-- end of image pane -->

                                <!-- Icon Cards Pane -->
                                <div class="col-lg-4">
                                    <ul class="list-unstyled li-space-lg">
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-calendar-alt fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Calendar Input</h4>
                                                <p>Schedule your appointments, meetings and periodical evaluations using the tools</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-book fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Easy Reading</h4>
                                                <p>Reading focus mode for long form articles, ebooks and other materials with long text</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-cube fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Good Foundation</h4>
                                                <p>Get a solid foundation for your self development efforts. Try Leno mobile app for devices</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div> <!-- end of col -->
                                <!-- end of icon cards pane -->

                            </div> <!-- end of row -->
                        </div> <!-- end of container -->
                    </div> <!-- end of tab-pane -->
                    <!-- end of tab -->

                    <!-- Tab -->
                    <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab-2">
                        <div class="container">
                            <div class="row">

                                <!-- Image Pane -->
                                <div class="col-lg-4">
                                    <img class="img-fluid" src="{{ asset('landing/images/features-smartphone-2.png') }}" alt="alternative">
                                </div> <!-- end of col -->
                                <!-- end of image pane -->

                                <!-- Text And Icon Cards Area -->
                                <div class="col-lg-8">
                                    <h3>Track Result Based On Your</h3>
                                    <p class="sub-heading">After you've configured the app and settled on the data gathering techniques you can start the information trackers and begin collecting those long awaited interesting details.</p>
                                    <ul class="list-unstyled li-space-lg first">
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-cube fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Good Foundation</h4>
                                                <p>Get a solid foundation for your self development efforts. Try Leno mobile app now</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-book fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Easy Reading</h4>
                                                <p>Reading focus mode for long form articles, ebooks and other materials with long text</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="far fa-compass fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Goal Setting</h4>
                                                <p>Like any self improving process, everything starts with setting goals and comiting</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled li-space-lg">
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-calendar-alt fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Calendar Input</h4>
                                                <p>Schedule your appointments, meetings and periodical evaluations using the tools</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-code fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Visual Editor</h4>
                                                <p>Leno provides a well designed and ergonomic visual editor for you to edit your notes</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="far fa-gem fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Refined Options</h4>
                                                <p>Each option packaged in the app's menus is provided in order to improve you personally</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div> <!-- end of col -->
                                <!-- end of text and icon cards area -->

                            </div> <!-- end of row -->
                        </div> <!-- end of container -->
                    </div> <!-- end of tab-pane -->
                    <!-- end of tab -->

                    <!-- Tab -->
                    <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="tab-3">
                        <div class="container">
                            <div class="row">

                                <!-- Text And Icon Cards Area -->
                                <div class="col-lg-8">
                                    <ul class="list-unstyled li-space-lg first">
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-cube fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Good Foundation</h4>
                                                <p>Get a solid foundation for your self development efforts. Try Leno mobile app today</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-book fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Easy Reading</h4>
                                                <p>Reading focus mode for long form articles, ebooks and other materials with long text</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="far fa-compass fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Goal Setting</h4>
                                                <p>Like any self improving process, everything starts with setting your goals and comiting</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled li-space-lg">
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-calendar-alt fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Calendar Input</h4>
                                                <p>Schedule your appointments, meetings and periodical evaluations using the tools</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-code fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Visual Editor</h4>
                                                <p>Leno provides a well designed and ergonomic visual editor for you to edit your notes</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <span class="fa-stack">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="far fa-gem fa-stack-1x"></i>
                                            </span>
                                            <div class="media-body">
                                                <h4>Refined Options</h4>
                                                <p>Each option packaged in the app's menus is provided in order to improve you personally</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <h3>Monitoring Tools Evaluation</h3>
                                    <p class="sub-heading">Monitor the evolution of your finances and health state using tools integrated in Leno. The generated real time reports can be filtered based on any desired criteria.</p>
                                </div> <!-- end of col -->
                                <!-- end of text and icon cards area -->

                                <!-- Image Pane -->
                                <div class="col-lg-4">
                                    <img class="img-fluid" src="{{ asset('landing/images/features-smartphone-3.png') }}" alt="alternative">
                                </div> <!-- end of col -->
                                <!-- end of image pane -->

                            </div> <!-- end of row -->
                        </div> <!-- end of container -->
                    </div><!-- end of tab-pane -->
                    <!-- end of tab -->

                </div> <!-- end of tab-content -->
                <!-- end of tabs content -->

            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div>

    <div id="details-1-lightbox" class="lightbox-basic zoom-anim-dialog mfp-hide">
        <div class="row">
            <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
            <div class="col-lg-8">
                <div class="image-container">
                    <img class="img-fluid" src="images/details-1-lightbox.jpg" alt="alternative">
                </div> <!-- end of image-container -->
            </div> <!-- end of col -->
            <div class="col-lg-4">
                <h3>Goals Setting</h3>
                <hr>
                <p>The app can easily help you track your personal development evolution if you take the time to set it up.</p>
                <h4>User Feedback</h4>
                <p>This is a great app which can help you save time and make your live easier. And it will help improve your productivity.</p>
                <ul class="list-unstyled li-space-lg">
                    <li class="media">
                        <i class="fas fa-check"></i><div class="media-body">Splash screen panel</div>
                    </li>
                    <li class="media">
                        <i class="fas fa-check"></i><div class="media-body">Statistics graph report</div>
                    </li>
                    <li class="media">
                        <i class="fas fa-check"></i><div class="media-body">Events calendar layout</div>
                    </li>
                    <li class="media">
                        <i class="fas fa-check"></i><div class="media-body">Location details screen</div>
                    </li>
                    <li class="media">
                        <i class="fas fa-check"></i><div class="media-body">Onboarding steps interface</div>
                    </li>
                </ul>
                <a class="btn-solid-reg mfp-close page-scroll" href="#header">Download</a> <button class="btn-outline-reg mfp-close as-button" type="button">Back</button>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div>

    <div class="slider-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="h2-heading">SCREENS</h2>
                    <hr class="hr-heading">
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">

                    <!-- Image Slider -->
                    <div class="slider-container">
                        <div class="swiper-container image-slider">
                            <div class="swiper-wrapper">

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="{{ asset('landing/images/1.png') }}" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="{{ asset('landing/images/1.png') }}" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="{{ asset('landing/images/2.png') }}" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="{{ asset('landing/images/2.png') }}" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="{{ asset('landing/images/3.png') }}" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="{{ asset('landing/images/3.png') }}" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="{{ asset('landing/images/4.png') }}" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="{{ asset('landing/images/4.png') }}" alt="alternative">
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="{{ asset('landing/images/5.png') }}" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="{{ asset('landing/images/5.png') }}" alt="alternative">
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="{{ asset('landing/images/6.png') }}" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="{{ asset('landing/images/6.png') }}" alt="alternative">
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="{{ asset('landing/images/7.png') }}" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="{{ asset('landing/images/7.png') }}" alt="alternative">
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="{{ asset('landing/images/8.png') }}" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="{{ asset('landing/images/8.png') }}" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->
                            </div> <!-- end of swiper-wrapper -->

                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- end of add arrows -->

                        </div> <!-- end of swiper-container -->
                    </div> <!-- end of slider-container -->
                    <!-- end of image slider -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div>
@endsection
