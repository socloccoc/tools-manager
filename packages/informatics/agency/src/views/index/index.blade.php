@extends('base::layout.master')

@section('breadcrumb')

    @include('base::layout.partials.breadcrumb', ['title'=>'Danh sách người dùng', 'breadcrumbs'=>[
        ['url'=>'/user', 'label'=>'Bảng điều khiển'],
        ['label'=>'Danh sách người dùng'],
    ]])

@endsection

@section('content')

    @include('errors.errorlist')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="panel">
        <input name="_token" type="hidden" value="{!! csrf_token() !!}"/>
        <div class='panel-body'>
            <div class="table-responsive" id="AdminsTable">
                <table class="table table-bordered" id="example">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Last login</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( isset($admins) && count($admins) )
                        @foreach($admins as $admin)
                            <tr>
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
                                <td>
                                    {!! isset($admin->type) && $admin->type == 1 ? 'Vip' : '' !!}
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{URL::route('user.edit', $admin->id)}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa không ?')"
                                       class="btn btn-danger"
                                       href="{{ route('user.deleteUser', ['id' => $admin->id]) }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class='text-center text-bold'>No Record Found.</td>
                        </tr>
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Lass login</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <hr>
            @include('partials.paginate_bottom')
        </div>
    </div>

@endsection
@section('javascript')
    @parent
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>
    <script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
                responsive: true
            });
        });
    </script>
@endsection