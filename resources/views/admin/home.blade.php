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

            .customer-btn{
                display: none !important;
            }

            .customer-actions{
                display: none !important;
            }

            /* .print-area {
                position: absolute;
                left: 0;
                top: 0;
            } */
        }
    </style>
</head>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="# " target="_blank">
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
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Customer Lists</li>
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
                            <h6>Customer Table</h6>
                            <div class="float-end">
                                <h6>Total Users: {{count($users)}}</h6>
                            </div>
                            <button class="btn btn-info btn-xs edit" data-bs-toggle="modal"
                                data-bs-target="#createModal">Create</button>
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
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Valid ID</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Vaccinaiton Id</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Gender</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Contact</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Email</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                User Type</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 customer-actions">
                                                Actions</th>

                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $user->first_name }} {{ $user->last_name }}</p>
                                                        </div>
                                                </td>

                                                <td class="align-middle text-center text-sm">

                                                    <img src="{{ URL::to('public') }}/{{ $user->valid_id }}"
                                                        alt="Card image" width="120px" height="120px">

                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <img src="{{ URL::to('public') }}/{{ $user->vaccine_id }}"
                                                        alt="Card image" width="120px" height="120px">

                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs text-secondary mb-0">{{ $user->gender }}</p>

                                                </td>

                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm bg-gradient-primary">{{ $user->mobile }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm bg-gradient-info">{{ $user->email }}</span>
                                                </td>

                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm bg-gradient-info">{{ $user->getRoleNames()[0] }}</span>
                                                </td>

                                                <td class="align-middle text-center text-sm">
                                                    @if ($user->status_id == 1)
                                                        <span
                                                            class="badge badge-sm bg-gradient-secondary">{{ $user->status->name }}</span>
                                                    @elseif($user->status_id == 2)
                                                        <span
                                                            class="badge badge-sm bg-gradient-success">{{ $user->status->name }}</span>
                                                    @endif

                                                </td>

                                                <td class="align-middle customer-btn">
                                                    <button class="btn btn-info btn-xs edit" data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        value="{{ $user->id }}">Edit</button>
                                                    @if ($user->status_id == 1)
                                                    <a href="{{ route('admin_user_approve', $user->id) }}"
                                                        class="btn btn-warning btn-xs">Approve</a>
                                                    @elseif($user->status_id == 2)
                                                    <button class="btn btn-danger btn-xs archive"
                                                        value="{{ $user->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal"
                                                        value="{{ $user->id }}">Archive</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <button onclick="window.print()" class="btn btn-primary btn-xxs">Print</button>
                        </div>
                    </div>
                    
                </div>
            </div>


        </div>
    </main>

    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Update Customer Informations</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form role="form" action="{{ route('admin_update_user') }}" method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">

                        @csrf
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="First Name" aria-label="Name"
                                name="first_name" required id="first_name">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Last Name" aria-label="Name"
                                name="last_name" required id="last_name">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email" aria-label="Email"
                                name="email" required id="email">
                        </div>

                        <div class="mb-3">
                            <label>Gender</label>
                            <select class="form-control" name="gender" required id="gender">
                                <option value="female">Female</option>
                                <option value="male">Male</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label>User Type</label>
                            <select class="form-control" name="position" required id="position">
                                <option value="1">STAFF</option>
                                <option value="2">CUSTOMER</option>

                            </select>
                        </div>





                        <div class="mb-3">
                            <label>Mobile#</label>
                            <input type="text" class="form-control" id="mobile" placeholder="Mobile Number"
                                aria-label="Mobile Number" name="mobile" maxlength="12">
                        </div>





                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-dark">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Are you sure you want to deactivate this user?</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin_delete_user') }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="delete_user_id">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Confirm</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal" id="createModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Enter Customer Informations</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form role="form" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">

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
                            <input type="email" class="form-control" placeholder="Email" aria-label="Email"
                                name="email" required id="email">
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
                            <input type="text" class="form-control" placeholder="Enter Password"
                                aria-label="Password" name="password" required>
                        </div>




                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-dark ">Submit</button>
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
        $(document).ready(function() {
            var find_user_url = "{{ route('admin_find_user') }}";
            var token = "{{ Session::token() }}";
            $(".edit").click(function() {
                var user_id = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: find_user_url,
                    data: {
                        _token: token,
                        user_id: user_id
                    },
                    success: function(data) {
                        console.log(data);
                        $("#first_name").val(data.first_name);
                        $("#last_name").val(data.last_name);
                        $("#email").val(data.email);
                        $("#mobile").val(data.mobile);
                        $("#gender").val(data.gender);
                        $("#user_id").val(user_id);
                        $("#position").val(data.position)
                    }
                });

            });

            $(".archive").click(function() {
                var user_id = $(this).val();
                $("#delete_user_id").val(user_id);
            });
        });
    </script>
</body>

</html>
