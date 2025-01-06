<div class="d-none d-lg-flex align-items-center justify-content-center ms-3" style="height: 100vh">
    <div class="sidebar py-5 px-3" id="sidebar">
        <div class="d-flex justify-content-end">
            <i class="fa-solid fa-bars fs-5 m-text pe-3" id="menuIcon" style="cursor: pointer;"></i>
        </div>

        <nav>
            <div class="nav flex-column pt-4">
                @if (Auth::check() && Auth::user()->role == 2)
                    <!-- Additional Buttons -->
                    <div class="nav flex-column">
                        <div class="nav-item pb-4 li-full">
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
                        <div class="nav-item pb-4 li-icon-only justify-content-end" style="display: none;">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <span>
                                    <small>
                                        <i class="fa-solid fa-house-chimney-window fs-5"></i>
                                    </small>
                                </span>
                            </a>
                        </div>
                        <div class="nav-item pb-4 li-full">
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
                        <div class="nav-item pb-4 li-icon-only justify-content-end" style="display: none;">
                            <a href="{{ route('locations') }}"
                                class="nav-link {{ request()->routeIs('locations') ? 'active' : '' }}">
                                <span>
                                    <small>
                                        <i class="fa-solid fa-earth-americas fs-5"></i>
                                    </small>
                                </span>
                            </a>
                        </div>
                        <div class="nav-item pb-4 li-full">
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
                        <div class="nav-item pb-4 li-icon-only justify-content-end" style="display: none;">
                            <a href="{{ route('device') }}"
                                class="nav-link {{ request()->routeIs('device') ? 'active' : '' }}">
                                <span>
                                    <small>
                                        <i class="fa-solid fa-laptop-code fs-6"></i>
                                    </small>
                                </span>
                            </a>
                        </div>
                        <div class="nav-item pb-4 li-full">
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
                        <div class="nav-item pb-4 li-icon-only justify-content-end" style="display: none;">
                            <a href="{{ route('parameter') }}"
                                class="nav-link {{ request()->routeIs('parameter') ? 'active' : '' }}">
                                <span>
                                    <small>
                                        <i class="fa-solid fa-chart-simple fs-5"></i>
                                    </small>
                                </span>
                            </a>
                        </div>
                        <div class="nav-item pb-4 li-full">
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
                        <div class="nav-item pb-4 li-icon-only justify-content-end" style="display: none;">
                            <a href="{{ route('api.configuration') }}"
                                class="nav-link {{ request()->routeIs('api.configuration') ? 'active' : '' }}">
                                <span>
                                    <small>
                                        <i class="fa-solid fa-gears fs-6"></i>
                                    </small>
                                </span>
                            </a>
                        </div>

                       

                       

                        <div class="nav-item pb-4 li-full">
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
                        <div class="nav-item pb-4 li-icon-only justify-content-end" style="display: none;">
                            <a href="{{ route('customer.users') }}"
                                class="nav-link {{ request()->routeIs('customer.users') ? 'active' : '' }}">
                                <span>
                                    <small>
                                        <i class="fa-solid fa-user fs-5"></i>
                                    </small>
                                </span>
                            </a>
                        </div>

                    
                    </div>
                @endif
            </div>
        </nav>
    </div>
</div>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        const menuIcon = document.getElementById("menuIcon");
        const sidebar = document.getElementById("sidebar");
        const content = document.querySelector(".content");
        const fullMenuItems = document.querySelectorAll(".li-full");
        const iconOnlyItems = document.querySelectorAll(".li-icon-only");

        const updateMenuVisibility = () => {
            if (sidebar.classList.contains("hidden")) {
                fullMenuItems.forEach(item => item.style.display = "none");
                iconOnlyItems.forEach(item => item.style.display = "flex");
            } else {
                fullMenuItems.forEach(item => item.style.display = "block");
                iconOnlyItems.forEach(item => item.style.display = "none");
            }
        };

        menuIcon.addEventListener("click", function() {
            sidebar.classList.toggle("hidden");

            if (content) {
                content.classList.toggle("shifted");
            }

            updateMenuVisibility();
        });

        // Initialize visibility state on page load
        updateMenuVisibility();
    });
</script>
