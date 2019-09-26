<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tools Manager</title>

    @foreach ($stylesheets as $style)
        {!! HTML::style($style) !!}
    @endforeach

    @foreach ($headScripts as $script)
        @if (is_array($script))
            {!! HTML::script($script['url']) !!}
            @if ($script['fallback'])
                <script>window.{!! $script['fallback'] !!} || document.write('<script src="{{ $script['fallbackURL'] }}"><\/script>')</script>
            @endif
        @else
            {!! HTML::script($script) !!}
        @endif
    @endforeach

    @yield('head')

</head>

<body>

<div class="br-logo"><a href=""><span>[</span>Manager<span>]</span></a></div>

<?php
    if (Sentinel::check()) {
        $user = Helper::getUserDetails();
        $users_name = $user->full_name;
        $users_email = $user->email;
        $user_picture  = $user->avatar;
    }
?>

@include('base::layout.partials.sidebar')

@include('base::layout.partials.top-header')

@include('base::layout.partials.right-side-bar')

<div class="br-mainpanel">

    @yield('breadcrumb')

    <div class="br-pagebody">

        @yield('content')

    </div>

</div>


@foreach ($bodyScripts as $script)
    {!! HTML::script($script) !!}
@endforeach

<!-- Javascript Libraries -->
<script>
    let _token = '{{ csrf_token() }}';
</script>

@yield('javascript')

</body>
</html>
