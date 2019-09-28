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
        @if(\App\Helpers\PermissionHelper::isSuperAdmin())
            <div class="panel-body rr-search">
                <form method="GET" action="{{ route('user.index') }}">
                    <div class="col-sm-12 form-row"
                         style="border: 1px solid #cccccc; padding: 15px; margin-bottom: 20px; border-radius: 10px;">
                        <div class="form-group col-sm-3">
                            <label for="agency">Agency</label>
                            <select id="agency" name="agency" class="form-control form-inline">
                                <option value="-1">--- All ---</option>
                                @forelse($agencys as $index => $user)
                                    <option {{ isset($agency) && $agency == $user['id'] ? 'selected' : '' }} value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button style="margin-top: 24px" type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <a href="{{ route('user.index') }}" style="margin-top: 24px" type="submit" class="btn btn-success">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        @endif
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
                    @if( isset($users) && count($users) )
                        @foreach($users as $user)
                            <tr>
                                <td>{!! $user->full_name !!}</td>
                                <td>
                                    <a>
                                        {!! $user->email !!}
                                    </a>
                                </td>
                                <td>
                                    {{ $user->role ? $user->role : 'N/A'}}
                                </td>
                                <td>{!! $user->last_login && strtotime($user->last_login) ? date('d/m/Y h:i', strtotime($user->last_login)) : 'N/A' !!}</td>
                                <td>
                                    {!! isset($user->type) && $user->type == 1 ? 'Vip' : '' !!}
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{URL::route('user.edit', $user->id)}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa không ?')"
                                       class="btn btn-danger"
                                       href="{{ route('user.deleteUser', ['id' => $user->id]) }}">
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