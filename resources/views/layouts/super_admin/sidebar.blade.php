<div class="sidebar border-end d-lg-block d-none">
    <div>
        <ul class="nav flex-column">
            @foreach (getUserSidebarMenus() as $menu)
                <div class="dashboard">
                    <li class="nav-item ">
                        <a href="{{ route($menu->link) }}"
                            class=" d-flex gap-1 align-items-center justify-content-start text-start nav-link sidebar-sub-links-bg rounded-2 px-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                <path fill="black"
                                    d="M13 9V3h8v6zM3 13V3h8v10zm10 8V11h8v10zM3 21v-6h8v6zm2-10h4V5H5zm10 8h4v-6h-4zm0-12h4V5h-4zM5 19h4v-2H5zm4-2" />
                            </svg>
                            <span>{{ $menu->name }}</span>
                        </a>
                    </li>
                </div>
            @endforeach
        </ul>
    </div>
</div>
