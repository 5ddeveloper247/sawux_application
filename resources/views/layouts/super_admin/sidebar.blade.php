<div class="d-flex align-items-center justify-content-center ms-3 d-none d-lg-block" style="height: 100vh">
    <div class="sidebar py-5 px-3" id="sidebar">
        <div class="d-flex justify-content-end pe-3">
            <i class="fa-solid fa-bars fs-5 m-text" id="menuIcon" style="cursor: pointer;"></i>
        </div>
        <div class="pt-4">
            <ul class="nav flex-column">
                @foreach (getUserSidebarMenus() as $menu)
                <div class="dashboard">
                    <!-- Full Menu Item -->
                    <li class="nav-item pb-4 li-full">
                        <a href="{{ route($menu->link) }}"
                            class="nav-link {{ request()->routeIs($menu->link) ? 'active' : '' }}">
                            <span>
                                <small class="d-flex align-items-center gap-2">
                                    {!! $menu->icon !!}
                                    {{ $menu->name }}
                                </small>
                            </span>
                        </a>
                    </li>

                    <!-- Icon-Only Menu Item -->
                    <li class="nav-item pb-4 justify-content-end li-icon-only">
                        <a href="{{ route($menu->link) }}"
                            class="nav-link {{ request()->routeIs($menu->link) ? 'active' : '' }}">
                            <span>
                                <small class="d-flex align-items-center gap-2">
                                    {!! $menu->icon !!}
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

    menuIcon.addEventListener("click", function () {
        sidebar.classList.toggle("hidden");

        if (content) {
            content.classList.toggle("shifted");
        }

        updateMenuVisibility();
    });

    updateMenuVisibility();
});

</script>
