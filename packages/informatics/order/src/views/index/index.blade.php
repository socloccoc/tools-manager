@extends('base::layout.master')

@section('breadcrumb')

    @include('base::layout.partials.breadcrumb', ['title'=>'Orders', 'breadcrumbs'=>[
        ['url'=>'/user', 'label'=>'Bảng điều khiển'],
        ['label'=>'Orders'],
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
                        <th>Buyer name</th>
                        <th>Product name</th>
                        <th>Shơp name</th>
                        <th>Product number</th>
                        <th>Address</th>
                        <th>Transport</th>
                        <th>Created at</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( isset($orders) && count($orders) )
                        @foreach($orders as $order)
                            <tr>
                                @if(Permission::isSuperAdmin())
                                    <td>{!! $order->user->username !!}</td>
                                @endif
                                <td>{!! $order->buyer_name !!}</td>
                                <td>{!! $order->product_name !!}</td>
                                <td>{!! $order->shop_name !!}</td>
                                <td>{!! $order->product_number !!}</td>
                                <td>{!! $order->address !!}</td>
                                <td>{!! $order->transport !!}</td>
                                <td>{!! $order->created_at !!}</td>
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