@extends('base::layout.master')

@section('breadcrumb')
    @if(isset($link->id) && !empty($link->id))
        @include('base::layout.partials.breadcrumb', ['title'=>'Cập nhật thông tin Link', 'breadcrumbs'=>[
            ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
            ['label'=>'Cập nhật thông tin Link'],
        ]])
    @else
        @include('base::layout.partials.breadcrumb', ['title'=>'Thêm mới một Link', 'breadcrumbs'=>[
            ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
            ['label'=>'Thêm mới một Link'],
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
                                @if(isset($link->id) && !empty($link->id))
                                    {!! Form::open( array('route' => array('affiliate.update', $link->id), 'role' => 'form', 'method' => 'PUT')) !!}
                                @else
                                    {!! Form::open( array('route' => array('affiliate.store'), 'role' => 'form', 'method' => 'POST', 'autocomplete'=>"off")) !!}
                                @endif

                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            {!! Form::label('url', 'Url *',['class'=>'required']) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::text('url',isset($link->url) ? $link->url : '',['placeholder'=>'Url','class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <a href="{{URL::route('affiliate.index') }}" class="btn btn-link pull-left"><< Back</a>
                                    @if(isset($link->id))
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