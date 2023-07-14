@extends('layout.layout')

@section('custom_styles')
    <style>

    </style>
@endsection

@section('custom_scripts')
    <script>
        const checkbox = document.querySelector("#acceptCheckbox");
        const submitBtn = document.querySelector("#checkout-button");
        checkbox.addEventListener("click", (e) => {
            if(checkbox.checked) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        // $(function () {
        //     $('[data-toggle="popover"]').popover()
        // })
    </script>
@endsection

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('home') }}">Home</a>
                    <span class="breadcrumb-item active">Cart</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Package</th>
                            <th>Base Price</th>
                            <th>Addons</th>
                            <th>Booking Start</th>
                            <th>Booking End</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($cartItems as $item)
                            <tr>
                                <td class="align-middle">
                                    <img src="/public/public/{{ $item->package->bus->image }}" alt="package picture"
                                        style="width: 50px;">
                                    {{ $item->package->package_name }}
                                </td>
                                <td class="align-middle">
                                    &#8369;{{ number_format($item->package->package_rate, 2) }}
                                </td>
                                <td class="align-middle">
                                    <?php $totalAddons = 0; ?>
                                    @if(!empty($item->addons))
                                        <?php $displayText = "" ?>

                                        @foreach ($item->addons as $addon)
                                            <?php $totalAddons += (float) $addon->addonRef->price; ?>
                                            <?php
                                                $displayText .= $addon->addonRef->price . " - " . $addon->addonRef->name . "<br>";
                                            ?>
                                        @endforeach
                                        <i
                                            data-toggle="tooltip"
                                            data-placement="bottom"
                                            data-html="true"
                                            title="{{ $displayText }}"
                                            class="fas fa-question-circle">
                                        </i>
                                    @endif
                                    &#8369;{{ number_format($totalAddons, 2) }}
                                </td>
                                <td class="align-middle">
                                    {{ $item->booking_date->format('M d, Y') }}
                                </td>
                                <td class="align-middle">
                                    {{ $item->booking_date_end->format('M d, Y') }}
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('cart.remove', ['id' => $item->id]) }}" class="btn btn-sm btn-danger">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="align-middle">
                                    <h4>No Items In Cart</h4>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="bg-secondary pr-3">
                        Cart Summary
                    </span>
                </h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Base Total</h6>
                            <h6>&#8369; <span id="sub-total">{{ number_format($sub_total, 2) }}</span></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Addons</h6>
                            <h6 class="font-weight-medium">&#8369; <span
                                    id="add-total">{{ number_format($add_total, 2) }}</span></h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>&#8369; <span id="total">{{ number_format($total, 2) }}</span></h5>
                        </div>
                        @if (count($cartItems) == 0)
                            <a href="{{ route('home') }}#featured-section"
                                class="btn btn-block btn-warning font-weight-bold my-3 py-3">
                                See Packages
                            </a>
                        @else
                            <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" data-toggle="modal"
                                data-target="#checkout-modal">
                                Proceed To Checkout
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

    <!-- Final Submit -->
    <div id="checkout-modal" class="modal" tabindex="-1" aria-labelledby="Checkout Form">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Checkout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mt-1" role="alert">
                        <i class="fas fa-exclamation text-primary"></i>
                        <small class="text-primary">
                            Bookings should be at least a week before your departure date
                            if not, your booking will not be approved
                        </small>
                    </div>
                    <div class="text-center">
                        <h4>Gcash Information</h4>
                        <p>0917 907 2108</p>
                        <img class="w-75 h-75" src="{{ URL::to('gcash.png') }}" alt="GCash QR Code">
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="" id="acceptCheckbox">
                        <label class="form-check-label" for="acceptCheckbox">
                            <small class="text-muted mt-4">
                                <b>I accept</b> that bookings that are not paid 3 days before departure will be cancelled
                            </small>
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-between modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    <button onclick="window.location.href='{{ route('cart.checkout') }}';" disabled id="checkout-button" type="button" class="btn btn-danger">Checkout</button>
                </div>
            </div>
        </div>
    @endsection
