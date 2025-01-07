<aside class="main-sidebar sidebar-light-primary elevation-4 custom-sidebar-bg">
    <a href="" class="brand-link text-start py-3">
        <img src="{{ asset('../assets/photos/CET.png') }}" alt="SSO Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">CET</span>
    </a>

    <div class="sidebar mt-3">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 40px; height: 40px;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
                </div>
            </div>
            <div class="info ml-2">
                <a href="" class="d-block font-weight-bold text-dark">
                    {{ strtok(Auth::user()->name ?? 'Guest', ' ') }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('CET.dashboard') }}" class="nav-link {{ request()->routeIs('CET.dashboard') ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p class="ml-2">Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('CET.student_information.student-dashboard') }}" class="nav-link {{ request()->routeIs('CET.student_information.student-dashboard') ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="nav-icon bi bi-person"></i>
                        <p class="ml-2">Student Information</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('CET.inventory.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('CET.inventory.*') ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="nav-icon bi bi-box"></i>
                        <p class="ml-2">Inventory<i class="right fas fa-angle-left mt-1"></i></p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                        <li class="nav-item">
                            <a href="{{ route('CET.inventory.book.book-dashboard') }}" class="nav-link {{ request()->routeIs('CET.inventory.book.book-dashboard') ? 'active bg-light text-primary' : 'text-dark' }}">
                                <p>Book</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('CET.inventory.equipment.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('CET.inventory.equipment.*') ? 'active bg-light text-primary' : 'text-dark' }}">
                                <p>Equipments<i class="right fas fa-angle-left mt-1"></i></p>
                            </a>
                            <ul class="nav nav-treeview pl-3">
                                <li class="nav-item">
                                    <a href="{{ route('CET.inventory.equipment.equipment-dashboard') }}" class="nav-link {{ request()->routeIs('CET.inventory.equipment.equipment-dashboard') ? 'active bg-light text-primary' : 'text-dark' }}">
                                        <p>Equipment Dashboard</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('CET.inventory.borrow.index') }}" class="nav-link {{ request()->routeIs('CET.inventory.borrow.index') ? 'active bg-light text-primary' : 'text-dark' }}">
                                        <p>Borrow</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item mt-3">
                    <a href="#" class="nav-link text-danger d-flex align-items-center" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon bi bi-door-closed"></i>
                        <p class="ml-2">Logout</p>
                    </a>
                </li>

                <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                    @csrf
                </form>
            </ul>
        </nav>
    </div>
</aside>
