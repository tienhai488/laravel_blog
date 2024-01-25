<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->

        <!-- Messages Dropdown Menu -->
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user" style="font-size: 20px;"></i> <span style="font-size: 20px;margin: 0 5px;">Hi,
                    {{ $user->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.profile') }}" class="dropdown-item">
                    <i class="fas fa-angle-right mr-2"></i> Thông tin cá nhân
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.changePassword') }}" class="dropdown-item">
                    <i class="fas fa-angle-right mr-2"></i> Đổi mật khẩu
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('auth.logout') }}" class="dropdown-item">
                    <i class="fas fa-angle-right mr-2"></i> Đăng xuất
                </a>
                <div class="dropdown-divider"></div>
            </div>
        </li>
    </ul>
</nav>
