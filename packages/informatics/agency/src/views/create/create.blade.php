@extends('base::layout.master')

@section('breadcrumb')
    @if(isset($user->id) && !empty($user->id))
        @include('base::layout.partials.breadcrumb', ['title'=>'Cập nhật thông tin người dùng', 'breadcrumbs'=>[
            ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
            ['label'=>'Cập nhật thông tin người dùng'],
        ]])
    @else
        @include('base::layout.partials.breadcrumb', ['title'=>'Thêm mới người dùng', 'breadcrumbs'=>[
            ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
            ['label'=>'Thêm mới người dùng'],
        ]])
    @endif

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
                                @if(isset($user->id) && !empty($user->id))
                                    {!! Form::open( array('route' => array('user.update', $user->id), 'role' => 'form', 'method' => 'PUT')) !!}
                                @else
                                    {!! Form::open( array('route' => array('user.store'), 'role' => 'form', 'method' => 'POST', 'autocomplete'=>"off")) !!}
                                @endif
                                <div class="col-sm-6">
                                    <div class="col-sm-12">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-3">
                                                {!! Form::label('username', 'Tài khoản *',['class'=>'required']) !!}
                                            </div>
                                            <div class="col-sm-7">
                                                {!! Form::text('username', isset($user->username) ? $user->username : '', ['placeholder'=>'Tài khoản','class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-3">
                                                {!! Form::label('email', 'Email *',['class'=>'required']) !!}
                                            </div>
                                            <div class="col-sm-7">
                                                {!! Form::text('email', isset($user->email) ? $user->email : '', ['placeholder'=>'Email','class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    @if(!isset($user))
                                        <div class="col-sm-12">
                                            <div class='form-group clearfix'>
                                                <div class="col-sm-3">
                                                    {!! Form::label('password', 'Mật khẩu *',['class'=>'required']) !!}
                                                </div>
                                                <div class="col-sm-7">
                                                    {!! Form::password('password', ['placeholder'=>'Mật khẩu','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class='form-group clearfix'>
                                                <div class="col-sm-3">
                                                    {!! Form::label('confirm_password', 'Nhập lại mật khẩu *',['class'=>'required']) !!}
                                                </div>
                                                <div class="col-sm-7">
                                                    {!! Form::password('password_confirmation', ['placeholder'=>'Nhập lại mật khẩu','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-sm-12">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-3">
                                                {!! Form::label('name', 'Họ tên *',['class'=>'required']) !!}
                                            </div>
                                            <div class="col-sm-7">
                                                {!! Form::text('name', isset($user->full_name) ? $user->full_name : '', ['placeholder'=>'Họ tên','class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 clearfix">
                                    <a href="{{URL::route('user.index') }}" class="btn btn-link pull-left"><< Back</a>
                                    @if(isset($user->id))
                                        {!! Form::submit('Update',array('class'=>'btn btn-primary pull-left','id'=>'updateSystemProfileBtn')) !!}
                                    @else
                                        {!! Form::submit('Save',array('class'=>'btn btn-primary pull-left')) !!}
                                    @endif
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