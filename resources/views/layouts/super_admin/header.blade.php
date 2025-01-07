<nav class="navbar navbar-top navbar-expand px-3 d-flex align-items-center justify-content-between">

    <!-- Toggle button for Small Screen End -->
    <a class="navbar-brand d-flex me-1 me-sm-3" href="#">
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-end gap-2">
                <i class="fa-solid fa-bars m-text d-lg-none" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                        aria-controls="offcanvasExample"></i>
                <img src="{{ asset('assets/images/logo-new.png') }}" alt="phoenix" width="70">
            </div>
        </div>
    </a>

    <div class="navbar-logo d-flex align-items-center">
        <div class="txt py-4">
            <h3 class="m-text fw-bold">Hello, {{Auth::user()->name}}</h3>
        </div>
        {{-- @if (@Auth::user()->role == '1')
            <h4>Administrator</h4>
        @elseif(@Auth::user()->role == '2')
            <h4>User</h4>
        @endif --}}
    </div>

    <ul class="navbar-nav navbar-nav-icons flex-row align-items-center">

        <li>

            @if (Auth::user())
                <div class="collapse navbar-collapse me-10" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <!-- Dropdown Menu (opens left) -->
                        <li class="nav-item dropdown">
                            <a class="nav-link opacity-100 dropdown-toggle fs-14 fw-semibold text-capitalize"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img class="rounded-circle"
                                    style="object-fit: cover; width: 30px; height: 30px; border-radius: 50%;"
                                    src="{{ Auth::user()->profile ? url(Auth::user()->profile) : asset('assets/images/user_placeholder.png') }}" alt="User Profile">
                                <span class="ms-2">{{ Auth::user()->username }}</span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li class="dropdown-item disabled mb-2" aria-disabled="true">
                                    <strong>{{ Auth::user()->name }}</strong><br>
                                    <small class="m-text">{{ Auth::user()->email }}</small>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('superadmin.profile') }}">Profile</a>
                                </li>

                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('superadmin.logout') }}"
                                        id="signOutBtn">Sign Out</a>
                                </li>
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
            @foreach (getUserSidebarMenus() as $menu)
                    <div class="dashboard">
                        <li class="nav-item pb-4">
                            <a href="{{ route($menu->link) }}"
                                class="nav-link {{ request()->routeIs($menu->link) ? 'active' : '' }}">
                                <span>
                                    <small class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-house-chimney-window fs-5"></i>
                                        {{ $menu->name }}
                                    </small>
                                </span>
                            </a>
                        </li>
                    </div>
                @endforeach
        </nav>

    </div>
</div>