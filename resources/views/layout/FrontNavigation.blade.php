<div class="c-navbar">
    <div class="container">
        <!-- BEGIN: BRAND -->
        <div class="c-navbar-wrapper clearfix">
            <div class="c-brand c-pull-left absolute_pos">
                <h1 style="margin: 0; margin-top: 20px;display: inline-block">
                    <a href="{{ URL::to('/') }}" class="c-logo">
                        <img height="35px" src="{{ asset('images/logo.png') }}" class="c-desktop-logo">
                    </a>
                </h1>
                <style type="text/css">
                    @media screen and (max-width: 991px) {
                        .c-mobile-logo {
                            position: absolute;
                            left: calc(50% - 5%);
                            left: -webkit-calc(50% - 5%);
                            top: 1.5vh;
                        }

                        .c-btn-uppercase.btn-sm {
                            padding: 3px 9px 0px 7px
                        }

                        .c-btn-border-1x.c-btn-dark {
                            border-color: #2f353b;
                            color: #2f353b;
                            background: none;
                            font-size: 1.1vh;
                        }

                        .button_top {
                            margin: 0 !important;
                            position: absolute;
                            top: 2.5vh;
                            left: 0.2vh;
                        }

                        .top_button {
                            float: left;
                            margin-left: 0.5vh
                        }

                        .float_right {
                            display: none !important;
                        }
                    }

                    @media only screen and (min-width: 1290px) {
                        .nav_container {
                            position: relative;
                        }

                        .c-pull-left.absolute_pos {
                            position: absolute;
                            width: 100%;
                            left: 0;
                            margin: 0;
                            top: -10px
                        }

                        .c-page-on-scroll .c-pull-left.absolute_pos {
                            top: 0px
                        }

                        .c-layout-header .c-brand {
                            margin: 0 !important;
                        }

                        .c-pull-left h1 {
                            width: 100%;
                            display: block;
                        }

                        .c-logo {
                            display: block;
                        }

                        .c-logo img {
                            margin: 0 auto
                        }

                        .c-layout-header .c-brand .c-desktop-logo {
                            height: 135px !important;
                            display: block;
                        }

                        .c-page-on-scroll.c-layout-header-fixed .c-layout-header .c-brand .c-desktop-logo {
                            display: none !important;
                        }

                        .c-layout-header .c-navbar .c-mega-menu.c-pull-right {
                            float: left;
                            width: 100%;
                        }

                        .float_right {
                            float: right !important
                        }

                        .c-layout-header .c-navbar .c-mega-menu > .nav.navbar-nav {
                            width: 100%
                        }

                        .c-page-on-scroll.c-layout-header-fixed .c-layout-header .c-brand .c-desktop-logo-inverse {
                            height: 85px !important;
                        }
                    }
                </style>
            </div>

            <style>
                .c-menu-type-mega:hover {
                    transition-delay: 1s;
                }

                .c-layout-header.c-layout-header-4 .c-navbar .c-mega-menu > .nav.navbar-nav > li:focus > a:not(.btn),
                .c-layout-header.c-layout-header-4 .c-navbar .c-mega-menu > .nav.navbar-nav > li:active > a:not(.btn),
                .c-layout-header.c-layout-header-4 .c-navbar .c-mega-menu > .nav.navbar-nav > li:hover > a:not(.btn) {
                    color: #3a3f45;
                    background: #FAFAFA;
                }
            </style>

            {{--@include('layout.partials.NavigationMobile')--}}

            <nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold d-none hidden-xs hidden-sm">

                <ul class="nav navbar-nav c-theme-nav ">

                    {{--@include('layout.partials.FrontMenu')--}}

                    @if(!Sentinel::check())
                        <li class="float_right">
                            <a href="{{ URL::route('login') }}" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                                <i class="icon-user"></i> Đăng nhập
                            </a>
                        </li>
                        {{--<li class="float_right">--}}
                            {{--<a href="#" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">--}}
                                {{--<i class="icon-key icons"></i> Đăng ký--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    @else
                        <li class="float_right">
                            <a href="{{ URL::route('user.profile') }}" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
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

        </div>

    </div>
</div>