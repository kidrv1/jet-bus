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
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Bus</li>
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
                            <h6>Bus Lists</h6>
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
                                                Image</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Model</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Plate</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                AC</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Seaters</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Fuel</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Actions</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($buses as $bus)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">

                                                        <div class="d-flex flex-column justify-content-center">
                                                            <img src="/public/public/{{ $bus->image }}"
                                                                width="100px" height="80px">

                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $bus->model }}</span>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $bus->plate }}</span>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $bus->ac }}</span>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $bus->seaters }}</span>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $bus->fuel }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-info btn-xs updateBus"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        value="{{ $bus->id }}">EDIT</button>
                                                    @if($bus->isActive)
                                                    <button onclick="toggleStatus('{{ $bus->id }}', false)" class="btn btn-danger btn-xs">ARCHIVE</button>
                                                    @else
                                                    <button onclick="toggleStatus('{{ $bus->id }}', true)" class="btn btn-success btn-xs">RESTORE</button>
                                                    @endif
                                                    <a href="{{ route('admin_bus_package', $bus->id) }}"
                                                        class="btn btn-primary btn-xs">PACKAGE</a>
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
    <div class="modal" id="createModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Enter Bus Informations</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form role="form" action="{{ route('admin_bus_check') }}" method="POST"
                    enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">

                        @csrf

                        <div class="mb-3">
                            <label>Bus Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Air Condition</label>
                            <select class="form-control" required name="ac">
                                <option value="YES">YES</option>
                                <option value="NO">NO</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Fuel Type</label>
                            <select class="form-control" required name="fuel">
                                <option value="GAS">GAS</option>
                                <option value="DIESEL">DIESEL</option>

                            </select>
                        </div>



                        <div class="mb-3">
                            <label>Model</label>
                            <input type="text" class="form-control" placeholder="Name" aria-label="Name"
                                name="model" required id="name">
                        </div>

                        <div class="mb-3">
                            <label>Plate No.</label>
                            <input type="text" class="form-control" placeholder="Name" aria-label="Name"
                                name="plate" required id="name">
                        </div>

                        <div class="mb-3">
                            <label>Number of Seats</label>
                            <input type="number" class="form-control" placeholder="Name"
                                aria-label="Total Number of Seats" name="seaters" required id="name"
                                step="1" value="1">
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

    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Update Bus Informations</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form role="form" action="{{ route('admin_update_bus') }}" method="POST"
                    enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">

                        @csrf
                        <input type="hidden" name="bus_id" id="bus_id">


                        <div class="mb-3">
                            <label>Air Condition</label>
                            <select class="form-control" required name="ac" id="ac">
                                <option value="YES">YES</option>
                                <option value="NO">NO</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Fuel Type</label>
                            <select class="form-control" required name="fuel" id="fuel">
                                <option value="GAS">GAS</option>
                                <option value="DIESEL">DIESEL</option>

                            </select>
                        </div>



                        <div class="mb-3">
                            <label>Model</label>
                            <input type="text" class="form-control" placeholder="Name" aria-label="Name"
                                name="model" required id="model">
                        </div>

                        <div class="mb-3">
                            <label>Plate No.</label>
                            <input type="text" class="form-control" placeholder="Name" aria-label="Name"
                                name="plate" required id="plate">
                        </div>

                        <div class="mb-3">
                            <label>Number of Seats</label>
                            <input type="number" class="form-control" placeholder="Name"
                                aria-label="Total Number of Seats" name="seaters" required id="seaters"
                                step="1" value="1">
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

    <div class="modal" id="status-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="status-modal-title">Loading...</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
                </div>

                <form role="form" action="{{ route("admin_bus_status") }}" method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="bus_id" id="status-modal-id">
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

            if(status) {
                titleField.innerText = "Restore Bus"
                statusField.value = 1;

            } else {
                titleField.innerText = "Archive Bus"
                statusField.value = 0;
            }

            $('#status-modal').modal('show');
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
