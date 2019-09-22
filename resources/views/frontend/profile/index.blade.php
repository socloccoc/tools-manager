@extends('layout.FrontBase')

@section('base')
    <div class="c-layout-sidebar-content ">
        <div class="c-content-title-1">
            <h3 class="c-font-uppercase c-font-bold">Thông tin tài khoản</h3>
            <div class="c-line-left"></div>
        </div>
        <table class="table table-striped">
            <tbody>
            <tr>
                <th scope="row">ID của bạn:</th>
                <th><span class="c-font-uppercase">{{ isset($user->id) ? $user->id : '' }}</span></th>
            </tr>
            <tr>
                <th scope="row">Tên tài khoản:</th>
                <th>{{ isset($user->username) ? $user->username : '' }}</th>
            </tr>
            <tr>
                <th scope="row">Số dư tài khoản:</th>
                <td><b class="text-danger">{{ isset($user->amount) ? $user->amount : 0 }}đ</b></td>
            </tr>
            <tr>
                <th scope="row">Bảo mật ODP:</th>
                <td><a href="#"><b><i class="text-danger">Thêm số điện thoại</i></b></a></td>
            </tr>
            <tr>
                <th scope="row">Nhóm tài khoản:</th>
                <td>{{ isset($user->roles[0]) ? $user->roles[0] : '' }}</td>
            </tr>
            <tr>
                <th scope="row">Ngày tham gia:</th>
                <td>
                    {{ isset($user->created_at) ? $user->created_at : '' }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection