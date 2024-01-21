<nav class="navbar navbar-expand-lg navbar-light bg-light">

    @auth
        <a class="navbar-brand" href="{{ route('home') }}">Trang chủ</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item  @if (request()->route()->getName() == 'users.profile') active @endif">
                    <a class="nav-link" href="{{ route('users.profile') }}">Thông tin<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item  @if (request()->route()->getName() == 'posts.index') active @endif">
                    <a class="nav-link" href="{{ route('posts.index') }}">Bài viết của bạn<span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item  @if (request()->route()->getName() == '') active @endif">
                    <a class="nav-link" href="{">Tất cả bài viết<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <a href="{{ route('auth.logout') }}" class="btn btn-primary">Đăng xuất</a>
            </form>
        </div>
    @else
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item  @if (request()->route()->getName() == '') active @endif">
                    <a class="nav-link" href="{">Tất cả bài viết<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <a href="{{ route('auth.login') }}" class="btn btn-secondary" style="margin-right: 10px">Đăng nhập</a>
                <a href="{{ route('auth.register') }}" class="btn btn-primary">Đăng kí</a>
            </form>
        </div>
    @endauth

</nav>
