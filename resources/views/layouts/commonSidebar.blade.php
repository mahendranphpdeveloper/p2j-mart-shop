@php
$url = url()->current();
$segments = explode('/', rtrim($url, '/'));
$twoSegments = implode('/', array_slice($segments, -2));
$url = basename($url);
use App\Models\HeaderFooter;


$header = HeaderFooter::where('id',1)->first();


@endphp


<style>
    .menu .app-brand.demo {
    height: 102px;
    margin-top: 12px;
    width: 278px;

    
}
.layout-menu{

box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
transition: all 0.3s ease;
transform: translateY(0); /* Initial position */
}
.menu-link {

  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
  transform: translateY(0); /* Initial position */
}
.menu-link {

  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
  transform: translateY(0); /* Initial position */
}

/* Base styles for menu items */



/* Water Shake Effect */
.menu-item.shake a {
  animation: shake-animation 0.5s ease forwards;
}

/* Shake animation */
@keyframes shake-animation {
  0% {
    transform: translateX(0);
  }
  25% {
    transform: translateX(-5px);
  }
  50% {
    transform: translateX(5px);
  }
  75% {
    transform: translateX(-5px);
  }
  100% {
    transform: translateX(0);
  }
}

/* Ripple effect on hover */
.menu-item {

  padding-bottom: 5px;
}
.menu-item a {
  position: relative;
  overflow: hidden;
  padding-bottom: 20px;
}
 

.menu-item a::before {
  content: "";
  position: absolute;
  width: 300%;
  height: 300%;
  background: rgba(0, 0, 0, 0.2);
  border-radius: 50%;
  animation: ripple-animation 0.6s linear;
  transform: scale(0);
  pointer-events: none;
}

.menu-item:hover a::before {
  animation: ripple-animation 0.6s linear;
}

/* Animation for the ripple effect */
@keyframes ripple-animation {
  0% {
    transform: scale(0);
    opacity: 1;
  }
  50% {
    transform: scale(1);
    opacity: 0.3;
  }
  100% {
    transform: scale(4);
    opacity: 0;
  }
}

</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
      <img class="sidebar-image" style="width: 50%;" src="{{ asset('uploads/applogo/applogo.png') }}" alt="Admin Logo">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- <li class="menu-item {{(isset($url) && $url=='dashboard') ? 'active':'' }} ">
        <a href="{{route('admin-dashboard')}}" class="menu-link ">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div class="text-truncate">Dashboard</div>
            <div class="badge bg-danger rounded-pill ms-auto"></div>
        </a>
        </li> --}}

    
        <li class="menu-item {{ $url=='categories' ? 'active':'' }}">
            <a href="{{route('categories.view')}}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-shopping-bags'></i>
                
                <div>Products </div>
              </a>
            </li>
            
            <!--<li class="menu-item {{ route('customize.orders') == url()->current() ? 'active' : '' }}">-->
            <!--    <a href="{{ route('customize.orders') }}" class="menu-link">-->
            <!--        <i class='menu-icon tf-icons bx bxs-edit-alt'></i>-->
            <!--        <div>Customize Orders</div>-->
            <!--    </a>-->
            <!--</li>-->

        <li class="menu-item {{ $url=='attributes' ? 'active':'' }}">
            <a href="{{route('attributes.index')}}" class="menu-link">
                <i class='menu-icon tf-icons fas fa-palette'></i>
          
                <div>Attributes </div>
              </a>
            </li>
             <li class="menu-item {{route('orders.index')==url()->current()?'active':'' }} ">
            <a href="{{route('orders.index')}}" class="menu-link ">
                <i class='menu-icon tf-icons bx bxs-cart-download'></i>
                <div>Orders</div>
            </a>
        </li>
       <li class="menu-item {{ (isset($url) && $url == 'cancel-order-request') ? 'active' : '' }}">
    <a href="{{ route('cancel-order-request') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bx-x-circle'></i> {{-- Cancel icon --}}
        <div>Cancel Requests (Buyer)</div>
    </a>
