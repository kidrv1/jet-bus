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
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Tables</li>
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
                            <h6>Bookings History</h6>

                            @include('shared.notification')
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Booking ID</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Bus Plate</th>

                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Package Name</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Inclusions</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tour Date</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Created</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Price</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Actions</th>

                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($packages as $package)
                                            <tr>
                                                <td class="align-middle text-center">
                                                    <details open>
                                                        <summary
                                                        class="text-secondary text-xs font-weight-bold">
                                                        #{{ $package->booking_id }}
                                                    </summary>
                                                    @isset($package->parent_id)
                                                        <sub>Addon For #{{ $package->parent_id }}</sub>
                                                    @endisset

                                                    </details>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2 py-1">

                                                        <div class="d-flex flex-column justify-content-center">
                                                            <span
                                                                class="text-secondary text-xs font-weight-bold">{{ $package->plate }}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $package->package_name }}</span>
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
                                                        class="text-secondary text-xs font-weight-bold">{{ $package->booking_date }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $package->created_at }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ number_format($package->package_rate) }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $package->status_name }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @if ($package->status_id < 3)
                                                        @if ($package->hasCancelRequest)
                                                            <button onclick="loadCancellationRequest('{{ $package->booking_id }}')" type="button" class="btn btn-danger btn-xs">CANCEL REQUESTED
                                                            </button>
                                                        @else
                                                            <button class="btn btn-danger btn-xs cancel-btn-data"
                                                                data-bs-toggle="modal" data-bs-target="#cancelModal"
                                                                value="{{ $package->booking_id }}">
                                                                CANCEL
                                                            </button>
                                                        @endif
                                                    @endif
                                                    @if ($package->status_id == 1)
                                                        <button class="btn btn-primary btn-xs payment"
                                                            data-bs-toggle="modal" data-bs-target="#paymentModal"
                                                            value="{{ $package->booking_id }}">
                                                            PAYMENT
                                                        </button>
                                                    @endif
                                                    @if ($package->status_id == 4)
                                                        <a href="{{ route('feedback.create') }}{{ '?q=' . $package->booking_id }}"
                                                            class="btn btn-success btn-xs">FEEDBACK
                                                        </a>
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


    {{-- Payment Modal --}}
    <div class="modal" id="paymentModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Upload Payment Receipt</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form role="form" action="{{ route('admin_payment') }}" method="POST"
                    enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">

                        @csrf
                        <input type="hidden" name="book_id" id="bookId">
                        <input type="file" name="payment_receipt" class="form-control" required>

                        <div class="form-group text-center">

                            <h4>Gcash Information</h4>
                            <p>09179072108</p>


                            <img src="{{ URL::to('gcash.png') }}" width="300px" height="300px">
                        </div>

                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Cancel Request Modal --}}
    <div class="modal" id="cancelModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Cancellation Request Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form role="form" action="{{ route('customer_booking_cancel_request') }}" method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-warning mt-1" role="alert">
                            <i class="fas fa-exclamation text-white"></i>
                            <small class="text-white">Once your cancellation is approved, a 20% cancellation fee will
                                be deducted from your payment.</small>
                        </div>
                        @csrf
                        <input type="hidden" name="booking_id" id="cancel_booking_id">
                        <div class="form-group">
                            <label class="h4" for="cancel-reason">Reason <sup class="text-danger">*</sup></label>
                            {{-- <input type="text" class="form-control" name="reason" id="cancel-reason" placeholder="reason for cancellation"> --}}
                            <textarea class="form-control" name="reason" id="cancel-reason" rows="3" placeholder="Please provide reasons for cancellation"></textarea>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Cancel Request View Modal --}}
    <div class="modal" id="cancelViewModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">View Cancellation Request</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form role="form" >
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="hidden" name="book_id" id="cancel_booking_id">
                        <div class="form-group">
                            <label class="h4" for="cancel-reason">Reason <sup class="text-danger">*</sup></label>
                            <textarea readonly class="form-control" id="cancel-reason-view" rows="3"></textarea>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
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
        const loadCancellationRequest = async (id) => {
            const reasonField = document.querySelector("#cancel-reason-view");

            const res = await fetch(`{{ route("customer_booking_cancel_show") }}/${id}`);

            if(!res.ok) {
                alert("Error loading cancel request");
                return;
            }

            const data = await res.json();
            const req = data.data;
            reasonField.value = req.reason;

            $('#cancelViewModal').modal('show');
        }

        $(document).ready(function() {
            var find_project_url = "#";
            var token = "{{ Session::token() }}";

            $(".payment").click(function() {
                var book_id = $(this).val();
                console.log(book_id);
                $("#bookId").val(book_id);
            });

            $(".cancel-btn-data").click(function() {
                const book_id = $(this).val();
                console.log(book_id);
                $("#cancel_booking_id").val(book_id);
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
