@extends("layout.layout")

@section("custom_styles")
<style>
    .notif-unread {
        cursor: pointer;
    }

    .notif-unread:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('custom_scripts')
    <script>
        const markAsRead = (el) => {
            // DO api stuff
            console.log(el.dataset.notifId);
            // update ui
            el.classList.remove("notif-unread");
            el.querySelector("h4").remove();
            el.onclick = null;
        }
    </script>
@endsection

@section("content")
<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route("home") }}">Home</a>
                <span class="breadcrumb-item active">Notifications</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<!-- Notifications Start -->
<div class="container-fluid">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Notifications</span>
    </h2>
    <div class="btn-group mx-xl-5 mb-4" role="group">
        <a href="{{ route("notifications", ["filter" => "all"]) }}" type="button" class="btn btn-primary">All</a>
        <a href="{{ route("notifications", ["filter" => "read"]) }}" type="button" class="btn btn-info">Read</a>
        <a href="{{ route("notifications", ["filter" => "unread"]) }}" type="button" class="btn btn-dark">Unread <span id="unread-count" class="badge badge-light">9</span></a>
    </div>
    <!-- Row Start -->
    <div class="row px-xl-5">

        {{-- Unread Example --}}
        <div class="card w-100 mb-3 notif-unread" data-notif-id="10" onclick="markAsRead(this)">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">
                        <i class="fas fa-check-circle mr-1 text-primary"></i>
                        Booking Approved
                    </h5>
                    <div>
                        <h4 class="text-info">◉</h4>
                    </div>
                </div>
                <p class="card-text">
                    Your booking for [Package Name] has been approved
                </p>
            </div>
            <div class="card-footer text-muted">
                Oct 28, 2022 03:48 AM, 2 days ago
            </div>
        </div>

        {{-- Read Example --}}
        <div class="card w-100 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">
                        <i class="fas fa-times-circle mr-1 text-danger"></i>
                        Booking Cancelled
                    </h5>
                    <div class="">
                        <h4 class="text-info">◉</h4>
                    </div>
                </div>
                <p class="card-text">
                    Your booking for [Package Name] was cancelled
                </p>
            </div>
            <div class="card-footer text-muted">
                Oct 29, 2022 04:48 AM, 1 day ago
            </div>
        </div>

    </div>
    <!-- Row End -->
</div>
<!-- Contact End -->
@endsection
