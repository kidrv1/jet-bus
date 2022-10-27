<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        DocuArk
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{URL::to('/assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{URL::to('/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{URL::to('/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{URL::to('/assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />
</head>

<body class="">
    <!-- Navbar -->

    <!-- End Navbar -->
    <main class="main-content  mt-0">

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route("home") }}">
                        <center>
                            <img src="{{URL::to('logo.jpg')}}" class="img-thumbnail" height="200px" width="200px">
                        </center>
                    </a>
                    <h4 class="font-weight-bolder text-center">Sign Up</h4>
                    @include('shared.notification')
                    <form role="form" action="{{route('register')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label>VALID ID</label>
                                    <input type="file" class="form-control" name="valid_id" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label>VACINATION ID</label>
                                    <input type="file" class="form-control" name="vaccine_id" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="First Name" aria-label="Name"
                                name="first_name" required id="first_name">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Last Name" aria-label="Name"
                                name="last_name" required id="last_name">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email" aria-label="Email" name="email"
                                required id="email">
                        </div>

                        <div class="mb-3">
                            <label>Gender</label>
                            <select class="form-control" name="gender" required>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label>User Type</label>
                            <select class="form-control" name="position" required>
                                <option value="1">STAFF</option>
                                <option value="2">CUSTOMER</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Mobile#</label>
                            <input type="text" class="form-control" placeholder="Mobile Number"
                                aria-label="Mobile Number" name="mobile" maxlength="12">
                        </div>

                        <div class="mb-3">
                            <label>Enter Password</label>
                            <input type="password" class="form-control" placeholder="Enter Password"
                                aria-label="Password" name="password" required>
                        </div>

                        <div class="d-flex  justify-content-between align-items-center">
                            <button type="submit" class="btn bg-gradient-dark">Submit</button>
                            <span>Already have an account? <a href="{{url('/login')}}" class="">Login</a></span>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->

    <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <!--   Core JS Files   -->
    <script src="{{URL::to('/assets/js/core/popper.min.js')}}"></script>
    <script src="{{URL::to('/assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{URL::to('/assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{URL::to('/assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
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
    <script src="{{URL::to('/assets/js/argon-dashboard.min.js?v=2.0.4')}}"></script>
</body>

</html>
