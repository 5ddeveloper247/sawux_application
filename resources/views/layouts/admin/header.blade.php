<nav class="navbar navbar-top navbar-expand px-3" id="navbarDefault">
    <div class="collapse navbar-collapse justify-content-between">

        <div class="navbar-logo d-flex align-items-center">

            <!-- Toggle button for Small Screen End -->
            <a class="navbar-brand d-flex me-1 me-sm-3" href="#">
                <div class="d-flex align-items-end gap-3">
                    <i class="fa-solid fa-bars m-text d-lg-none" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                        aria-controls="offcanvasExample"></i>

                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/logo-new.png') }}" alt="phoenix" width="70">
                    </div>
                </div>
            </a>

        </div>
        <div>
            @if (Auth::check() && Auth::user()->role == '2')
           <span> {{ Auth::user()->customer->company_name }}</span> - <span id="header_location_name">{{ session('location_name') }}</span>
            @else
                {{ Auth::user()->customer->company_name }} - <span id="customer_header_location_name">{{ session('location_name') }}</span>
            @endif
        </div>
        <ul class="navbar-nav navbar-nav-icons flex-row align-items-center">

            <li>

                @if (Auth::user())
                    <div class="collapse navbar-collapse me-10" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <!-- Dropdown Menu (opens left) -->
                            <li class="nav-item dropdown ">
                                <a class="dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img class="rounded-circle"
                                        style="object-fit: cover; width: 30px; height: 30px; border-radius: 50%;"
                                        src="{{ Auth::user()->profile ? url(Auth::user()->profile) : asset('assets/images/user_placeholder.png') }}"
                                        alt="User Profile">
                                    <span class="ms-2 text-white text-capitalize">{{ Auth::user()->username }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li class="dropdown-item disabled" aria-disabled="true">
                                        <strong class="text-capitalize">{{ Auth::user()->name }}</strong><br>
                                        <small class="m-text">{{ Auth::user()->email }}</small>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    @if (@Auth::user()->role == 2)
                                        <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                                    @elseif(@Auth::user()->role == 3)
                                        <li><a class="dropdown-item" href="{{ route('customer.profile') }}">Profile</a>
                                        </li>
                                    @endif
                                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                            id="signOutBtn">Sign
                                            Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                @endif
            </li>
            <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!"
                    role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="avatar avatar-l ">
                        @if (@Auth::user()->role == 1)
                            <!-- <img class="rounded-circle " src="{{ asset('assets/images/admin_placeholder.png') }}"
                alt="" width="40"> -->
                        @elseif(@Auth::user()->role == 2)
                            <!-- <img class="rounded-circle " src="{{ asset('assets/images/user_placeholder.png') }}"
                alt="" width="40"> -->
                        @endif
                    </div>
                </a>
            </li>
        </ul>
    </div>
</nav>


<div class="offcanvas offcanvas-start " style="width: 220px" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">
    <div class="sidebar py-5 px-3" id="sidebar">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"
                style="background-image: none !important">
                <i class="fa-solid fa-xmark fs-4 m-text"></i>
            </button>
        </div>

        <nav>
            <div class="nav flex-column pt-4">
                @if (Auth::check() && Auth::user()->role == '2')
                    <!-- Additional Buttons -->
                    <div class="nav flex-column">
                        <div class="nav-item pb-4">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <span>
                                    <small class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-house-chimney-window fs-5"></i>
                                        Dashboard
                                    </small>
                                </span>
                            </a>
                        </div>

                        <div class="nav-item pb-4">
                            <a href="{{ route('api.configuration') }}"
                                class="nav-link {{ request()->routeIs('api.configuration') ? 'active' : '' }}">
                                <span>
                                    <small class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-gears fs-6"></i>
                                        Api Configuration
                                    </small>
                                </span>
                            </a>
                        </div>

                        <div class="nav-item pb-4">
                            <a href="{{ route('parameter') }}"
                                class="nav-link {{ request()->routeIs('parameter') ? 'active' : '' }}">
                                <span>
                                    <small class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-chart-simple fs-5"></i>
                                        Parameters
                                    </small>
                                </span>
                            </a>
                        </div>

                        <div class="nav-item pb-4">
                            <a href="{{ route('device') }}"
                                class="nav-link {{ request()->routeIs('device') ? 'active' : '' }}">
                                <span>
                                    <small class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-laptop-code fs-6"></i>
                                        Devices
                                    </small>
                                </span>
                            </a>
                        </div>

                        <div class="nav-item pb-4">
                            <a href="{{ route('customer.users') }}"
                                class="nav-link {{ request()->routeIs('customer.users') ? 'active' : '' }}">
                                <span>
                                    <small class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-user fs-5"></i>
                                        Users
                                    </small>
                                </span>
                            </a>
                        </div>

                        <div class="nav-item pb-4">
                            <a href="{{ route('locations') }}"
                                class="nav-link {{ request()->routeIs('locations') ? 'active' : '' }}">
                                <span>
                                    <small class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-earth-americas fs-5"></i>
                                        Locations
                                    </small>
                                </span>
                            </a>
                        </div>

                    </div>
                @endif
            </div>

            <div class="navbar-logo d-flex align-items-center">
                {{ Auth::user()->customer->company_name }}
            </div>
        </nav>

    </div>
</div>
