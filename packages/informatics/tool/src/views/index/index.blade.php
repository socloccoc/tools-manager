@extends('base::layout.master')

@section('breadcrumb')

    @include('base::layout.partials.breadcrumb', ['title'=>'Tools', 'breadcrumbs'=>[
        ['url'=>'/user', 'label'=>'Bảng điều khiển'],
        ['label'=>'Tools'],
    ]])

@endsection

@section('content')

    @include('errors.errorlist')

    <div class="panel">
        <div class="panel-body rr-search">
            {!! Form::open(array('route' => 'admin.index', 'method'=>'get', 'class'=>'form-inline')) !!}
            <div class="form-group">
                {!! Form::text('keyword', isset($filters["keyword"]) && $filters["keyword"] != '' ? $filters["keyword"] : '' ,array('class'=>'form-control', 'placeholder'=>'Tìm kiếm', 'autocomplete' => 'off')) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Search',array('class'=>'btn btn-primary')) !!}
                <a href="{{route('admin.index')}}" class="btn btn-default">Show All</a>
            </div>
            {!! Form::close() !!}
        </div>
        <input name="_token" type="hidden" value="{!! csrf_token() !!}"/>

        <div class='panel-body'>
            <div class="table-responsive" id="AdminsTable">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        @if(Permission::isSuperAdmin())
                            <th></th>
                        @endif
                        <th>{!!$columns['tool.name']!!}</th>
                        @if(Permission::isSuperAdmin())
                            <th></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if( isset($tools) && count($tools) )
                        @foreach($tools as $tool)
                            <tr>
                                @if(Permission::isSuperAdmin())
                                    <td>
                                        <a href="{{URL::route('tool.edit', $tool->id)}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                @endif
                                <td>{!! $tool->name !!}</td>
                                @if(Permission::isSuperAdmin())
                                    <td>
                                        {!! Form::open( array('route' => array('tool.destroy', $tool->id ),'role' => 'form','method' => 'Delete','onClick'=>"return confirm('Bạn có chắc chắn muốn xóa không?')")) !!}
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class='text-center text-bold'>No Record Found.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <hr>
            @include('partials.paginate_bottom')
        </div>
    </div>

@endsection