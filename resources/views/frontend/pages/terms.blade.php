@extends('frontend.layouts.landing')

<style>
    .rounded-div {
        background-color: rgba(255, 255, 255, 0.5); /* 50% transparency */
        border-radius: 10px; /* Adjust the value for the desired roundness */
        padding: 20px; /* Add padding as needed */
        width: 300px; /* Set the width as needed */
        margin: 20px;
        color: #0b0b0b/* Adjust margin as needed */
    }

    .rounded-div h2 {
        font-size: 1.5em;
        font-weight: bold;
        margin-bottom: 0.5em;
        color: #0b0b0b/* Adjust margin as needed */

    }

    .rounded-div h3 {
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 0.5em;
        color: #0b0b0b/* Adjust margin as needed */
    }

    .rounded-div p {
        font-size: 1em;
        margin-bottom: 0.5em;
        color: #0b0b0b/* Adjust margin as needed */
    }


</style>
@section('content')
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 rounded-div">
                    <div class="text-container">
                        <h2>Privacy Policy for NUJ (Norizman Usaha Jaya Express)</h2>

                        <p>Last updated: 26 JANUARY 2024</p>

                        <h2>1. Introduction</h2>

                        <p>Welcome to NUJ (Norizman Usaha Jaya Express)! This Privacy Policy explains how we collect, use, disclose, and
                            safeguard your information when you use our runner service to hand over parcels. Please read this policy
                            carefully to understand our practices.</p>

                        <h2>2. Information We Collect</h2>

                        <h3>2.1 Personal Information</h3>

                        <p>We may collect personal information, including but not limited to:</p>
                        <ul>
                            <li>Contact Information: Name, address, phone number, and email address.</li>
                            <li>Delivery Details: Parcel information, recipient details, and delivery preferences.</li>
                        </ul>

                        <h3>2.2 Usage Information</h3>

                        <p>We may collect information about how you interact with our service, including:</p>
                        <ul>
                            <li>Log Data: IP address, device type, browser type, pages viewed, and the date and time of your visit.</li>
                        </ul>

                        <h2>3. How We Use Your Information</h2>

                        <p>We use the collected information for the following purposes:</p>
                        <ul>
                            <li>To provide and maintain our runner service.</li>
                            <li>To process and complete parcel deliveries.</li>
                            <li>To communicate with you regarding your deliveries.</li>
                            <li>To improve our services and enhance user experience.</li>
                        </ul>

                        <!-- Continue with the rest of the content -->

                        <p>For the complete Privacy Policy, please contact us at <a href="mailto:contact@nujcourier.my">contact@nnujcourier.my</a>.</p>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header>


@endsection
