@extends("layout.layout")

@section('custom_styles')
    <style>
        .img-package {
            width: 200px; /* You can set the dimensions to whatever you want */
            height: 200px;
            object-fit: cover;
        }
    </style>
@endsection

@section("content")
    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#header-carousel" data-slide-to="1"></li>
                        <li data-target="#header-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/carousel-1.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">
                                        Tour Packages
                                    </h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                                        Experience the best local tours in town. Explore the region for an affordable price.
                                    </p>
                                    <a
                                        class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                        href="#featured-section">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/carousel-2.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">
                                        Convenient
                                    </h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                                        We found and combined the best tours in a single package. Just book and you're ready to go in a week
                                    </p>
                                    <a
                                        class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                        href="#featured-section">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/carousel-3.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">
                                        For Everyone
                                    </h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                                        Fit for all your needs. From small gatherings to big events
                                    </p>
                                    <a
                                        class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                        href="#featured-section">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @if(count($randomPackages) >= 2)
                    @if ($randomPackages[0] != null)
                    <div class="product-offer mb-30" style="height: 200px;">
                        <img class="img-fluid" src="/public/public/{{ $randomPackages[0]['bus']->image}}" alt="package image">
                        <div class="offer-text">
                            {{-- <h6 class="text-white text-uppercase">Save 20%</h6> --}}
                            <h3 class="text-white mb-3">{{ $randomPackages[0]->package_name }}</h3>
                            <a href="{{ route("packages.show", ['id' => $randomPackages[0]->id]) }}" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                    @endif
                    @if ($randomPackages[1] != null)
                        <div class="product-offer mb-30" style="height: 200px;">
                            <img class="img-fluid" src="/public/public/{{ $randomPackages[1]['bus']->image}}" alt="package image">
                            <div class="offer-text">
                                <h3 class="text-white mb-3">{{ $randomPackages[1]->package_name }}</h3>
                                <a href="{{ route("packages.show", ['id' => $randomPackages[1]->id]) }}" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Brag Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Trusted</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Fast</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Pick Up and Drop Off</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Book In Advance</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Brag End -->
    {{-- <div class="container">
        {{ dd($prevPackages[0]->package->bus->image) }}
    </div> --}}
    <!-- Products Start -->
    <div id="featured-section" class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured Packages</span></h2>
        <div class="row px-xl-5">
            {{-- Packages Here --}}
            @forelse ($featuredPackages as $package)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden" style="height: 200px;">
                            <img class="img-fluid w-100" src="/public/public/{{ $package->bus->image }}" alt="package picture">
                            <div class="product-action">
                                <a class="btn btn-outline-dark" href="{{ route("packages.show", ['id' => $package->id]) }}">
                                    <i class="fa fa-shopping-cart mr-1"></i>
                                    Book
                                </a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a
                                class="h6 text-decoration-none text-truncate"
                                href="{{ route("packages.show", ['id' => $package->id]) }}">
                                {{ $package->package_name }}
                            </a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                {{-- <h5>&#8369; {{ number_format($package->package_rate, 2) }}</h5> --}}
                                {{-- <h6 class="text-muted ml-2">
                                    <del>&#8368; 12,300.00</del>
                                </h6> --}}
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="text-primary mr-1">{{ date('h:i A', strtotime($package->start_time)) }}</small>
                                <small class="text-primary mr-1">-</small>
                                <small class="text-primary mr-1">{{ date('h:i A', strtotime($package->end_time)) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <h3>No Packages To Show</h3>
            </div>
            @endforelse

        </div>
    </div>
    <!-- Products End -->

    <!-- Satisfied Start -->
    @if(!empty($testimonials))
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    @foreach ($testimonials as $item)
                        <div class="bg-light p-4">
                            <img class="img-fluid" src="{{ URL::to('/') }}/testimonials/{{ $item->image }}" style="max-width: 1024;" alt="Image of Satisfied Customer">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Satisfied End -->


    <!-- Random Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            @if (count($randomPackages) >= 4)
                @if ($randomPackages[2] ?? null != null)
                    <div class="col-md-6">
                        <div class="product-offer mb-30" style="height: 300px;">
                            <img class="img-fluid" src="/public/public/{{ $randomPackages[2]['bus']->image}}" alt="package image">
                            <div class="offer-text">
                                <h6 class="text-white text-uppercase">You might like</h6>
                                <h3 class="text-white mb-3">{{ $randomPackages[2]->package_name }}</h3>
                                <a href="{{ route("packages.show", ['id' => $randomPackages[2]->id]) }}" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($randomPackages[3] ?? null != null)
                    <div class="col-md-6">
                        <div class="product-offer mb-30" style="height: 300px;">
                            <img class="img-fluid" src="/public/public/{{ $randomPackages[3]['bus']->image}}" alt="package image">
                            <div class="offer-text">
                                <h6 class="text-white text-uppercase">You might like</h6>
                                <h3 class="text-white mb-3">{{ $randomPackages[3]->package_name }}</h3>
                                <a href="{{ route("packages.show", ['id' => $randomPackages[3]->id]) }}" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
    <!-- Random End -->


    @auth
    <!-- Recent Packages Booked Start -->
    @if(count($prevPackages) > 0)
        <div class="container-fluid pt-5 pb-3">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Recently Booked</span></h2>
            <div class="row px-xl-5">
        @forelse ($prevPackages as $package)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden" style="height: 200px;">
                        <img class="img-fluid w-100" src="/public/public/{{ $package->package->bus->image }}" alt="package picture">
                        <div class="product-action">
                            <a class="btn btn-outline-dark" href="{{ route("customer_booking_list") }}">
                                <i class="fa fa-shopping-cart mr-1"></i>
                                View
                            </a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a
                            class="h6 text-decoration-none text-truncate"
                            href="{{ route("customer_booking_packages") }}">
                            {{ $package->package->package_name }}
                        </a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            {{-- <h5>&#8369; {{ number_format($package->package->package_rate, 2) }}</h5> --}}
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="text-primary mr-1">{{ date('h:i A', strtotime($package->package->start_time)) }}</small>
                            <small class="text-primary mr-1">-</small>
                            <small class="text-primary mr-1">{{ date('h:i A', strtotime($package->package->end_time)) }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                No History To Show
            </div>
        @endforelse
            </div>
        </div>
    @endif
    <!-- Recent Packages Booked End-->
    @endauth

@endsection
