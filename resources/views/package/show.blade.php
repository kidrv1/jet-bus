@extends('layout.layout')

@section('custom_styles')
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
.datepicker td,th{
    text-align: center;
    padding: 8px 12px;
    font-size: 14px;
}

td.day{
    position:relative;
}

td.day.disabled:hover:before {
    content: 'Minimum 7 Days Advance';
    color: var(--gray);
    background-color: white;
    top: -22px;
    position: absolute;
    width: 136px;
    left: -34px;
    z-index: 1000;
    text-align: center;
    padding: 2px;
    border: 1px solid black;
}

td.day.disabled {
    background: rgb(126, 121, 121) !important;
}

td.day.disabled-date {
    background: rgb(168, 104, 104) !important;
}

td.day.disabled-date:hover:before {
    content: 'Reserved';
    color: var(--gray);
    background-color: white;
    top: -22px;
    position: absolute;
    width: 136px;
    left: -34px;
    z-index: 1000;
    text-align: center;
    padding: 2px;
}
</style>
@endsection

@section('custom_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const reservedDates = @json($reserved_dates);
        $(document).ready(function() {
            $('#addons-dropdown').select2();

            $('#booking-date-input').datepicker({
                format: 'mm/dd/yyyy',
                startDate: "+7d",
                uiLibrary: 'bootstrap4',
                datesDisabled: reservedDates,
                todayHighlight: true,
            });

            $('#booking-date-end-input').datepicker({
                format: 'mm/dd/yyyy',
                startDate: "+7d",
                uiLibrary: 'bootstrap4',
                todayHighlight: true,
            });
        });


        const addToCart = async () => {
            const btn = document.querySelector("#add-to-cart-btn");
            const dateInput = document.querySelector("#booking-date-input");
            const dateInputEnd = document.querySelector("#booking-date-end-input");
            const addonsValues = $('#addons-dropdown').val()
            const viewCart = document.querySelector("#view-cart-btn");
            const flashMessage = document.querySelector("#cart-message");

            flashMessage.classList.add('invisible');
            if(!dateInput.value) {
                flashMessage.innerText = 'Please set a date';
                flashMessage.classList.remove('invisible');
                return;
            }

            dateInput.readOnly = true;
            btn.disabled = true;

            // api call
            const res = await fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    "X-CSRF-Token": '{{ Session::token() }}',
                    "Content-Type": 'application/json'
                },
                body: JSON.stringify({
                    package_id: {{ $package->id }},
                    booking_date: dateInput.value,
                    booking_date_end: dateInputEnd.value,
                    addons: addonsValues
                })
            })
            const data = await res.json();

            if(res.ok) {
                await loadCartCount();
                flashMessage.classList.remove('invisible');
                viewCart.classList.remove('invisible');
                btn.remove();
                flashMessage.querySelector('small').innerText = 'Added to cart!';
            }
        }
    </script>
@endsection

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route("home") }}">Home</a>
                    <span class="breadcrumb-item active">Package</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="/public/{{ $package->bus->image}}" alt="Bus image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $package->package_name }}</h3>
                    <h3 class="font-weight-semi-bold mb-4">&#8369; {{ number_format($package->package_rate, 2) }}</h3>
                    <p class="mb-4">
                        {{ date('h:i A', strtotime($package->start_time)) }} - {{ date('h:i A', strtotime($package->end_time)) }}
                    </p>
                    <div class="mb-3">
                        <strong class="text-dark mr-3">Inclusions:</strong><br>
                        <ul class="list-group list-group-flush">
                            @forelse ($inclusions as $inclusion)
                                <li class="list-group-item">{{ $inclusion }}</li>
                            @empty
                                <li class="list-group-item">None</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Buttons --}}
                    @if ($package->isActive == true)
                    <label>
                        <strong>Booking Start:</strong>
                        <input
                            id="booking-date-input"
                            class="datepicker form-control form-control-sm text-center"
                            @if ($inCart != null)
                                readonly
                                disabled
                                value="{{ $inCart->booking_date->isoFormat('YYYY-MM-DD') }}"
                            @else
                                min="{{ now()->addDays(7)->isoFormat('YYYY-MM-DD') }}"
                            @endif
                        >
                    </label>
                    <label>
                        <strong>Booking End:</strong>
                        <input
                            id="booking-date-end-input"
                            class="datepicker form-control form-control-sm text-center"
                            @if ($inCart != null)
                                readonly
                                disabled
                                value="{{ $inCart->booking_date_end->isoFormat('YYYY-MM-DD') }}"
                            @else
                                min="{{ now()->addDays(7)->isoFormat('YYYY-MM-DD') }}"
                            @endif
                        >
                    </label>
                    <div class="form-group">
                        <label for="addons-dropdown">
                            <strong>Addons</strong>
                        </label>
                        <select class="form-control" id="addons-dropdown" name="addons[]" multiple="multiple" @if ($inCart != null) disabled @endif>
                            @foreach ($package->addons as $addon)
                                <option
                                    value="{{ $addon->id }}">&#8369;{{ $addon->price }} - {{ $addon->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex align-items-center pt-2">
                        <button
                            type="button"
                            class="btn btn-danger px-3 mr-2"
                            onclick="history.go(-1)">
                            <i class="fas fa-chevron-left mr-1"></i>
                            Back
                        </button>
                        @if ($inCart == null)
                            @auth
                            <button
                                id="add-to-cart-btn"
                                class="btn btn-primary px-3"
                                type="button"
                                onclick="addToCart()">
                                <i class="fa fa-shopping-cart mr-1"></i>
                                Add To Cart
                            </button>
                            @else
                            <a
                                href="{{ route("login") }}"
                                class="btn btn-primary px-3">
                                <i class="fa fa-shopping-cart mr-1"></i>
                                Add To Cart
                            </a>
                            @endauth
                        @endif
                        <a
                            id="view-cart-btn"
                            class="btn btn-primary px-3 {{ $inCart != null ? '' : 'invisible' }}"
                            href="{{ route('my_cart') }}">
                            <i class="fa fa-shopping-cart mr-1"></i>
                            View Cart
                        </a>
                    </div>
                    <p
                        id="cart-message"
                        class="mt-3 bg-light text-primary p-2 border border-bottom {{ $inCart != null ? '' : 'invisible' }}">
                        <i class="fas fa-info-circle"></i>
                        <small>{{ $inCart != null ? 'Already in cart' : '' }}</small>
                    </p>
                    @else
                    <p
                        id="cart-message"
                        class="mt-3 bg-light text-danger p-2 border border-bottom">
                        <i class="fas fa-info-circle"></i>
                        <span >Not Available</span>
                    </p>
                    @endif
                    {{-- Buttons End --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May
                Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @forelse ($randomPackages as $pk)
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="/public/{{ $pk->bus->image}}" alt="Package image">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="{{ route('packages.show', ["id" => $pk->id]) }}">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a
                                class="h6 text-decoration-none text-truncate"
                                href="{{ route('packages.show', ["id" => $pk->id]) }}">
                                {{ $pk->package_name }}
                            </a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>&#8369; {{ number_format($pk->package_rate , 2) }}</h5>
                            </div>
                        </div>
                    </div>
                    @empty

                    @endforelse

                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection
