@extends('base::layout.master')

@section('breadcrumb')

    @include('base::layout.partials.breadcrumb', ['title'=>'Danh sách người dùng', 'breadcrumbs'=>[
        ['url'=>'/user', 'label'=>'Bảng điều khiển'],
        ['label'=>'Danh sách người dùng'],
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
                        <th></th>
                        <th>{!!$columns['users.name']!!}</th>
                        <th>{!!$columns['users.email']!!}</th>
                        <th>{!!$columns['roleName.name']!!}</th>
                        <th>{!!$columns['users.last_login']!!}</th>
                        @if(Permission::isSuperAdmin())
                            <th></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if( isset($admins) && count($admins) )
                        @foreach($admins as $admin)
                            <tr>
                                <td>
                                    <a href="{{URL::route('user.edit', $admin->id)}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>{!! $admin->full_name !!}</td>
                                <td>
                                    <a>
                                        {!! $admin->email !!}
                                    </a>
                                </td>
                                <td>
                                    {{ $admin->role ? $admin->role : 'N/A'}}
                                </td>
                                <td>{!! $admin->last_login && strtotime($admin->last_login) ? date('d/m/Y h:i', strtotime($admin->last_login)) : 'N/A' !!}</td>
                                @if(Permission::isSuperAdmin())
                                    <td>
                                        {!! Form::open( array('route' => array('admin.destroy', $admin->id ),'role' => 'form','method' => 'Delete','onClick'=>"return confirm('Are you sure you want to delete?')")) !!}
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