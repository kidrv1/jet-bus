@extends('layout.layout')

@section('custom_styles')
    <style>

    </style>
@endsection

@section('custom_scripts')
    <script>

    </script>
@endsection

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route("home") }}">Home</a>
                    <span class="breadcrumb-item active">Our Services</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Services Start -->
    <div class="container-fluid">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Our Services</span></h2>
        <div class="row px-xl-5 mb-4">
            <div class="col-lg-5 px-0">
                <img class="img-fluid" src="/public/about-img-1.jpg" alt="Image">
            </div>
            <div class="col-lg-7 h-auto px-0">
                <div class="h-100 bg-light p-30 d-flex flex-column justify-content-center">
                    <h1>Bus Rental</h1>
                    <h4 class="mt-4 text-muted">
                        Jet Bus Travel and Tours offers buses for rent. It has been especially popular for tours, gatherings, and other special events.
                    </h4>
                </div>
            </div>
        </div>
        <div class="row px-xl-5 mb-4">
            <div class="col-lg-7 h-auto px-0">
                <div class="h-100 bg-light p-30 d-flex flex-column justify-content-center">
                    <h1>Day Tours</h1>
                    <h4 class="mt-4 text-muted">
                        Enjoy day tours with Jet Bus Travel and Tours!
                    </h4>
                </div>
            </div>
            <div class="col-lg-5 px-0">
                <img class="img-fluid" src="/public/about-img-5.webp" alt="Image">
            </div>
        </div>
        <div class="row px-xl-5 mb-4">
            <div class="col-lg-5 px-0">
                <img class="img-fluid" src="/public/about-img-4.jpg" alt="Image">
            </div>
            <div class="col-lg-7 h-auto px-0">
                <div class="h-100 bg-light p-30 d-flex flex-column justify-content-center">
                    <h1>Multi-day Tours</h1>
                    <h4 class="mt-4 text-muted">
                        Two or more is better than one, Jet Bus Travel and Tours also offers multiple trips!
                    </h4>
                </div>
            </div>
        </div>
        <div class="row px-xl-5 mb-4">
            <div class="col-lg-7 h-auto px-0">
                <div class="h-100 bg-light p-30 d-flex flex-column justify-content-center">
                    <h1>Tour Packages</h1>
                    <h4 class="mt-4 text-muted">
                        Affordable, safe, and numerous amount of tour packages created by Jet Bus Travel and Tours team!
                    </h4>
                </div>
            </div>
            <div class="col-lg-5 px-0">
                <img class="img-fluid" src="/public/about-img-3.jpg" alt="Image">
            </div>
        </div>
    </div>
    <!-- Services End -->

    @endsection
