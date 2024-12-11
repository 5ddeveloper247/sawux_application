<nav class="navbar navbar-top navbar-expand px-3" id="navbarDefault">
  <div class="collapse navbar-collapse justify-content-between">

    <div class="navbar-logo d-flex align-items-center">
      <!-- Toggle button for Small Screen  -->
      <button class="navbar-toggler d-lg-none d-block" data-bs-toggle="collapse" href="#collapseExample" role="button"
        aria-expanded="false" aria-controls="collapseExample">
        
      </button>
      
      <!-- Toggle button for Small Screen End -->
      <a class="navbar-brand d-flex me-1 me-sm-3" href="#">
        <div class="d-flex align-items-center">
          <div class="d-flex align-items-center">
            <img src="{{asset('assets/images/logo-new.png')}}"
              alt="phoenix" width="100">
          </div>
        </div>
      </a>
    </div>
    
    <div class="navbar-logo d-flex align-items-center">
      @if(@Auth::user()->role == 1)
        <h4>Administrator</h4>
      @elseif(@Auth::user()->role == 2)
        <h4>User</h4>
      @endif
    </div>

    <ul class="navbar-nav navbar-nav-icons flex-row align-items-center">
      
      <li>
        
        @if(Auth::user())
        <a href="{{route('logout')}}" style="font-size:16px !important;" title="Logout">
          <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out me-2">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
        </a>
        @endif
      </li>
      <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button"
          data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
          <div class="avatar avatar-l ">
            @if(@Auth::user()->role == 1)
              <!-- <img class="rounded-circle " src="{{asset('assets/images/admin_placeholder.png')}}"
                alt="" width="40"> -->
            @elseif(@Auth::user()->role == 2)
              <!-- <img class="rounded-circle " src="{{asset('assets/images/user_placeholder.png')}}"
                alt="" width="40"> -->
            @endif
          </div>
        </a>
      </li>
    </ul>
  </div>
</nav>