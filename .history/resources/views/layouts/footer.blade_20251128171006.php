<footer class="footer">
  <div class="container">
    <div class="row">
    <!-- ABOUT -->
<div class="col-md-2 col-6">
    <h6>ABOUT</h6>
    <a href="{{ route('contact') }}">Contact Us</a><br>
    <a href="{{ route('wishlist') }}">Wishlist</a><br>
    <!--<a href="{{ route('press') }}">Press</a><br>-->
    <!--<a href="{{ route('corporate') }}">Corporate Information</a><br>-->
    <!--<a href="{{ route('payments') }}">Payments</a><br>-->
    <!--<a href="{{ route('shipping') }}">Shipping</a><br>-->
    <a href="{{ route('returns') }}">Cancellation & Returns</a><br>
    <!--<a href="{{ route('faq') }}">FAQ</a>-->
</div>

<!-- CONSUMER POLICY -->
<div class="col-md-2 col-6">
    <h6>CONSUMER POLICY</h6>
    <a href="{{ route('terms') }}">Terms and Condition</a><br>
    <!--<a href="{{ route('security') }}">Security</a><br>-->
    <a href="{{ route('privacy') }}">Privacy Policy</a><br>
      <a href="{{ route('shipping') }}">Delivery and Shipping</a><br>
       <a href="{{ route('returns') }}">Cancellation & Returns</a><br>
    <!--<a href="{{ route('sitemap') }}">Sitemap</a><br>-->
    <!--<a href="{{ route('grievance') }}">Grievance Redressal</a><br>-->
    <!--<a href="{{ route('epr') }}">EPR Compliance</a>-->
</div>


      <!-- MAIL US -->
    <div class="col-md-4 col-12">
    <h6>{{ $contact->address_title_1 ?? 'Mail Us:' }}</h6>
    <p>{!! $contact->address ?? '' !!}</p>

    <div class="social-icons">
        @if(!empty($footer->instagram_link))
            <a href="{{ $footer->instagram_link }}" target="_blank"><i class="fa-brands fa-instagram"></i></a>
        @endif
        @if(!empty($footer->twitter_link))
            <a href="{{ $footer->twitter_link }}" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
        @endif
        @if(!empty($footer->youtube_link))
            <a href="{{ $footer->youtube_link }}" target="_blank"><i class="fa-brands fa-youtube"></i></a>
        @endif
        @if(!empty($footer->facebook_link))
            <a href="{{ $footer->facebook_link }}" target="_blank"><i class="fa-brands fa-facebook"></i></a>
        @endif
    </div>
</div>


      <!-- REGISTERED OFFICE -->
      <div class="col-md-4 col-12">
        <h6>Registered Office Address:</h6>
        <p>
          Buildings Alyssa, Begonia & Clove Embassy Tech Village,<br>
          Outer Ring Road, Devarabeesanahalli Village,<br>
          Bengaluru, 560103, Karnataka, India<br>
          CIN: U51109KA2012PTC066107<br>
          Telephone: <a href="tel:123-456-7890">123-456-7890</a>
        </p>
        <div class="social-icons mb-4">
          <a href="#" class="mb-2"><img src="{{ asset('assets/images/visa.png') }}" alt="visa"></a>
          <a href="#" class="mb-2"><img src="{{ asset('assets/images/amarican_express.png') }}" alt="amex"></a>
          <a href="#" class="mb-2"><img src="{{ asset('assets/images/master_card.png') }}" alt="mastercard"></a>
          <a href="#" class="mb-2"><img src="{{ asset('assets/images/paypal.png') }}" alt="paypal"></a>
          <a href="#" class="mb-2"><img src="{{ asset('assets/images/discover.png') }}" alt="discover"></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Features Section -->
  <div class="container border-top">
  <div class="row">
    {{-- Down Content 1 --}}
    <div class="col-lg-4 col-md-6">
        @if (!empty($headerFooter->down_content_1))
            @php
                $items1 = json_decode($headerFooter->down_content_1);
            @endphp
            @foreach ($items1 as $item)
                <div class="feature-box">
                <i class="fa {{ $item->icon }} fa-2x text-primary  mt-3 "></i>
                <h5 class="mt-3 ">{{ $item->title }}</h5>
                    <p class="mt-3">{{ $item->content }}</p>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Down Content 2 --}}
    <div class="col-lg-4 col-md-6">
        @if (!empty($headerFooter->down_content_2))
            @php
                $items2 = json_decode($headerFooter->down_content_2);
            @endphp
            @foreach ($items2 as $item)
                <div class="feature-box">
                <i class="fa {{ $item->icon }}  fa-2x text-primary  mt-3"></i>
                <h5 class="mt-3 ">{{ $item->title }}</h5>
                    <p class="mt-3">{{ $item->content }}</p>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Down Content 3 --}}
    <div class="col-lg-4 col-md-6">
        @if (!empty($headerFooter->down_content_3))
            @php
                $items3 = json_decode($headerFooter->down_content_3);
            @endphp
            @foreach ($items3 as $item)
                <div class="feature-box">
                <i class="fa {{ $item->icon }} fa-2x   text-primary  mt-3"></i>
                <h5 class="mt-3 ">{{ $item->title }}</h5>
                    <p class="mt-3">{{ $item->content }}</p>
                  
                </div>
            @endforeach
        @endif
    </div>
</div>

  </div>

  <!-- Footer Bottom -->
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-6 text-md-start text-center">
          ©P2JMart All Rights Reserved 2025
        </div>
        <div class="col-md-6 text-md-end text-center">
          <a href="https://jayamwebsolutions.com/web-design-company-in-chennai.php">Developed by Jayam Web Solutions</a>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Scroll to top -->
<a href="#" class="scrollup" style="display: none"><i class="fa-solid fa-angle-up"></i></a>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/owlcarousel/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/js/parallax.js') }}"></script>
<script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/js/isotope.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dd.min.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.elevatezoom.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>

<!-- External Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"></script>

<!-- Swiper Init -->
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 10,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
  });

  // Wishlist count updater for wishlist-count indicator
  function updateWishlistCount() {
    fetch("{{ route('wishlist.count') }}")
      .then(res => res.json())
      .then(data => {
        // Expected format: { count: X }
        const countElement = document.querySelector('.wishlist-count');
        if (countElement && typeof data.count !== 'undefined') {
          countElement.textContent = data.count > 0 ? data.count : '';
        }
      });
  }

  // Call on load so wishlist count stays current
  updateWishlistCount();
</script>
