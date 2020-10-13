<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-danger elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link navbar-danger">
        <img src="{{ asset('img/logo.jpg') }}" alt="SLQ Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Fokal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar User Panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset(Auth::user()->foto) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <!-- /.sidebar-user-panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                @role('admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.index') }}" class="nav-link {{ request()->routeIs('admin.index*')?'active':'' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p> Dashboard </p>
                        </a>
                    </li>
                @endrole
        
                @role('super-admin')
                    <li class="nav-header">SUPERADMIN</li>
                    {{-- MANAJEMEN USER --}}
                    <li class="nav-item has-treeview {{ request()->routeIs('superadmin.akses*')?'menu-open':'' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('superadmin.akses*')?'active':'' }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                Manajemen Users
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('superadmin.akses.permission.index') }}" class="nav-link {{ request()->routeIs('superadmin.akses.permission*')?'active':'' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>Permission</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('superadmin.akses.role.index') }}" class="nav-link {{ request()->routeIs('superadmin.akses.role*')?'active':'' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>Role</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('superadmin.akses.user.index') }}" class="nav-link {{ request()->routeIs('superadmin.akses.user*')?'active':'' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>User</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('superadmin.setting.index') }}" class="nav-link {{ request()->routeIs('superadmin.setting*')?'active':'' }}">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p> Setting</p>
                        </a>
                    </li>
                @endrole

                @role('admin')
                    <li class="nav-header">ADMIN</li>
                    {{-- Anggota --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.anggota.index') }}" class="nav-link {{ request()->routeIs('admin.anggota*')?'active':'' }}">
                        <i class="nav-icon fa fa-id-card"></i>
                        <p> Data Anggota</p>
                        </a>
                    </li>
                @endrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>