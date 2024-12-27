<nav class="navbar navbar-top navbar-expand px-3" id="navbarDefault">
    <div class="collapse navbar-collapse justify-content-between">

        <div class="navbar-logo d-flex align-items-center">
            <!-- Toggle button for Small Screen  -->
            <button class="navbar-toggler d-lg-none d-block" data-bs-toggle="collapse" href="#collapseExample"
                role="button" aria-expanded="false" aria-controls="collapseExample">

            </button>

            <!-- Toggle button for Small Screen End -->
            <a class="navbar-brand d-flex me-1 me-sm-3" href="#">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/logo-new.png') }}" alt="phoenix" width="70">
                    </div>
                </div>
            </a>
            @if (Auth::check() && Auth::user()->role == 2)
                <!-- Additional Buttons -->
                {{-- <div class="button-list d-flex ms-auto">
                    <a href="{{ route('dashboard') }}" class="me-2">Dashboard</a>
                    <a href="{{ route('api.configuration') }}" class="me-2">Api Configuration</a>
                    <a href="{{ route('parameter') }}" class="me-2">Parameters</a>
                    <a href="{{ route('device') }}" class="me-2">Devices</a>
                    <a href="{{ route('customer.users') }}" class="me-2">Users</a>
                    <a href="{{ route('locations') }}" class="me-2">Locations</a>
                </div> --}}
            @endif
        </div>

        <div class="navbar-logo d-flex align-items-center">
            {{ Auth::user()->customer->company_name }}
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
                                    <img class="rounded-circle" src="{{ asset('assets/images/user_placeholder.png') }}"
                                        alt="" width="30">
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
                                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}" id="signOutBtn">Sign
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
