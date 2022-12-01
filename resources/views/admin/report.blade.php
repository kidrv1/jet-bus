<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Dashboard
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
</head>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" # " target="_blank">
                <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>

            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            @include('shared.side')
        </div>

    </aside>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                                href="javascript:;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Sales Visualization</li>
                    </ol>

                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                    </div>
                    <ul class="navbar-nav  justify-content-end">

                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Sales Visual Report</h6>

                            @include('shared.notification')
                        </div>
                        <div class="card-body">
                            <h1>Daily Chart</h1>
                            <div class="table-responsive">
                                <div>
                                    <a href="{{ route("admin_sales") }}">
                                        <canvas id="dailyChart"></canvas>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1>Monthly Chart</h1>
                            <div class="table-responsive">
                                <div>
                                    <a href="{{ route("admin_sales") }}">
                                        <canvas id="myChart"></canvas>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1>Yearly Chart</h1>
                            <div class="table-responsive">
                                <div>
                                    <a href="{{ route("admin_sales") }}">
                                        <canvas id="yearlyChart"></canvas>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>




        </div>
    </main>

    <!--   Core JS Files   -->

    <script src="{{ URL::to('/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ URL::to('/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ URL::to('/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ URL::to('/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript">
        var labels = {{ Js::from($labels) }};
        var users = {{ Js::from($data) }};
        const addonUsers = {{ Js::from($addonData) }};

        const dayLabels = {{ Js::from($dayLabels) }};
        const dayData = {{ Js::from($dayData) }};
        const dayAddons = {{ Js::from($dayAddons) }};

        const yearLabels = {{ Js::from($yearLabels) }};
        const yearData = {{ Js::from($yearData) }};
        const yearAddons = {{ Js::from($yearAddons) }};

        const data = {
            labels: labels,
            datasets: [
            {
                label: 'Monthly Sales ' + new Date().getFullYear(),
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: users,
            },
            {
                label: 'Monthly Addons ' + new Date().getFullYear(),
                backgroundColor: 'rgb(132, 99, 255)',
                borderColor: 'rgb(132, 99, 255)',
                data: addonUsers,
            }
        ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        const dayDataSet = {
            labels: dayLabels,
            datasets: [
            {
                label: 'Daily Sales',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: dayData,
            },
            {
                label: 'Daily Addons',
                backgroundColor: 'rgb(132, 99, 255)',
                borderColor: 'rgb(132, 99, 255)',
                data: dayAddons,
            }
        ]
        };

        const dayConfig = {
            type: 'line',
            data: dayDataSet,
            options: {}
        };

        const dailyChart = new Chart(
            document.getElementById('dailyChart'),
            dayConfig
        );

        const yearDataSet = {
            labels: yearLabels,
            datasets: [
            {
                label: 'Yearly Sales',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: yearData,
            },
            {
                label: 'Yearly Addons',
                backgroundColor: 'rgb(132, 99, 255)',
                borderColor: 'rgb(132, 99, 255)',
                data: yearAddons,
            }
        ]
        };

        const yearConfig = {
            type: 'line',
            data: yearDataSet,
            options: {}
        };

        const yearlyChart = new Chart(
            document.getElementById('yearlyChart'),
            yearConfig
        );
    </script>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var find_project_url = "#";
            var token = "{{ Session::token() }}";

            $(".archive").click(function() {
                var project_id = $(this).val();
                $("#statusProjectId").val(project_id);

            });

            $(".completed").click(function() {
                var project_id = $(this).val();
                $("#completedProject").val(project_id);

            });

            $(".assign").click(function() {
                var project_id = $(this).val();
                $("#assignTask").val(project_id);

            });

            $(".updateProject").click(function() {
                var project_id = $(this).val();
                $("#updateProjectId").val(project_id);
                $.ajax({
                    type: 'POST',
                    url: find_project_url,
                    data: {
                        _token: token,
                        project_id: project_id
                    },
                    success: function(data) {
                        console.log(data);
                        $("#editTitle").val(data.title);
                        $("#editDescription").val(data.description);

                    }
                });


            });

        });
    </script>

</body>

</html>
