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
        <div class="collapse navbar-collapse me-10" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <!-- Dropdown Menu (opens left) -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 <img class="rounded-circle " src="{{asset('assets/images/user_placeholder.png')}}"
                alt="" width="30"> 
                <span class="ms-2">{{ Auth::user()->username }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li class="dropdown-item disabled" aria-disabled="true">
                  <strong>{{ Auth::user()->name }}</strong><br>
                  <small>{{ Auth::user()->email }}</small>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('superadmin.logout')}}" id="signOutBtn">Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div>
        
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