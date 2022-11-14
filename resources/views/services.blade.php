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
                <img class="img-fluid" src="/public/iloilo-bus.webp" alt="Image">
            </div>
            <div class="col-lg-7 h-auto px-0">
                <div class="h-100 bg-light p-30 d-flex flex-column justify-content-center">
                    <h1>Tours</h1>
                    <h4 class="mt-4 text-muted">
                        Volup erat ipsum diam elitr rebum et dolor. Est nonumy elitr erat diam stet sit
                        clita ea. Sanc ipsum et, labore clita lorem magna duo dolor no sea
                        Nonumy
                    </h4>
                </div>
            </div>
        </div>
        <div class="row px-xl-5 mb-4">
            <div class="col-lg-7 h-auto px-0">
                <div class="h-100 bg-light p-30 d-flex flex-column justify-content-center">
                    <h1>Travels</h1>
                    <h4 class="mt-4 text-muted">
                        Volup erat ipsum diam elitr rebum et dolor. Est nonumy elitr erat diam stet sit
                        clita ea. Sanc ipsum et, labore clita lorem magna duo dolor no sea
                        Nonumy
                    </h4>
                </div>
            </div>
            <div class="col-lg-5 px-0">
                <img class="img-fluid" src="/public/iloilo-bus.webp" alt="Image">
            </div>
        </div>
        <div class="row px-xl-5 mb-4">
            <div class="col-lg-5 px-0">
                <img class="img-fluid" src="/public/iloilo-bus.webp" alt="Image">
            </div>
            <div class="col-lg-7 h-auto px-0">
                <div class="h-100 bg-light p-30 d-flex flex-column justify-content-center">
                    <h1>Trips</h1>
                    <h4 class="mt-4 text-muted">
                        Volup erat ipsum diam elitr rebum et dolor. Est nonumy elitr erat diam stet sit
                        clita ea. Sanc ipsum et, labore clita lorem magna duo dolor no sea
                        Nonumy
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->

    @endsection
