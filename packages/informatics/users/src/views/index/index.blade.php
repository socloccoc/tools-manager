@extends('base::layout.master')

@section('breadcrumb')

    @include('base::layout.partials.breadcrumb', ['title'=>'Tools', 'breadcrumbs'=>[
        ['url'=>'/user', 'label'=>'Bảng điều khiển'],
        ['label'=>'Tools'],
    ]])

@endsection

@section('content')

    @include('errors.errorlist')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="panel">
        <div class="panel-body rr-search">
            <form method="GET" action="{{ route('user-key.index') }}">
                <div class="col-sm-12 form-row"
                     style="border: 1px solid #cccccc; padding: 15px; margin-bottom: 20px; border-radius: 10px;">
                    <div class="form-group col-sm-3" style="padding: 0px">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control form-inline">
                            @forelse(config('constants.key_status') as $index => $st)
                                <option {{ isset($status) && $status == $st ? 'selected' : '' }} value="{{ $st }}">{{ $index }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <button style="margin-top: 24px" type="submit" class="btn btn-primary">Tìm kiếm</button>
                        <a href="{{ route('user-key.index') }}" style="margin-top: 24px" type="submit" class="btn btn-success">Reset</a>
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
                        <th> Serial number</th>
                        <th> Expire time</th>
                        <th> Expire date</th>
                        <th> Point order</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( isset($keys) && count($keys) )
                        @foreach($keys as $key)
                            <tr>
                                <td>{!! $key['tool']['name'] !!}</td>
                                <td>{!! $key['user']['name'] !!}</td>
                                <td>{!! $key['licence_key'] !!}</td>
                                <td>{!! $key['serial_number'] !!}</td>
                                <td>{!! $key['expire_time'] !!}</td>
                                <td>{!! $key['expire_date'] !!}</td>
                                <td>{!! $key['point_order'] !!}</td>
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

    {{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>
    {{--<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js" defer></script>--}}
    <script>
        $(document).ready(function () {
            var table = $('#key-datatable').DataTable({
                responsive: true
            });
        });
    </script>
@endsection