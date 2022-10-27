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


        <!-- Contact Start -->
        <div class="container-fluid">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Feedback</span></h2>
            <div class="row px-xl-5">
                <div class="col-lg-7 mb-5">
                    <div class="contact-form bg-light p-30">
                        <div id="success"></div>
                        <form name="sentMessage" id="contactForm" novalidate="novalidate">
                            <div class="control-group">
                                <input type="text" class="form-control" id="subject" placeholder="Subject"
                                    required="required" data-validation-required-message="Please enter a subject" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <textarea class="form-control" rows="8" id="message" placeholder="Your experience"
                                    required="required"
                                    data-validation-required-message="Please tell us about your experience"></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div>
                                <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Send
                                    Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 mb-5">
                    <div class="bg-light p-30 mb-30">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d51893.686427010085!2d120.95542235332515!3d14.824061504985401!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ac22ac27a55f%3A0x4a8611643c5c0dd0!2sSanta%20Maria%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1666673179538!5m2!1sen!2sph" style="width: 100%; height: 250px;"style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="bg-light p-30 mb-3">
                        <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Sta. Maria 3022 Santa Maria, Philippines</p>
                        <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>add.jetbustransport@yahoo.com</p>
                        <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>0917 907 2108</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->
@endsection
