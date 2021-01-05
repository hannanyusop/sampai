@extends('frontend.layouts.landing')


@section('content')
    <!-- Form -->
    <div class="ex-form-1 pt-6 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <p class="mb-5">We love to create dependable business are solutions for small and medium sized word companies. Email our office using <a href="mailto:contact@leno.com">contact@leno.com</a> or call us using <a href="tel:123-456-7890">+123-456-7890</a></p>

                    <!-- Contact Form -->
                    <form id="contactForm" class="mb-6" data-toggle="validator" data-focus="false">
                        <div class="form-group">
                            <input type="text" class="form-control-input" name="tracking_no" id="tracking_no" required>
                            <label class="label-control" for="tracking_no">Tracking Number</label>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">Search</button>
                        </div>
                        <div class="form-message">
                            <div id="cmsgSubmit" class="h3 text-center hidden"></div>
                        </div>
                    </form>
                    <!-- end of contact form -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-form-1 -->
    <!-- end of form -->
@endsection
