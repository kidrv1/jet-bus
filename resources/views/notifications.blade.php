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
        const markAsRead = async (el) => {
            // DO api stuff
            const res = await fetch("{{ route('notifications.update') }}" + `?q=${el.dataset.notifId}`, {
                method: 'PUT',
                headers: {
                    "X-CSRF-Token": '{{ Session::token() }}'
                }
            })

            el.classList.remove("notif-unread");
            el.querySelector("h4").remove();
            el.onclick = null;
            await countUnread();
        }

        const countUnread = async() => {
            const counter = document.querySelector("#unread-count");

            const res = await fetch("{{ route('notifications.unreadCount') }}");
            const data = await res.json();

            counter.innerText = data?.count ?? '!';

            await countUnreadNotif();
        }

        countUnread();

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
        <a href="{{ route("notifications", ["filter" => "unread"]) }}" type="button" class="btn btn-dark">Unread <span id="unread-count" class="badge badge-light">-</span></a>
    </div>
    <!-- Row Start -->
    <div class="row px-xl-5">
        @forelse ($notifications as $notif)
            <div class="card w-100 mb-3 {{ $notif->isRead ? '' : 'notif-unread' }}" data-notif-id="{{ $notif->id }}" onclick="{{ $notif->isRead ? '' : 'markAsRead(this)' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">
                            <i class="fas fa-check-circle mr-1 text-primary"></i>
                            {{ $notif->subject }}
                        </h5>
                        <div>
                            @if($notif->isRead == false)
                                <h4 class="text-info">◉</h4>
                            @endif
                        </div>
                    </div>
                    <p class="card-text">
                        {{ $notif->message }}
                    </p>
                </div>
                <div class="card-footer text-muted">
                    {{ date("M d, Y", strtotime($notif->created_at)) }}, {{ date('h:i A', strtotime($notif->created_at)) }}
                </div>
            </div>
        @empty
            <div class="d-flex justify-content-center mx-auto">
                <h3>No Notifications</h3>
            </div>
        @endforelse


    </div>
    <!-- Row End -->
</div>
<!-- Contact End -->
@endsection
