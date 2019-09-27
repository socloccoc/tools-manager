@extends('base::layout.master')

@section('breadcrumb')

    @include('base::layout.partials.breadcrumb', ['title'=>'Keys', 'breadcrumbs'=>[
        ['url'=>'/user', 'label'=>'Bảng điều khiển'],
        ['label'=>'Keys'],
    ]])

@endsection

@section('content')

    @include('errors.errorlist')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="panel">
        <div class="panel-body rr-search">
            <form method="GET" action="{{ route('key.index') }}">
                <div class="col-sm-12 form-row"
                     style="border: 1px solid #cccccc; padding: 15px; margin-bottom: 20px; border-radius: 10px;">
                    <div class="form-group col-sm-3" style="padding: 0px">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control form-inline">
                            <option {{ isset($status) && $status == -1 ? 'selected' : '' }} value="-1">--- All ---</option>
                            @forelse(config('constants.key_status') as $index => $st)
                                <option {{ isset($status) && $status == $st ? 'selected' : '' }} value="{{ $st }}">{{ $index }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="user_id">User</label>
                        <select id="user_id" name="user_id" class="form-control form-inline">
                            <option value="">--- All ---</option>
                            @forelse($users as $index => $user)
                                <option {{ isset($userId) && $userId == $user['id'] ? 'selected' : '' }} value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <button style="margin-top: 24px" type="submit" class="btn btn-primary">Tìm kiếm</button>
                        <a href="{{ route('key.index') }}" style="margin-top: 24px" type="submit" class="btn btn-success">Reset</a>
                    </div>
                </div>
            </form>
        </div>
        <input name="_token" type="hidden" value="{!! csrf_token() !!}"/>
        <div class='panel-body'>
            <div class="table-responsive" id="AdminsTable">
                <table class="table table-bordered" id="key-datatable">
                    <thead>
                    <tr>
                        <th> App</th>
                        <th> User</th>
                        <th> Licence</th>
                        @if(Permission::isSuperAdmin())
                            <th>Serial number</th>
                        @endif
                        <th> Expire time</th>
                        <th> Expire date</th>
                        <th> Point order</th>
                        <th> Point register</th>
                        <th> Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( isset($keys) && count($keys) )
                        @foreach($keys as $key)
                            <tr>
                                <td>{!! $key['tool']['name'] !!}</td>
                                <td>{!! $key['user']['name'] !!}</td>
                                <td>{!! $key['licence_key'] !!}</td>
                                @if(Permission::isSuperAdmin())
                                    <td>{!! $key['serial_number'] !!}</td>
                                @endif
                                <td>{!! $key['expire_time'] !!}</td>
                                <td>{!! $key['expire_date'] !!}</td>
                                <td>{!! $key['point_order'] !!}</td>
                                <td>{!! $key['point_register'] !!}</td>
                                @if(Permission::isSuperAdmin())
                                    <td>
                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa không ?')"
                                           class="btn btn-danger"
                                           href="{{ route('key.deleteKey', ['id' => $key['id']]) }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <button type="button" class="btn btn-primary edit-loadModal"
                                                key_id="{{ isset($key['id']) ? $key['id'] : '' }}" data-toggle="modal"
                                                data-target="#updateExpireTimeModal"><i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                @endif
                                @if(Permission::isAgency())
                                    <td>
                                        <a onclick="return confirm('Bạn có chắc chắn muốn đổi máy không ?')"
                                           class="btn btn-danger"
                                           href="{{ route('key.changeSirial', ['id' => $key['id']]) }}">đổi máy
                                        </a>
                                        <button type="button" class="btn btn-primary adjourn-loadModal"
                                                key_id="{{ isset($key['id']) ? $key['id'] : '' }}" data-toggle="modal"
                                                data-target="#keyAdjourn">Gia hạn
                                        </button>
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
        </div>
        <!-- Modal -->
        <div class="modal fade" id="updateExpireTimeModal" tabindex="-1" role="dialog"
             aria-labelledby="updateExpireTimeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div style="width: 450px" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Key</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('key.updateKey') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="Expire time">Expire Date</label>
                                <input type="text" class="form-control" id="expire_date" name="expire_date">
                                <input type="number" class="form-control modal-key-id" hidden name="modal_key_id">
                            </div>
                            <div class="form-group">
                                <label for="serial_number">Serial</label>
                                <input type="text" class="form-control" id="serial_number" name="serial_number">
                            </div>
                            <div class="form-group">
                                <label for="Point">Point order</label>
                                <input type="number" class="form-control" id="point_order" name="point_order">
                            </div>
                            <div class="form-group">
                                <label for="Point">Point register</label>
                                <input type="number" class="form-control" id="point_register" name="point_register">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="keyAdjourn" tabindex="-1" role="dialog"
         aria-labelledby="keyAdjourn" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div style="width: 450px" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gia hạn</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('key.adjourn') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="number_of_months">Number of months</label>
                            <input type="number" class="form-control" id="number_of_months" name="number_of_months" value="0">
                            <input type="number" class="form-control modal-key-adjourn-id" hidden name="modal_key_adjourn_id">
                        </div>
                        <div class="form-group">
                            <label for="point_order">Point order</label>
                            <input type="number" class="form-control" id="point_order" name="point_order" value="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Gia hạn</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('javascript')
    @parent

    {{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>
    {{--<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js" defer></script>--}}
    <script>
        $(document).ready(function () {
            var table = $('#key-datatable').DataTable({
                responsive: true
            });
            // new $.fn.dataTable.FixedHeader(table);
            $('#key-datatable_wrapper').on('click keyup keypress', function () {
                $('.loadModal').each(function (index, elem) {
                    $(this).on('click', function (e) {
                        var CSRF_TOKEN = $('input[name="_token"]').val();
                        var key_id = $(this).attr('key_id');
                        $.ajax({
                            url: '/manager/ajax/getKeyInfo',
                            type: 'POST',
                            data: {_token: CSRF_TOKEN, keyId: key_id},
                            dataType: 'JSON',
                            success: function (data) {
                                console.log(data);
                                if (data !== null) {
                                    $('#expire_date').val(data.expire_date);
                                    $('#point_order').val(data.point_order);
                                    $('#point_register').val(data.point_register);
                                    $('#serial_number').val(data.serial_number);
                                    $('.modal-key-id').val(data.id);
                                }
                            }
                        });
                    });
                });
            });
            $('.edit-loadModal').each(function (index, elem) {
                $(this).on('click', function (e) {
                    var CSRF_TOKEN = $('input[name="_token"]').val();
                    var key_id = $(this).attr('key_id');
                    $.ajax({
                        url: '/manager/ajax/getKeyInfo',
                        type: 'POST',
                        data: {_token: CSRF_TOKEN, keyId: key_id},
                        dataType: 'JSON',
                        success: function (data) {
                            console.log(data);
                            if (data !== null) {
                                $('#expire_date').val(data.expire_date);
                                $('#point_order').val(data.point_order);
                                $('#point_register').val(data.point_register);
                                $('#serial_number').val(data.serial_number);
                                $('.modal-key-id').val(data.id);
                            }
                        }
                    });
                });
            });

            $('.adjourn-loadModal').each(function (index, elem) {
                $(this).on('click', function (e) {
                    // var CSRF_TOKEN = $('input[name="_token"]').val();
                    var key_id = $(this).attr('key_id');
                    $('.modal-key-adjourn-id').val(key_id);
                    // $.ajax({
                    //     url: '/manager/ajax/getKeyInfo',
                    //     type: 'POST',
                    //     data: {_token: CSRF_TOKEN, keyId: key_id},
                    //     dataType: 'JSON',
                    //     success: function (data) {
                    //         console.log(data);
                    //         if (data !== null) {
                    //             $('#expire_date').val(data.expire_date);
                    //             $('#point_order').val(data.point_order);
                    //             $('#point_register').val(data.point_register);
                    //             $('#serial_number').val(data.serial_number);
                    //             $('.modal-key-id').val(data.id);
                    //         }
                    //     }
                    // });
                });
            });
        });
    </script>
@endsection