</li>

<li class="menu-item {{ (isset($url) && $url == 'help-support') ? 'active' : '' }}">
    <a href="{{ route('help-support') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bx-help-circle'></i> {{-- Help icon --}}
        <div>Help / Support</div>
    </a>
</li>
        <li class="menu-item {{ $twoSegments=='shipping-cost' ? 'active':'' }}">
            <a href="{{route('settings.shipping-cost')}}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-dollar-circle'></i>
                <div class="text-truncate">Shipping Cost</div>
            </a>
        </li>
        <li class="menu-item {{ route('view.enquires') == url()->current() ? 'active' : '' }}">
        <a href="{{ route('view.enquires') }}" class="menu-link ">
            <i class='menu-icon tf-icons bx bxs-message-error'></i>
            <div>Enquires</div>
        </a>
    </li>
            <!-- <li class="menu-item {{ $url=='admin-home'   ? 'active open':'' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div class="text-truncate">Manage Home</div>
              </a>
            </a>
            <ul class="menu-sub">
              
              
              </ul>
            </li>
            
          </li>
          <li class="menu-item {{ $url=='admin-home' || $url == 'about-top'  || $url == 'aboutwhychoose' ? 'active open':'' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-info-circle"></i>
              <div class="text-truncate">About Us</div>
            </a>
            <ul class="menu-sub">
              </ul>
              
            </li> -->
            
            <li class="menu-item {{ $url=='header-footer-content' ? 'active':'' }}">
                <a href="{{route('common')}}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-window-alt'></i>
                    <div>Header & Footer</div>
                </a>
            </li>
            <li class="menu-item {{ $url=='home-slider' ? 'active':'' }}">
              <a href="{{ route('homeslider.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-slideshow"></i>
                  <div class="text-truncate">Home Slider</div>
              </a>
          </li>
     <!--    @if(optional(auth()->user())->enquiry) -->
   
