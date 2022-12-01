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
                <img src="{{ URL::to('/assets/img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
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
                        <li class="breadcrumb-item text-sm text-white" aria-current="page">Bus</li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Packages</li>
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
                            <h6>Bus Plate: {{ $bus->plate }} Package Lists</h6>
                            <button class="btn btn-info btn-xs edit" data-bs-toggle="modal"
                                data-bs-target="#createModal">Create</button>
                            @include('shared.notification')
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Package Name</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Price</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Inclusions</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Time</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Actions</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($packages as $package)
                                            <tr>

                                                <td>
                                                    <div class="d-flex px-2 py-1">

                                                        <div class="d-flex flex-column justify-content-center">
                                                            <span
                                                                class="text-secondary text-xs font-weight-bold">{{ $package->package_name }}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $package->package_rate }}</span>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        <?php
                                                        $inclusions = json_decode($package->inclusion);
                                                        ?>
                                                        @foreach ($inclusions as $inc)
                                                            {{ $inc }}<br>
                                                        @endforeach
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ date('h:i A', strtotime($package->start_time)) }}
                                                        - {{ date('h:i A', strtotime($package->end_time)) }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button onclick="editPackage('{{ $package->id }}')" class="btn btn-warning btn-xs">EDIT</button>
                                                    @if($bus->isActive)
                                                        @if($package->isActive)
                                                        <button onclick="toggleStatus('{{ $package->id }}', false)" class="btn btn-danger btn-xs">ARCHIVE</button>
                                                        <a href="{{ route("admin_package_addons.index", ["package_id" => $package->id]) }}" class="btn btn-info btn-xs">ADDONS</a>
                                                        @else
                                                        <button onclick="toggleStatus('{{ $package->id }}', true)" class="btn btn-success btn-xs">RESTORE</button>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-danger btn-xs">BUS ARCHIVED</button>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </main>
    {{-- Create Modal --}}
    <div class="modal" id="createModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Enter Package Informations</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form role="form" action="{{ route('admin_bus_package_check') }}" method="POST"
                    enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">

                        @csrf
                        <input type="hidden" name="bus_id" id="bus_id" value="{{ Request::segment(3) }}">

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label>Depart Time</label>
                                    <input type="time" class="form-control" name="start_time" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label>Arrive Time</label>
                                    <input type="time" class="form-control" name="end_time" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Package Name</label>
                            <input type="text" name="package_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Package Rate</label>
                            <input type="number" name="package_rate" class="form-control" required value="10000">
                        </div>

                        <div class="mb-3">
                            <label>Inclusions</label></br>
                            <input type="checkbox" name="inclusion[]" value="Gas Fee" /> Gas Fee </br>
                            <input type="checkbox" name="inclusion[]" value="Toll Gate Fee" /> Toll Gate Fee </br>
                            <input type="checkbox" name="inclusion[]" value="Tour Fee (activities, itinerary)" />
                            Tour Fee (activities, itinerary) </br>
                            <input type="checkbox" name="inclusion[]" value="Driver Fee" /> Driver Fee </br>
                        </div>



                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- Edit Modal --}}
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Update Package Informations</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form role="form" action="{{ route('admin_update_package') }}" method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">

                        @csrf
                        <input type="hidden" name="package_id" id="edit-package-id">

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label>Depart Time</label>
                                    <input type="time" id="edit-package-depart" class="form-control" name="start_time" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label>Arrive Time</label>
                                    <input type="time" id="edit-package-arrive" class="form-control" name="end_time" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Package Name</label>
                            <input type="text" id="edit-package-name" name="package_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Package Rate</label>
                            <input type="number" id="edit-package-rate" name="package_rate" class="form-control" required value="10000">
                        </div>

                        <div class="mb-3">
                            <label>Inclusions</label></br>
                            <input id="edit-package-gas" type="checkbox" name="inclusion[]" value="Gas Fee" /> Gas Fee </br>
                            <input id="edit-package-toll" type="checkbox" name="inclusion[]" value="Toll Gate Fee" /> Toll Gate Fee </br>
                            <input id="edit-package-tour" type="checkbox" name="inclusion[]" value="Tour Fee (activities, itinerary)" />
                            Tour Fee (activities, itinerary) </br>
                            <input id="edit-package-driver" type="checkbox" name="inclusion[]" value="Driver Fee" /> Driver Fee </br>
                        </div>



                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Status Modal --}}
    <div class="modal" id="status-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="status-modal-title">Loading...</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
                </div>

                <form role="form" action="{{ route("admin_update_package_status") }}" method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="package_id" id="status-modal-id">
                        <input type="hidden" name="status" id="status-modal-status">
                        Are you sure?
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary">Yes</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        const toggleStatus = async (busId, status) => {
            const titleField = document.querySelector("#status-modal-title");
            const idField = document.querySelector("#status-modal-id");
            const statusField = document.querySelector("#status-modal-status");

            idField.value = busId;

            if (status) {
                titleField.innerText = "Restore Package"
                statusField.value = 1;

            } else {
                titleField.innerText = "Archive Package"
                statusField.value = 0;
            }

            $('#status-modal').modal('show');
        }

        const editPackage = async (id) => {
            const res = await fetch("{{ route('admin_find_package') }}", {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-type": "application/json",
                    "X-CSRF-Token": '{{ Session::token() }}'
                },
                body: JSON.stringify({
                    package_id: id
                })
            })
            const data = await res.json();

            document.querySelector("#edit-package-id").value = data.id;
            document.querySelector("#edit-package-depart").value = data.start_time;
            document.querySelector("#edit-package-arrive").value = data.end_time;
            document.querySelector("#edit-package-name").value = data.package_name;
            document.querySelector("#edit-package-rate").value = data.package_rate;

            const inclusions = JSON.parse(data.inclusion);
            for(const i of inclusions) {
                if(i == "Gas Fee") document.querySelector("#edit-package-gas").checked = true;
                if(i == "Toll Gate Fee") document.querySelector("#edit-package-toll").checked = true;
                if(i == "Tour Fee (activities, itinerary)") document.querySelector("#edit-package-tour").checked = true;
                if(i == "Driver Fee") document.querySelector("#edit-package-driver").checked = true;
            }

            $('#editModal').modal('show');

        }

        $(document).ready(function() {
            var find_project_url = "{{ route('admin_find_bus') }}";
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

            $(".updateBus").click(function() {
                var bus_id = $(this).val();
                $("#updateBus").val(bus_id);
                $.ajax({
                    type: 'POST',
                    url: find_project_url,
                    data: {
                        _token: token,
                        bus_id: bus_id
                    },
                    success: function(data) {
                        console.log(data);
                        $("#bus_id").val(data.id);

                        $("#ac").val(data.ac);
                        $("#fuel").val(data.fuel);
                        $("#model").val(data.model);
                        $("#plate").val(data.plate);
                        $("#seaters").val(data.seaters);


                    }
                });


            });

        });
    </script>
</body>

</html>
