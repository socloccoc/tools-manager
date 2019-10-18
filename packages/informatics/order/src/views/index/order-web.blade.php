@extends('base::layout.master')

@section('breadcrumb')

    @include('base::layout.partials.breadcrumb', ['title'=>'Danh sách đơn hàng', 'breadcrumbs'=>[
        ['url'=>'/user', 'label'=>'Bảng điều khiển'],
        ['label'=>'Danh sách đơn hàng'],
    ]])

@endsection

@section('content')

    @include('errors.errorlist')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="panel">
        <div class="panel-body rr-search">
            <form method="GET" action="{{ route('order.list.web') }}">
                <div class="col-sm-12 form-row"
                     style="border: 1px solid #cccccc; padding: 15px; margin-bottom: 20px; border-radius: 10px;">

                    <div class="form-group col-sm-3">
                        <label for="user_id">Date</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                            <input id="date" type="text" name="date" class="form-control" placeholder="yyyy-mm-dd"
                                   autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="user_id">User</label>
                        <select id="user_id" name="user_id" class="form-control form-inline">
                            <option {{ isset($userId) && $userId == -1 ? 'selected' : '' }} value="-1">--- All ---
                            </option>
                            @forelse($users as $index => $user)
                                <option {{ isset($userId) && $userId == $user['id'] ? 'selected' : '' }} value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="session">Session</label>
                        <select id="session" name="session" class="form-control form-inline">
                            <option {{ isset($session) && $session == -1 ? 'selected' : '' }} value="-1">--- All ---
                            </option>
                            @forelse($sessions as $index => $session)
                                <option {{ isset($session) && $session == $session['session'] ? 'selected' : '' }} value="{{ $session['session'] }}">{{ $session['session'] }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <button style="margin-top: 24px" type="submit" class="btn btn-primary">Tìm kiếm</button>
                        <a href="{{ route('order.list.web') }}" style="margin-top: 24px" type="submit"
                           class="btn btn-success">Reset</a>
                        <input style="margin-top: 24px" type="submit" name="export" value="export"
                               class="btn btn-danger">
                    </div>
                </div>
            </form>
        </div>
        <input name="_token" type="hidden" value="{!! csrf_token() !!}"/>
        <div class='panel-body'>
            <div class="table-responsive">
                <table class="table table-bordered" id="orderDataTable">
                    <thead>
                    <tr>
                        @if(Permission::isSuperAdmin())
                            <th>User name</th>
                        @endif
                        <th>Họ Và Tên</th>
                        <th>SĐT</th>
                        <th>Tỉnh</th>
                        <th>Huyện</th>
                        <th>Xã</th>
                        <th>Đường</th>
                        <th>Tên Store</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Đơn Hàng/Link sp</th>
                        <th>Phiên</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( isset($orders) && count($orders) )
                        @foreach($orders as $order)
                            <tr>
                                @if(Permission::isSuperAdmin())
                                    <td>{!! $order->user->username !!}</td>
                                @endif
                                <td>{!! $order['full_name'] !!}</td>
                                <td>{!! $order['phone'] !!}</td>
                                <td>{!! $order['province'] !!}</td>
                                <td>{!! $order['district'] !!}</td>
                                <td>{!! $order['village'] !!}</td>
                                <td>{!! $order['street'] !!}</td>
                                <td>{!! $order['store_name'] !!}</td>
                                <td>{!! $order['product_name'] !!}</td>
                                <td>{!! $order['product_link'] !!}</td>
                                <td>{!! $order['session'] !!}</td>
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
            {{--<div class="col-sm-12">--}}
            {{--<button type="submit" class="btn btn-lg btn-success">Xuất File</button>--}}
            {{--</div>--}}
        </div>
    </div>

@endsection
@section('javascript')
    @parent

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>
    <script>
        $(document).ready(function () {
            var urlParams = new URLSearchParams(window.location.search);
            var date = urlParams.get('date');
            $('#date').datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $('#date').datepicker('setDate', date);
            var table = $('#orderDataTable').DataTable({
                responsive: true,
                searching: false
            });

            $('#date').on('change', function () {
                var date = $(this).val();
                var elm = $(this);
                $.ajax({
                    url: '/order/ajax/getSessionByDate',
                    type: 'GET',
                    data: {date: date},
                    dataType: 'JSON',
                    success: function (data) {
                        elm.parents('.rr-search').find('#session').find('option').not(':first').remove();
                        $.each(data, function (i, item) {
                            elm.parents('.rr-search').find('#session').append($('<option>', {
                                value: item.session,
                                text: item.session
                            }));
                        });
                    }
                });
            });

        });
    </script>
@endsection