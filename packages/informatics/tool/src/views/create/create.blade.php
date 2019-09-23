@extends('base::layout.master')

@section('breadcrumb')
    @if(isset($tool->id) && !empty($tool->id))
        @include('base::layout.partials.breadcrumb', ['title'=>'Cập nhật thông tin Tool', 'breadcrumbs'=>[
            ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
            ['label'=>'Cập nhật thông tin Tool'],
        ]])
    @else
        @include('base::layout.partials.breadcrumb', ['title'=>'Thêm mới một tool', 'breadcrumbs'=>[
            ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
            ['label'=>'Thêm mới một tool'],
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
                                @if(isset($tool->id) && !empty($tool->id))
                                    {!! Form::open( array('route' => array('tool.update', $tool->id), 'role' => 'form', 'method' => 'PUT')) !!}
                                @else
                                    {!! Form::open( array('route' => array('tool.store'), 'role' => 'form', 'method' => 'POST', 'autocomplete'=>"off")) !!}
                                @endif

                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            {!! Form::label('name', 'Tài khoản *',['class'=>'required']) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::text('name',isset($tool->name) ? $tool->name : '',['placeholder'=>'Tool name','class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <a href="{{URL::route('tool.index') }}" class="btn btn-link pull-left"><< Back</a>
                                    @if(isset($tool->id))
                                        {!! Form::submit('Update',array('class'=>'btn btn-primary pull-left')) !!}
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