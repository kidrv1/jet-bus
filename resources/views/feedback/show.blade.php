@extends("layout.layout")

@section("content")
        <!-- Breadcrumb Start -->
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-12">
                    <nav class="breadcrumb bg-light mb-30">
                        <a class="breadcrumb-item text-dark" href="{{ route("home") }}">Home</a>
                        <span class="breadcrumb-item active">Feedback</span>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Breadcrumb End -->


        <!-- Feedback Start -->
        <div class="container-fluid">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Feedback</span></h2>
            <div class="row px-xl-5">
                <div class="col-lg-7 mb-5">
                    <div class="contact-form bg-light p-30">
                        <div id="success"></div>
                        <form name="sentMessage" id="feedback-form" novalidate="novalidate">
                            <div class="control-group">
                                <input
                                    id="customer"
                                    type="text"
                                    class="form-control"
                                    value="{{ $feedback->user->id ?? '' }}"
                                    disabled
                                />
                            </div>
                            <div class="control-group">
                                <input
                                    id="subject"
                                    type="text"
                                    class="form-control"
                                    value="{{ $feedback->subject }}"
                                    disabled
                                />
                            </div>
                            <div class="control-group">
                                <textarea
                                    class="form-control"
                                    rows="8"
                                    id="message"
                                >
                                    {{ $feedback->message }}
                                </textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                            {{-- <div>
                                <button
                                    class="btn btn-primary py-2 px-4"
                                    type="submit"
                                    id="sendMessageButton">
                                    Send Message
                                </button>
                            </div> --}}
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <!-- Contact End -->
@endsection