<!--@endif-->

          <li class="menu-item {{ in_array($url, ['privacy-policy', 'delivery-policy', 'terms-conditions', 'security-policy', 'epr-compliance']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link toggle-submenu">
                <i class="menu-icon tf-icons bx bx-info-circle"></i>
                <div class="text-truncate">Informative Pages</div>
            </a>
            <ul class="submenu" style="display: none;">
                <!-- Privacy Policy -->
                
                 <li class="menu-item {{ $url == 'terms-conditions' ? 'active' : '' }}">
                    <a href="{{ route('informative-pages.terms-conditions') }}" class="menu-link">
                        <div class="text-truncate">Terms & Conditions</div>
                    </a>
                </li>
                
                <li class="menu-item {{ $url == 'privacy-policy' ? 'active' : '' }}">
                    <a href="{{ route('informative-pages.privacy-policy') }}" class="menu-link">
                        <div class="text-truncate">Privacy Policy</div>
                    </a>
                </li>
                
                 <!-- Refund & Cancellation Policy -->
                <li class="menu-item {{ $url == 'epr-compliance' ? 'active' : '' }}">
                    <a href="{{ route('informative-pages.epr_compliance') }}" class="menu-link">
                        <div class="text-truncate"> Refund & Cancellation Policy</div>
                    </a>
                </li>
        
                <!-- Delivery Policy -->
                <li class="menu-item {{ $url == 'delivery-policy' ? 'active' : '' }}">
                    <a href="{{ route('informative-pages.delivery-policy') }}" class="menu-link">
                        <div class="text-truncate">Delivery Policy</div>
                    </a>
                </li>
        
                <!-- Terms & Conditions -->
               
        
                <!-- Security Policy -->
                <!--<li class="menu-item {{ $url == 'security-policy' ? 'active' : '' }}">-->
                <!--    <a href="{{ route('informative-pages.security-policy') }}" class="menu-link">-->
                <!--        <div class="text-truncate">Security Policy</div>-->
                <!--    </a>-->
                <!--</li>-->
        
               
            </ul>
        </li>
        <li class="menu-item {{ request()->routeIs('meta-titles') ? 'active' : '' }}">
          <a href="{{ route('meta-titles') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bxs-key"></i>
              <div>SEO Meta Title</div>
          </a>
      </li>
   
   
      <li class="menu-item {{route('gst')==url()->current()?'active':'' }} ">
          <a href="{{route('gst')}}" class="menu-link ">
              <i class='menu-icon tf-icons bx bx-rupee'></i>
              <div>GST</div>
          </a>
      </li>

            <li class="menu-item {{route('users.index')==url()->current()?'active':'' }} ">
          <a href="{{route('users.index')}}" class="menu-link ">
              <i class='menu-icon tf-icons bx bxs-group'></i>
              <div>Customers</div>
          </a>
      </li>

        <li class="menu-item {{ route('combo.index') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('combo.index') }}" class="menu-link">
              <i class='menu-icon tf-icons bx bxs-offer'></i>
              <div>Combo Pack</div>
          </a>
      </li>
        {{-- @if(auth()->user()->id==1)
        <li class="menu-item {{route('meta-titles')==url()->current()?'active':'' }} ">
             <a href="{{route('meta-titles')}}" class="menu-link ">
                 <i class='menu-icon tf-icons bx bx-globe'></i>
                 <div>SEO Meta Title</div>
             </a>
         </li>
         @endif --}}
        
         <li class="menu-item {{($url=='admin-home')||
         $url=='header-footer' || $url=='homesections-banner-2' || $twoSegments=='homesections/1' || $url=='homesections' ||  $url=='home-slider-banner'  ? 'active open':'' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div class="text-truncate">Manage Home</div>
            </a>


            <ul class="menu-sub">
           
                <li class="menu-item {{ $url=='home-slider-banner' ? 'active':'' }}">
                <a href="{{route('home-slider-banner')}}" class="menu-link">  
                        <div>Slider Banner</div>
                    </a>
                </li>
               

                <li class="menu-item {{ $url=='homesections' ? 'active':'' }}">
                    <a href="{{route('homesections.index')}}" class="menu-link">
                        <div>3 Cards</div>
                    </a>
                </li>
                <li class="menu-item {{ $twoSegments=='homesections/1' ? 'active':'' }}">
                    <a href="{{route('homesections.show',['homesection'=>1])}}" class="menu-link">
                        <div>Banner 1</div>
                    </a>
                </li>
                <li class="menu-item {{ $url=='homesections-banner-2' ? 'active':'' }}">
                    <a href="{{route('homesections.banner-2')}}" class="menu-link">
                        <div>Banner 2</div>
                    </a>
                </li>

             

            </ul>
        </li>



            <li class="menu-item {{ $url=='contact-us' ? 'active':'' }}">
              <a href="{{route('contact-us.edit')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-contact"></i>
                <div class="text-truncate">contact </div>
            </a>
        </li>
        
        <li class="menu-item {{ $url=='settings' ? 'active':'' }}">
            <a href="{{route('settings.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user-detail"></i>
                <div class="text-truncate">Profile</div>
            </a>
        </li>

        <li class="menu-item {{ $twoSegments=='shipping-cost' ? 'active':'' }}">
            <a href="{{route('reports')}}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-report'></i>
                <div class="text-truncate">Reports</div>
            </a>
        </li>

    </ul>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
          document.querySelectorAll(".toggle-submenu").forEach(item => {
              item.addEventListener("click", function (e) {
                  e.preventDefault(); // Prevent default action
                  let parent = this.parentElement;
                  let submenu = parent.querySelector(".submenu");
  
                  // Toggle submenu visibility
                  if (submenu.style.display === "none" || submenu.style.display === "") {
                      submenu.style.display = "block";
                      parent.classList.add("open");
                  } else {
                      submenu.style.display = "none";
                      parent.classList.remove("open");
                  }
              });
          });
      });
  </script>
</aside>