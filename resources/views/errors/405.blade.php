@extends('base::layouts.master')

@section('content')
    <div class="login-box">
        <div class="well">
            <div class="login-box-body">
                <h1 class="text-yellow">
                    405 Error Page
                </h1>
                <h3><i class="fa fa-warning text-yellow"></i> You do not have access to view this
                    page.</h3>
                <br/>
                <p>
                    You may return to
                    @if(Sentinel::check())
                        <a href="{{URL::to('login')}}">
                            dashboard.
                        </a>
                    @else
                        <a href="{{URL::to('/')}}">
                            homepage.
                        </a>
                    @endif
                </p>
            </div>
        </div>
    </div>
@stop