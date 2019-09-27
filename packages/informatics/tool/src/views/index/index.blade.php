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
        <input name="_token" type="hidden" value="{!! csrf_token() !!}"/>

        <div class='panel-body'>
            <div class="table-responsive">
                <table class="table table-bordered" id="toolDataTable">
                    <thead>
                    <tr>
                        @if(Permission::isSuperAdmin())
                            <th></th>
                        @endif
                        <th>Name</th>
                        <th>Max Point</th>
                        <th>Fee</th>
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
                                <td>{!! $tool->max_point !!}</td>
                                <td>{!! $tool->fee !!}</td>
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
        </div>
    </div>

@endsection
@section('javascript')
    @parent

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>
    <script>
        $(document).ready(function () {
            var table = $('#toolDataTable').DataTable({
                responsive: true
            });
        });
    </script>
@endsection