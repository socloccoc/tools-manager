@extends('layout.FrontMaster')

@section('content')
<div class="login-box">
    <!-- /.login-logo -->
    <div class="login-box-body box-custom">
        <p class="login-box-msg">Đăng nhập hệ thống</p>
        {!! Form::open(array('method'=>'post')) !!}
            @include('errors.errorlist')
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="username" value=""
                    placeholder="Tài khoản">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>

            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="checkbox icheck">
                        <label style="color: #666">
                            <input type="checkbox" name="remember" id="remember"> Ghi nhớ ?
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin: 0 auto;">Đăng nhập</button>
                </div>
            </div>
        {!!Form::close()!!}
    </div>
</div>

<style>
    .login-box,
    .register-box {
        width: 400px;
        margin: 7% auto;

        padding: 20px;
        ;
    }



    @media (max-width: 767px) {

        .login-box,
        .register-box {
            width: 100%;
        }

    }

    .login-box-msg,
    .register-box-msg {
        margin: 0;
        text-align: center;
        padding: 0 20px 20px 20px;
        text-align: center;
        font-size: 20px;
        ;
        font-weight: bold;
    }

    .box-custom {
        border: 1px solid #cccccc;
        padding: 20px;

        color: #666;
    }
</style>
@endsection