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
                    </tr>
                    </thead>
                    <tbody>
                    @if( isset($orders) && count($orders) )
                        @foreach($orders as $order)
                            <tr>
                                @if(Permission::isSuperAdmin())
                                    <td>{!! $order->user->username !!}</td>
                                @endif
                                <td>{!! $order->full_name !!}</td>
                                <td>{!! $order->phone !!}</td>
                                <td>{!! $order->province !!}</td>
                                <td>{!! $order->district !!}</td>
                                <td>{!! $order->village !!}</td>
                                <td>{!! $order->street !!}</td>
                                <td>{!! $order->store_name !!}</td>
                                <td>{!! $order->product_name !!}</td>
                                <td>{!! $order->product_link !!}</td>
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
    </div>

@endsection
@section('javascript')
    @parent

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>
    <script>
        $(document).ready(function () {
            var table = $('#orderDataTable').DataTable({
                responsive: true
            });
        });
    </script>
@endsection