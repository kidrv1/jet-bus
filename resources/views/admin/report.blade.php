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
                            <div class="container-fluid">
                                <a href="{{ route('admin_latest_sale','daily')}}" target="_blank" class="btn btn-primary btn-xxs">Print</a>
                                <a href="{{ route('admin_latest_sale_xls','daily')}}" target="_blank" class="btn btn-success btn-xxs">Export</a>
                            </div>
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
                            <div class="container-fluid">
                                <a href="{{ route('admin_latest_sale','monthly')}}" target="_blank" class="btn btn-primary btn-xxs">Print</a>
                                <a href="{{ route('admin_latest_sale_xls','monthly')}}" target="_blank" class="btn btn-success btn-xxs">Export</a>
                            </div>
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
                            <div class="container-fluid">
                                <a href="{{ route('admin_latest_sale','yearly')}}" target="_blank" class="btn btn-primary btn-xxs">Print</a>
                                <a href="{{ route('admin_latest_sale_xls','yearly')}}" target="_blank" class="btn btn-success btn-xxs">Export</a>
                       
                            </div>
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

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Register User</h6>

                            @include('shared.notification')
                        </div>
                        <div class="card-body">
                            <h1>Daily Chart</h1>
                            <div class="container-fluid">
                                <a href="{{ route('admin_latest_user','daily')}}" target="_blank" class="btn btn-primary btn-xxs">Print</a>
                                <a href="{{ route('admin_latest_user_xls','daily')}}" target="_blank" class="btn btn-success btn-xxs">Export</a>
                            </div>
                            <div class="table-responsive">
                                <div>
                                    <a href="{{ route("home") }}">
                                        <canvas id="dailyChart_cust"></canvas>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1>Monthly Chart</h1>
                            <div class="container-fluid">
                                <a href="{{ route('admin_latest_user','monthly')}}" target="_blank" class="btn btn-primary btn-xxs">Print</a>
                                <a href="{{ route('admin_latest_user_xls','monthly')}}" target="_blank" class="btn btn-success btn-xxs">Export</a>
                            </div>
                            <div class="table-responsive">
                                <div>
                                    <a href="{{ route("home") }}">
                                        <canvas id="myChart_cust"></canvas>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <h1>Yearly Chart</h1>
                            <div class="container-fluid">
                                <a href="{{ route('admin_latest_user','yearly')}}" target="_blank" class="btn btn-primary btn-xxs">Print</a>
                                <a href="{{ route('admin_latest_user_xls','yearly')}}" target="_blank" class="btn btn-success btn-xxs">Export</a>
                            </div>
                            <div class="table-responsive">
                                
                                <div>
                                    
                                    <a href="{{ route("home") }}">
                                        <canvas id="yearlyChart_cust"></canvas>
                                    </a>
                                </div>
                            </div>
                        </div>


                        
                        <hr>
                    </div>
                </div>
            </div>




        </div>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Popular Items</h6>

                            @include('shared.notification')
                        </div>
                        

                        <div class="card-body">
                            <h1>Monthly Chart</h1>
                            <div class="container-fluid">
                                <a href="{{ route('admin_latest_popular','monthly')}}" target="_blank" class="btn btn-primary btn-xxs">Print</a>
                                <a href="{{ route('admin_latest_popular_xls','monthly')}}" target="_blank" class="btn btn-success btn-xxs">Export</a>
                            </div>
                            <div class="table-responsive">
                                <div>
                                    <a href="{{ route("admin_stats_index") }}">
                                        <canvas id="myChart_pop"></canvas>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1>Yearly Chart</h1>
                            <div class="container-fluid">
                                <a href="{{ route('admin_latest_popular','yearly')}}" target="_blank" class="btn btn-primary btn-xxs">Print</a>
                                <a href="{{ route('admin_latest_popular_xls','yearly')}}" target="_blank" class="btn btn-success btn-xxs">Export</a>
                            </div>
                            <div class="table-responsive">
                                <div>
                                    <a href="{{ route("admin_stats_index") }}">
                                        <canvas id="yearChart_pop"></canvas>
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

    <script>
        
    </script>
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
    <script type="text/javascript">
        var labels_cust = {{ Js::from($labels_cust) }};
        var users_cust = {{ Js::from($data_cust) }};
        

        const dayLabels_cust = {{ Js::from($dayLabels_cust) }};
        const dayData_cust = {{ Js::from($dayData_cust) }};
       

        const yearLabels_cust = {{ Js::from($yearLabels_cust) }};
        const yearData_cust = {{ Js::from($yearData_cust) }};
        
        const data_cust = {
            labels: labels_cust,
            datasets: [
            {
                label: 'Monthly Registered ' + new Date().getFullYear(),
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: users_cust,
            },
           
        ]
        };

        const config_cust = {
            type: 'line',
            data: data_cust,
            options: {}
        };

        const myChart_cust = new Chart(
            document.getElementById('myChart_cust'),
            config_cust
        );

        const dayDataSet_cust = {
            labels: dayLabels_cust,
            datasets: [
            {
                label: 'Daily Registered',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: dayData_cust,
            },
            
        ]
        };

        const dayConfig_cust = {
            type: 'line',
            data: dayDataSet_cust,
            options: {}
        };

        const dailyChart_cust = new Chart(
            document.getElementById('dailyChart_cust'),
            dayConfig_cust
        );

        const yearDataSet_cust = {
            labels: yearLabels_cust,
            datasets: [
            {
                label: 'Yearly Registered',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: yearData_cust,
            },
            
        ]
        };



        const yearConfig_cust = {
            type: 'line',
            data: yearDataSet_cust,
            options: {}
        };

        const yearlyChart_cust = new Chart(
            document.getElementById('yearlyChart_cust'),
            yearConfig_cust
        );

        var labels_pop_m = {{ Js::from($package_labels_m) }};
        var count_package_labels_pop_m = {{ Js::from($package_count_labels_m) }};
        var count_addon_labels_pop_m = {{ Js::from($package_addoncount_labels_m) }};
        const labels_pop = labels_pop_m;
        const data_pop = {
        labels: labels_pop,
        
        datasets: [{
                data: count_package_labels_pop_m,
                label: 'Package',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
            },{
                data: count_addon_labels_pop_m,
                label: 'Addons',
                backgroundColor: 'rgb(132, 99, 255)',
                borderColor: 'rgb(132, 99, 255)',
            }]
        };

        const monthlyConfig_pop = {
            type: 'bar',
            data: data_pop,
            options: {
                indexAxis: 'y',
            
            }
        };
        const monthlyChart_pop = new Chart(
            document.getElementById('myChart_pop'),
            monthlyConfig_pop
        );

        
        var labels_pop_y = {{ Js::from($package_labels_y) }};
        var count_package_labels_pop_y = {{ Js::from($package_count_labels_y) }};
        var count_addon_labels_pop_y = {{ Js::from($package_addoncount_labels_y) }};
        const labels_pop_yy = labels_pop_y;
        const data_pop_y = {
        labels: labels_pop_yy,
        
        datasets: [{
                data: count_package_labels_pop_y,
                label: 'Package',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
            },{
                data: count_addon_labels_pop_y,
                label: 'Addons',
                backgroundColor: 'rgb(132, 99, 255)',
                borderColor: 'rgb(132, 99, 255)',
            }]
        };

        const yearConfig_pop_y = {
            type: 'bar',
            data: data_pop_y,
            options: {
                indexAxis: 'y',
            
            }
        };
        const yearChart_pop = new Chart(
            document.getElementById('yearChart_pop'),
            yearConfig_pop_y
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
