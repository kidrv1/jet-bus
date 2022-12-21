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

    <style>
        .hidden-print {
            display: none;
        }

        /* PRINT */
        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area-fixed {
                position: absolute;
                top: 0;
                left: 0;
                margin-top: -100px;
            }

            .hidden-print {
                display: block;
                visibility: visible;
            }

            /* .print-area {
                position: absolute;
                left: 0;
                top: 0;
            } */
        }
    </style>

    <link id="pagestyle" href="{{ URL::to('/assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
</head>

<body style="visibility: hidden">
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
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Top Sales Report</li>
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
                            <h6>Top Sales Report</h6>
                            <form method="GET">
                                @csrf
                                <input type="date" name="from_date" required>
                                <input type="date" name="to_date" required>
                                <button type="submit">Submit</button>
                            </form>
                            @include('shared.notification')
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0 print-area print-area-fixed">
                                <div class="print-header hidden-print text-dark text-center">
                                    <p>Jet Bus Travel and Tours</p>
                                    <p style="font-size: 0.5em; line-height: 0.5em;">
                                        Sta. Maria 3022 Santa Maria, Philippines
                                    </p>
                                    <p style="font-size: 0.5em; line-height: 0.5em;">
                                        09179072108
                                    </p>
                                    <p style="font-size: 0.5em; line-height: 0.5em;">
                                        add.jetbustransport@yahoo.com
                                    </p>
                                </div>
                                <table id="sales-table" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Package Name
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Booking Count
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Most Picked Addon
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Addon Count
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookingData as $package)
                                            <tr>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $package["package_name"] }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $package["count"] }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $package["top_addon"] }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $package["top_addon_count"] }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <button onclick="window.print()" class="btn btn-primary btn-xxs">Print</button>
                            <button onclick="exportTable()" class="btn btn-success btn-xxs">Export To Excel</button>
                        </div>

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

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ URL::to('/assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

    <script type="text/javascript">
        const exportTable = () => {
            $("#sales-table").table2excel({
                // exclude: ".excludeThisClass",
                name: "Top Sales",
                filename: "top_sales_export.xls",
                preserveColors: false
            });
        }
    </script>

    <script>
        function loadFunction() {
         window.print()
      }
      window.onload = loadFunction();
    </script>

</body>

</html>
