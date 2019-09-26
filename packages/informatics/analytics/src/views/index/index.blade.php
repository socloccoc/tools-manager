@extends('base::layout.master')

@section('breadcrumb')

    @include('base::layout.partials.breadcrumb', ['title'=>'Thống kê', 'breadcrumbs'=>[
        ['url'=>'/user', 'label'=>'Bảng điều khiển'],
        ['label'=>'Thông kê'],
    ]])

@endsection

@section('content')

    @include('errors.errorlist')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="panel">
        <div class="panel-body rr-search">
            <form method="GET" action="{{ route('analytics.index') }}">
                <div class="col-sm-12 form-row"
                     style="border: 1px solid #cccccc; padding: 15px; margin-bottom: 20px; border-radius: 10px;">
                    <div class="form-group col-sm-3" style="padding: 0px">
                        <label for="action">Action</label>
                        <select id="action" name="action" class="form-control form-inline">
                            @forelse(config('constants.key_action') as $index => $st)
                                <option {{ isset($action) && $action == $st ? 'selected' : '' }} value="{{ $st }}">{{ $index }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="tool">App</label>
                        <select id="tool" name="tool" class="form-control form-inline">
                            @forelse($tools as $tl)
                                <option {{ isset($tool) && $tool == $tl['id'] ? 'selected' : '' }} value="{{ $tl['id'] }}">{{ $tl['name'] }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="user_id">Collaborators</label>
                        <select id="user_id" name="user_id" class="form-control form-inline">
                            @forelse($users as $index => $user)
                                <option {{ isset($userId) && $userId == $user['id'] ? 'selected' : '' }} value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-sm-3"></div>
                    <div class="form-group col-sm-3">
                        <label for="user_id">From date</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                            <input id="fromDate" type="text" name="from_date" class="form-control" placeholder="yyyy-mm-dd" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="user_id">To date</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                            <input id="toDate" type="text" name="to_date" class="form-control" placeholder="yyyy-mm-dd" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <button style="margin-top: 24px" type="submit" class="btn btn-primary">Tìm kiếm</button>
                        <a href="{{ route('analytics.index') }}" style="margin-top: 24px" type="submit" class="btn btn-success">Reset</a>
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
                        <th> Value</th>
                        <th> Action</th>
                        <th> Created at</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( isset($fees) && count($fees) )
                        @foreach($fees as $fee)
                            <tr>
                                <td>{!! $fee['tool']['name'] !!}</td>
                                <td>{!! $fee['user']['name'] !!}</td>
                                <td>{!! $fee['licence_key'] !!}</td>
                                <td>{!! $fee['value'] !!}</td>
                                <td>{!! array_search ($fee['action'], config('constants.key_action')); !!}</td>
                                <td>{!! $fee['created_at'] !!}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class='text-center text-bold'>No Record Found.</td>
                        </tr>
                    @endif
                    </tbody>
                    <tfoot>
                        <td></td><td></td>
                        <td>Total Value : </td>
                        <td>{{ number_format($totalValue) }}</td>
                        <td></td><td></td>
                    </tfoot>
                </table>
            </div>
            <hr>
        </div>
    </div>
@endsection
@section('javascript')
    @parent

    {{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>
    <script>
        $(document).ready(function () {
            const urlParams = new URLSearchParams(window.location.search);
            const from_date = urlParams.get('from_date');
            const to_date = urlParams.get('to_date');
            $('#fromDate').datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $('#toDate').datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $('#fromDate').datepicker('setDate', from_date);
            $('#toDate').datepicker('setDate', to_date);
            var table = $('#key-datatable').DataTable({
                responsive: true
            });
        });
    </script>
@endsection