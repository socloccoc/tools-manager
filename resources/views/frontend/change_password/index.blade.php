@extends('layout.FrontBase')

@section('base')
    <div class="c-layout-sidebar-content ">
        @include('errors.errorlist')
        <div class="c-content-title-1">
            <h3 class="c-font-uppercase c-font-bold">Đổi mật khẩu</h3>
            <div class="c-line-left"></div>
        </div>
        {!! Form::open( array('route' => array('change.password.complete'), 'role' => 'form', 'method' => 'POST', 'autocomplete'=>"off" , 'class' => 'form-horizontal form-charge', 'novalidate' => 'novalidate')) !!}
            <div class="form-group">
                <label class="col-md-3 control-label">Mật khẩu cũ:</label>
                <div class="col-md-6">
                    {!! Form::password('old_password',['placeholder'=>'Mật khẩu hiện tại', 'class' => 'form-control c-square c-theme', 'required' => 'required', 'maxlength' => '32']) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Mật khẩu mới:</label>
                <div class="col-md-6">
                    {!! Form::password('password',['placeholder'=>'Mật khẩu mới', 'class' => 'form-control c-square c-theme', 'required' => 'required', 'maxlength' => '32']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Xác nhận:</label>
                <div class="col-md-6">
                    {!! Form::password('password_confirmation',['placeholder'=>'Xác nhận mật khẩu mới', 'class' => 'form-control c-square c-theme', 'required' => 'required', 'maxlength' => '32']) !!}
                </div>
            </div>
            <div class="form-group c-margin-t-40">
                <div class="col-md-offset-3 col-md-6">
                    {{ Form::submit('Đổi mật khẩu', array('class' => 'btn btn-submit c-theme-btn c-btn-square c-btn-uppercase c-btn-bold btn-block', 'data-loading-text' => "<i class='fa fa-spinner fa-spin '></i>")) }}
                </div>
            </div>
        {{ Form::close() }}
        <script>
            $(window).load(function(){
                var bs = new base({
                    forms:[{
                        validate : true,
                        $obj : $('form')
                    }]
                });
            });
        </script>
    </div>
@endsection



