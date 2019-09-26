@extends('base::layout.master')

@section('breadcrumb')
    @if(isset($agency->id) && !empty($agency->id))
        @include('base::layout.partials.breadcrumb', ['title'=>'Cập nhật thông cộng tác viên', 'breadcrumbs'=>[
            ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
            ['label'=>'Cập nhật thông tin cộng tác viên'],
        ]])
    @else
        @include('base::layout.partials.breadcrumb', ['title'=>'Thêm mới cộng tác viên', 'breadcrumbs'=>[
            ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
            ['label'=>'Thêm mới cộng tác viên'],
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
                                @if(isset($agency->id) && !empty($agency->id))
                                    {!! Form::open( array('route' => array('admin.update', $agency->id), 'role' => 'form', 'method' => 'PUT')) !!}
                                @else
                                    {!! Form::open( array('route' => array('admin.store'), 'role' => 'form', 'method' => 'POST', 'autocomplete'=>"off")) !!}
                                @endif

                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            {!! Form::label('username', 'Tài khoản *',['class'=>'required']) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::text('username',isset($agency->username)?$agency->username:'',['placeholder'=>'Tài khoản','class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            {!! Form::label('email', 'Email *',['class'=>'required']) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::text('email',isset($agency->email)?$agency->email:'',['placeholder'=>'Email','class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                                @if(!isset($agency))
                                    <div class="col-sm-12">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-2">
                                                {!! Form::label('password', 'Mật khẩu *',['class'=>'required']) !!}
                                            </div>
                                            <div class="col-sm-4">
                                                {!! Form::password('password',['placeholder'=>'Mật khẩu','class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class='form-group clearfix'>
                                            <div class="col-sm-2">
                                                {!! Form::label('confirm_password', 'Nhập lại mật khẩu *',['class'=>'required']) !!}
                                            </div>
                                            <div class="col-sm-4">
                                                {!! Form::password('password_confirmation',['placeholder'=>'Nhập lại mật khẩu','class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            {!! Form::label('name', 'Họ tên *',['class'=>'required']) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::text('name',isset($agency->full_name)?$agency->full_name:'',['placeholder'=>'Họ tên','class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <a href="{{URL::route('admin.index') }}" class="btn btn-link pull-left"><< Back</a>
                                    @if(isset($agency->id))
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