<ul class="navbar-nav">
      @if(Auth::user()->getRoleNames()[0] == 'admin')
        <li class="nav-item">
          <a class="nav-link active" href="{{route('admin_home')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">CUSTOMERS</span>
          </a>
        </li>
       @endif 

         @if(Auth::user()->getRoleNames()[0] == 'admin' || Auth::user()->getRoleNames()[0] == 'staff')
        <li class="nav-item">
          <a class="nav-link active" href="{{route('admin_bus')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-bus-front-12 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">BUS</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" href="{{route('admin_booking_list')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">BOOKING</span>
          </a>
        </li>

         <li class="nav-item">
          <a class="nav-link active" href="{{route('admin_sales')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-chart-bar-32 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">SALES</span>
          </a>
        </li>
      @endif

      @if(Auth::user()->getRoleNames()[0] == 'customer')
        <li class="nav-item">
          <a class="nav-link active" href="{{route('customer_booking_packages')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">TOUR PACKAGES</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" href="{{route('customer_booking_list')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-map-big text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">BOOKINGS</span>
          </a>
        </li>

       @endif

      

     
       
        
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
        </li>
        
        <li class="nav-item">
          <a class="nav-link " href="{{route('admin_logout')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-button-power text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Sign Out</span>
          </a>
        </li>
        
      </ul>