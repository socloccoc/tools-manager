@extends('layout.FrontBase')

@section('base')

    <div class="c-layout-sidebar-content ">
        <div class="c-content-title-1">
            <h3 class="c-font-uppercase c-font-bold">Nạp thẻ</h3>
            <div class="c-line-left"></div>
        </div>
        @include('errors.errorlist')
        {!! Form::open( array('route' => array('charge.card.complete'), 'role' => 'form', 'method' => 'POST', 'class' => 'form-horizontal form-charge', 'novalidate' => 'novalidate')) !!}
            <div class="form-group">
                <label class="col-md-3 control-label">Tài khoản:</label>
                <div class="col-md-6">
                    {!! Form::text('username', isset($currentUser->username) ? $currentUser->username : $currentUser->email, ['placeholder'=>'Người dùng...','class' => 'form-control', 'readonly']) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Loại thẻ:</label>
                <div class="col-md-6">
                    {!! Form::select('telco',[ '' => '-- Chọn loại thẻ --'] + $card_type , old('card_type') ? old('card_type') : '', ['class'=>'form-control c-square c-theme', 'required' => 'required'])!!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Mệnh giá:</label>
                <div class="col-md-6">
                    {!! Form::select('amount',[ '' => '-- Chọn mệnh giá --'] + $amounts , old('amount') ? old('amount') : '', ['class'=>'form-control c-square c-theme', 'required' => 'required'])!!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Mã số thẻ:</label>
                <div class="col-md-6">
                    {!! Form::number('pin', old('pin') ? old('pin') : '', ['class' => 'form-control c-square c-theme', 'required' => 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Số serial:</label>
                <div class="col-md-6">
                    {!! Form::number('serial', old('serial') ? old('serial') : '', ['class' => 'form-control c-square c-theme', 'required' => 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Mã bảo vệ</label>
                <div class="col-md-6">
                    <div class="col-md-6" style="padding: 0px;">
                        @captcha
                    </div>
                    <div class="col-sm-6" style="padding: 0px;">
                        {!! Form::text('captcha', old('captcha') ? old('captcha') : '', ['class' => 'form-control', 'id' => 'captcha']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group c-margin-t-40">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit"
                            class="btn btn-submit c-theme-btn c-btn-square c-btn-uppercase c-btn-bold btn-block"
                            data-loading-text="<i class='fa fa-spinner fa-spin '></i>">Nạp
                        thẻ
                    </button>
                </div>
            </div>
        {!! Form::close() !!}

        <div class="alert alert-info">
            <p>Tỷ lệ nạp 1: 1. Ưu tiên nạp thẻ viettel và thẻ game nha ae</p>
            <p><span style="color:#e74c3c"><strong>LƯU Ý : Chọn Đúng Mệnh Giá Thẻ . Chọn Sai Mã Thẻ&nbsp;Bị Trừ 100% Không Được Hoàn Tiền.</strong></span>
            </p>
            <p>&nbsp;</p>
        </div>
        <!-- END: PAGE CONTENT -->

        {{--<table class="table table-hover table-custom-res">--}}
            {{--<thead>--}}
            {{--<tr>--}}
                {{--<th>Thời gian</th>--}}
                {{--<th>Kiểu nạp</th>--}}
                {{--<th>Nhà mạng</th>--}}
                {{--<th>Mã thẻ/Serial</th>--}}
                {{--<th>Mệnh giá</th>--}}
                {{--<th>Kết quả</th>--}}
                {{--<th>Thực nhận</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--<tr>--}}
                {{--<td colspan="7">Không có dữ liệu</td>--}}
            {{--</tr>--}}
            {{--</tbody>--}}
        {{--</table>--}}

    </div>
    <script>
        $(window).load(function () {
            var bs = new base({
                forms: [{
                    validate: true,
                    $obj: $('form')
                }]
            });
        });
    </script>
@endsection