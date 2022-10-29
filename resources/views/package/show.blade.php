@extends('layout.layout')

@section('custom_styles')
    <style>

    </style>
@endsection

@section('custom_scripts')
    <script>
        const addToCart = async () => {
            const btn = document.querySelector("#add-to-cart-btn");
            const dateInput = document.querySelector("#booking-date-input");
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
                    booking_date: dateInput.value
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

            //display results

            //enable button
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
                    <label>
                        <strong>Booking Date:</strong>
                        <input
                            id="booking-date-input"
                            type="date"
                            class="form-control form-control-sm bg-secondary border-0 text-center"
                            @if ($inCart != null)
                                readonly
                                value="{{ $inCart->booking_date->isoFormat('YYYY-MM-DD') }}"
                            @else
                                min="{{ now()->addDays(7)->isoFormat('YYYY-MM-DD') }}"
                            @endif
                        >
                    </label>
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
