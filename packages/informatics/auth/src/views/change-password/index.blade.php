@extends('base::layout.master')

@section('breadcrumb')

    @include('base::layout.partials.breadcrumb', ['title'=>'Thay đổi password', 'breadcrumbs'=>[
        ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
        ['label'=>'Thay đổi password'],
    ]])

@endsection

@section('content')

    @include('errors.errorlist')

    <div class="row">
        <div class="col-xs-12">
            <div class="tab-base">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Thông tin chi tiết</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row mg-t-80">
                            <div class="col-sm-12">
                                {!! Form::open( array('route' => array('change.password.complete'), 'role' => 'form', 'method' => 'POST', 'autocomplete'=>"off")) !!}
                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            <label>Mật khẩu hiện tại</label>
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::password('old_password',['placeholder'=>'Mật khẩu hiện tại', 'class' => 'form-control c-square c-theme', 'required' => 'required', 'maxlength' => '32']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            <label>Mật khẩu mới</label>
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::password('password',['placeholder'=>'Mật khẩu mới', 'class' => 'form-control c-square c-theme', 'required' => 'required', 'maxlength' => '32']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            <label>Xác nhận</label>
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::password('password_confirmation',['placeholder'=>'Xác nhận mật khẩu mới', 'class' => 'form-control c-square c-theme', 'required' => 'required', 'maxlength' => '32']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <a href="{{URL::route('key.index') }}" class="btn btn-link pull-left"><< Back</a>
                                    {!! Form::submit('Change password',array('class'=>'btn btn-primary pull-left')) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection