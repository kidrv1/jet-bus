<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Jet Bus Travel and Tours</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="bus, travel, tours, rent, package" name="keywords">
    <meta content="Jet Bus Travel and Tours, book a tour throughout the country" name="description">

    <!-- Favicon -->
    <link href="../assets/img/favicon.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/css/style.css" rel="stylesheet">

    <!-- Spinner -->
    <style>
        .loading-spinner {
            background: #FFF;
            width: 100%;
            height: 100%;
            z-index: 999;
            top: 0;
            left: 0;
            position: fixed;
        }

        .loading-spinner.hidden {
            display: none;
        }
    </style>
    @yield('custom_styles')
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-8">
                <a href="" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Jet Bus</span>
                    <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Travel and Tours</span>
                </a>
            </div>

            <div class="col-lg-4 col-6 text-right">

            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Loading Spinner -->
    <div id="spinner" class="loading-spinner d-flex">
        <div class="col align-self-center text-center">
            <img height="200px" width="200px" class="img-fluid bg-light p-1" src="/img/loading-bus.gif"
                alt="loading animation">
        </div>
    </div>

    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            {{-- Dropdown --}}
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse"
                    href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-white m-0"><i class="fa fa-bars mr-2"></i>Packages</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                    id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">
                        {{-- Replace with list of packages --}}
                        <a href="" class="nav-item nav-link">Dingalan</a>
                        <a href="" class="nav-item nav-link">Baguio</a>
                        <a href="" class="nav-item nav-link">Batangas</a>
                        <a href="{{ route('customer_booking_packages') }}"
                            class="nav-item nav-link btn btn-primary">View More</a>
                    </div>
                </nav>
            </div>
            {{-- Mobile Nav --}}
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Jet</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Bus</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('home') }}" class="nav-item nav-link active">Home</a>
                            <a href="{{ route('customer_booking_packages') }}" class="nav-item nav-link">Book</a>
                            <a href="{{ route('feedback.create') }}" class="nav-item nav-link">Feedback(Temp Route)</a>
                            <a href="{{ route('notifications') }}" class="nav-item nav-link">Notifs(Temp Route)</a>
                            <div class="dropdown-divider"></div>
                            @guest
                                <a href="{{ route('login') }}" class="nav-item nav-link d-block d-lg-none">Login</a>
                            @endguest
                            @auth
                                <a href="{{ route('home') }}" class="nav-item nav-link d-block d-lg-none">Notifications</a>
                                <a href="{{ route('customer_booking_list') }}"
                                    class="nav-item nav-link d-block d-lg-none">My Bookings</a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('admin_logout') }}"
                                    class="nav-item nav-link d-block d-lg-none">Logout</a>
                            @endauth

                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            @auth
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                        data-toggle="dropdown">My Account</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ route('customer_booking_list') }}" class="dropdown-item"
                                            type="button">My Bookings</a>
                                        <a href="{{ route('admin_logout') }}" class="dropdown-item"
                                            type="button">Logout</a>
                                    </div>
                                </div>
                                <div class="btn px-0 ml-3 dropleft">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                        id="notificationDropDown" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fas fa-bell text-white"></i>
                                        <span class="badge text-secondary border border-secondary rounded-circle"
                                            style="padding-bottom: 2px;">0</span>
                                    </button>
                                    <div style="width: 400px;" class="dropdown-menu"
                                        aria-labelledby="notificationDropDown">
                                        <h5 class="dropdown-header">Notifications</h5>
                                        <a class="dropdown-item" href="{{ route('notifications') }}">
                                            <div class="card border-0">
                                                <div class="d-flex justify-content-between  align-items-center">
                                                    <div class="d-flex  align-items-center">
                                                        <i style="font-size: 1.6em;"
                                                            class="fas fa-check-circle mr-2 text-primary"></i>
                                                        <small>Your booking has been approved.</small>
                                                    </div>
                                                    <small class="text-info">◉</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="{{ route('notifications') }}">
                                            <div class="card border-0">
                                                <div class="d-flex justify-content-between  align-items-center">
                                                    <div class="d-flex  align-items-center">
                                                        <i style="font-size: 1.6em;"
                                                            class="fas fa-times-circle mr-2 text-danger"></i>
                                                        <small>Your booking has been cancelled.</small>
                                                    </div>
                                                    <small class="text-info">◉</small>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('notifications') }}">View All</a>
                                    </div>
                                </div>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn px-0 ml-3 text-white">
                                    <i class="far fa-user-circle text-primary"></i>
                                    Login
                                </a>
                            @endguest

                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    @if (Session::has('success'))
        <div class="container-fluid">
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle mr-2" style="font-size: 2em;"></i>
                {{ Session::get('success') }}
            </div>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="container-fluid">
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class="fas fa-times-circle mr-2" style="font-size: 2em;"></i>
                {{ Session::get('error') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="container-fluid">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Content Start-->
    @yield('content')
    <!-- Content End-->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
                <p class="mb-4">Jet Bus Travel and Tours</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Sta. Maria 3022 Santa Maria,
                    Philippines</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>add.jetbustransport@yahoo.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>0917 907 2108</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="{{ route('home') }}"><i
                                    class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="{{ route('customer_booking_packages') }}"><i
                                    class="fa fa-angle-right mr-2"></i>Booking</a>
                            <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact
                                Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">My Account</h5>
                        <div class="d-flex flex-column justify-content-start">
                            @guest
                                <a class="text-secondary mb-2" href="{{ route('register') }}"><i
                                        class="fa fa-angle-right mr-2"></i>Register</a>
                                <a class="text-secondary mb-2" href="{{ route('login') }}"><i
                                        class="fa fa-angle-right mr-2"></i>Login</a>
                            @endguest
                            @auth
                                <a class="text-secondary mb-2" href="{{ route('customer_booking_list') }}"><i
                                        class="fa fa-angle-right mr-2"></i>My Bookings</a>
                                <a class="text-secondary mb-2" href="{{ route('admin_logout') }}"><i
                                        class="fa fa-angle-right mr-2"></i>Logout</a>
                            @endauth
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h6 class="text-secondary text-uppercase mb-3">Follow Us</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i
                                    class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="{{ route('home') }}">Jet Bus Travel and Tours</a>. All
                    Rights
                    Reserved
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img height="100px" width="70px" class="img-fluid bg-light p-1" src="/img/gcash.svg"
                    alt="pay with gcash">
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- Javascript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/lib/easing/easing.min.js"></script>
    <script src="/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="/js/main.js"></script>


    <!-- Custom JS -->
    <script>
        window.addEventListener("load", () => {
            document.querySelector("#spinner").remove();
        })
    </script>
    @yield('custom_scripts')
</body>

</html>
