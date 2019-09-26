@extends('layout.FrontMaster')

@section('content')

    <div class="container">

        @include('layout.FrontSidebarMenu')

        @yield('base')

    </div>

@endsection