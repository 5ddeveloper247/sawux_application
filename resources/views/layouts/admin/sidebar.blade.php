<div class="d-flex align-items-center justify-content-center ms-3" style="height: 100vh">
    <div class="sidebar py-5 px-3" id="sidebar">
        <div class="d-flex justify-content-end">
            <i class="fa-solid fa-bars fs-5 m-text" id="menuIcon" style="cursor: pointer;"></i>
        </div>

        <nav>
            <div class="nav flex-column pt-4">
                @if (Auth::check() && Auth::user()->role == 2)
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



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const menuIcon = document.getElementById("menuIcon");
        const sidebar = document.getElementById("sidebar");
        const content = document.querySelector(".content"); // Optional, if you want to adjust content area

        menuIcon.addEventListener("click", function() {
            sidebar.classList.toggle("hidden"); // Toggle sliding effect

            if (content) {
                content.classList.toggle("shifted"); // Optional: Adjust content area
            }
        });
    });
</script>
