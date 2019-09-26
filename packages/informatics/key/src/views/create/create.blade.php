@extends('base::layout.master')

@section('breadcrumb')

    @include('base::layout.partials.breadcrumb', ['title'=>'Thêm mới key', 'breadcrumbs'=>[
        ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
        ['label'=>'Thêm mới key'],
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
                                {!! Form::open( array('route' => array('key.store'), 'role' => 'form', 'method' => 'POST', 'autocomplete'=>"off")) !!}
                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            <label>App</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <select id="app" name="tool_id" class="form-control">
                                                @forelse($tools as $tool)
                                                    <option value="{{ $tool['id'] }}">{{ $tool['name'] }} ( Max point {{ $tool['max_point'] }} )</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            <label>User</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <select id="app" name="user_id" class="form-control">
                                                @forelse($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->username }} ( {{ $user->name }} )</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            <label>Point order</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="number" name="point_order" value="0" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            <label>The number of</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="number" name="number" class="form-control" placeholder="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class='form-group clearfix'>
                                        <div class="col-sm-2">
                                            <label>Expire time ( month )</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="number" name="expire_time" class="form-control" placeholder="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <a href="{{URL::route('key.index') }}" class="btn btn-link pull-left"><< Back</a>
                                    {!! Form::submit('Key generate',array('class'=>'btn btn-primary pull-left')) !!}
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