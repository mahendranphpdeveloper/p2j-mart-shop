@extends('layouts.home')
@section('content')

<!-- START MAIN CONTENT -->
<div class="main_content">

<div class="section pb_70">
	<div class="container">
        <div class="row">
            <div class="col-xl-4 col-md-6">
            	<div class="contact_wrap contact_style3">
                    <div class="contact_icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact_text">
                        <span>{{ $contact->address_title_1 }}</span>
                        <p>{{ $contact->address }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
            	<div class="contact_wrap contact_style3">
                    <div class="contact_icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact_text">
                        <span>{{ $contact->email_title_1 }}</span>
                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
            	<div class="contact_wrap contact_style3">
                    <div class="contact_icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact_text">
                        <span>{{ $contact->phone_title_1 }}</span>
                        <p>{{ $contact->phone }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- START SECTION CONTACT -->
    <div class="section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="heading_s1">
                        <h2>{{ $contact->form_title }}</h2>
                    </div>
                  <p class="leads">{!! $contact->form_content !!}</p>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="contact_form">
    <form method="POST" action="{{ route('contact.submit') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Your Name *" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Your Email *" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="phone" class="form-control" placeholder="Your Phone *" required>
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="subject" class="form-control" placeholder="Subject">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <textarea name="message" class="form-control" rows="5" placeholder="Your Message *" required></textarea>
                    @error('message')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
     <div class="col-md-12">
    <div class="form-group">
        <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
        @error('g-recaptcha-response')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <button type="submit" class="btn btn-fill-out">Send Message</button>
    </div>
</div>
        </div>
    </form>
</div>
                   
                </div>
                <div class="col-lg-6 pt-2 pt-lg-0 mt-4 mt-lg-0">
                    <div id="map" class="contact_map2" data-zoom="12" data-latitude="40.680" data-longitude="-73.945" data-icon="assets/images/marker.png">
                    <iframe src="{{ $contact->embed_map_link }}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION CONTACT -->
</div>
<!-- END MAIN CONTENT -->

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
