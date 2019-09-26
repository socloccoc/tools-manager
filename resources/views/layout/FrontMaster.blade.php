<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8"/>
        <title>Tool Manager</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        @include('layout.partials.FrontStyle')

    </head>
    <body class="c-layout-header-fixed c-layout-header-mobile-fixed c-layout-header-topbar c-layout-header-topbar-collapse">

        <!-- BEGIN: HEADER -->
        <header class="c-layout-header c-layout-header-4 c-layout-header-default-mobile" data-minimize-offset="80">

            @include('layout.FrontTopBar')

            <?php
                if (Sentinel::check()) {
                    $users = Helper::getUserDetails();
                    $full_name = $users->full_name;
                    $users_email = $users->email;
                }
            ?>

            @include('layout.FrontNavigation')

        </header>

        <div class="c-layout-page">
            <!-- BEGIN: PAGE CONTENT -->
        @yield('content')
        <!-- END: PAGE CONTENT -->
        </div>

        @include('layout.FrontFooter')

        <div class="c-layout-go2top">
            <i class="icon-arrow-up"></i>
        </div>

        @include('layout.partials.FrontScript')
    </body>
</html>