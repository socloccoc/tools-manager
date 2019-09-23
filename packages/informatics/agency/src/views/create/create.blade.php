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
                                                {!! Form::text('username',isset($user->username)?$user->username:'',['placeholder'=>'Tài khoản','class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-3">
                                                {!! Form::label('email', 'Email *',['class'=>'required']) !!}
                                            </div>
                                            <div class="col-sm-7">
                                                {!! Form::text('email',isset($user->email)?$user->email:'',['placeholder'=>'Email','class' => 'form-control']) !!}
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
                                                    {!! Form::password('password',['placeholder'=>'Mật khẩu','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class='form-group clearfix'>
                                                <div class="col-sm-3">
                                                    {!! Form::label('confirm_password', 'Nhập lại mật khẩu *',['class'=>'required']) !!}
                                                </div>
                                                <div class="col-sm-7">
                                                    {!! Form::password('password_confirmation',['placeholder'=>'Nhập lại mật khẩu','class' => 'form-control']) !!}
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
                                                {!! Form::text('name',isset($user->full_name)?$user->full_name:'',['placeholder'=>'Họ tên','class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="col-sm-12">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-3">
                                            {!! Form::label('reg_nick_key', 'Reg nick',['class'=>'']) !!}
                                            </div>
                                            <div class="col-sm-7">
                                            {!! Form::text('reg_nick_key',isset($user->reg_nick_key) ? $user->reg_nick_key : '',['placeholder'=>'Reg nick ( key )', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-3">
                                            {!! Form::label('sub_view_key', 'Sub view',['class'=>'']) !!}
                                            </div>
                                            <div class="col-sm-7">
                                            {!! Form::text('sub_view_key',isset($user->sub_view_key) ? $user->sub_view_key : '',['placeholder'=>'Sub view ( key )', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-3">
                                                {!! Form::label('order_key', 'Order',['class'=>'']) !!}
                                            </div>
                                            <div class="col-sm-7">
                                                {!! Form::text('order_key',isset($user->order_key) ? $user->order_key : '',['placeholder'=>'Order ( key )', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-3">
                                                {!! Form::label('order_mobile_key', 'Order mobile',['class'=>'']) !!}
                                            </div>
                                            <div class="col-sm-7">
                                                {!! Form::text('order_mobile_key',isset($user->order_mobile_key) ? $user->order_mobile_key : '',['placeholder'=>'Order mobile ( key )', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-3">
                                                {!! Form::label('seller', 'Seller',['class'=>'']) !!}
                                            </div>
                                            <div class="col-sm-7">
                                                {!! Form::text('seller_key',isset($user->seller_key) ? $user->seller_key : '',['placeholder'=>'Seller ( key )', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <hr>
                                    @if(isset($user))
                                    <div class="col-sm-6">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-3">
                                                {!! Form::label('current_point', 'Số point hiện có',['class'=>'']) !!}
                                            </div>
                                            <div class="col-sm-4">
                                                {!! 12345 !!}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-sm-6">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-3">
                                                {!! Form::label('point', 'Thêm point',['class'=>'']) !!}
                                            </div>
                                            <div class="col-sm-4">
                                                {!! Form::number('point', 0, ['placeholder'=>'point', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <a href="{{URL::route('admin.index') }}" class="btn btn-link pull-left"><< Back</a>
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