@extends('base::layout.master')

@section('breadcrumb')
    @include('base::layout.partials.breadcrumb', ['title'=>'Cập nhật thông tin', 'breadcrumbs'=>[
        ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
        ['label'=>'Cập nhật thông tin'],
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
                                {!! Form::open( array('route' => array('analytics.update', $fee->id), 'role' => 'form', 'method' => 'PUT')) !!}
                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            {!! Form::label('value', 'Value *',['class'=>'required']) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::number('value',isset($fee->value) ? $fee->value : 0,['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <a href="{{URL::route('analytics.index') }}" class="btn btn-link pull-left"><< Back</a>
                                    {!! Form::submit('Update',array('class'=>'btn btn-primary pull-left')) !!}
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