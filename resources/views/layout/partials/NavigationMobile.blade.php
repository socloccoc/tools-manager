<ul class="hidden-md hidden-lg  nav navbar-nav c-theme-nav button_top">
    @if(!Sentinel::check())
        <li class="top_button">
            <a href="{{ URL::route('login') }}"
               class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                <i class="icon-user"></i> Đăng nhập
            </a>
        </li>
        <li class="top_button">
            <a href="#"
               class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                <i class="icon-key icons"></i> Đăng ký</a>
        </li>
    @else
        <li class="top_button">
            <a href="{{ URL::route('logout') }}"
               class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                Đăng xuất
            </a>
        </li>
        <li class="top_button">
            <a href="#"
               class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                <i class="icon-user"></i> {{  isset($full_name) && !empty($full_name) ? $full_name : '' }}</a>
        </li>
    @endif

</ul>

<nav class="menu-main-mobile c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold hidden-md hidden-lg">
    <ul class="nav navbar-nav c-theme-nav ">

        @include('layout.partials.FrontMenu')

        @if(!Sentinel::check())
            <li class="float_right">
                <a href="{{ URL::route('login') }}" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                    <i class="icon-user"></i> Đăng nhập
                </a>
            </li>
            <li class="float_right">
                <a href="#" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                    <i class="icon-key icons"></i> Đăng ký
                </a>
            </li>
        @else
            <li class="float_right">
                <a href="" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                    <i class="icon-user"></i> {{  isset($full_name) && !empty($full_name) ? $full_name : '' }}
                </a>
            </li>

            <li class="float_right">
                <a href="{{ URL::route('logout') }}" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                    Đăng xuất
                </a>
            </li>
        @endif
    </ul>
</nav>