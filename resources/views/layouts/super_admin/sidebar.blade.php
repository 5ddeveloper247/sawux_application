<div class="d-flex align-items-center justify-content-center ms-3" style="height: 100vh">
    <div class="sidebar py-5 px-3" id="sidebar">
        <div class="d-flex justify-content-end">
            <i class="fa-solid fa-bars fs-5 m-text" id="menuIcon" style="cursor: pointer;"></i>
        </div>
        <div class="pt-4">
            <ul class="nav flex-column">
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
            </ul>
        </div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuIcon = document.getElementById("menuIcon");
        const sidebar = document.getElementById("sidebar");
        const content = document.querySelector(".content"); // Optional, if you want to adjust content area

        menuIcon.addEventListener("click", function () {
            sidebar.classList.toggle("hidden"); // Toggle sliding effect

            if (content) {
                content.classList.toggle("shifted"); // Optional: Adjust content area
            }
        });
    });
</script>
