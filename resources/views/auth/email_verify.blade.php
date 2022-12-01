<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Jet Bus | Verify Email
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ URL::to('/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ URL::to('/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ URL::to('/assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />

    <style>
        .main-custom-bg {
            background-image: url({{ URL::to('img/login-bg.png') }});
            background-size: cover;
            position: relative;
            isolation: isolate;
        }

        .main-custom-bg::after {
            content: "";
            z-index: -1;
            inset: 0;
            position: absolute;
            background: black;
            opacity: 0.7;
        }
    </style>
</head>

<body class="">
    <main class="main-content main-custom-bg">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="card">

                                <div class="card-header pb-0 text-start">
                                @include('shared.notification')

                                    <a href="{{ route('home') }}">
                                        <center>
                                            <img src="{{ URL::to('logo.png') }}" class="img-thumbnail" height="200px"
                                                width="200px">
                                        </center>
                                    </a>
                                    <h4 class="font-weight-bolder text-center mt-4">Verify Email</h4>
                                </div>
                                <div class="card-body mt-0">
                                            <div class="card-body text-center">
                                                <small>Check your email address to verify your
                                                    account
                                                </small>
                                                <br>
                                                <br>
                                                <form action="{{ route('verification.send') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input class="btn btn-primary" type="submit" value="Send Verification Email">
                                                    </div>
                                                </form>
                                            </div>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ URL::to('/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ URL::to('/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ URL::to('/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ URL::to('/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ URL::to('/assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
</body>

</html>
