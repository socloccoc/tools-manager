@extends('layout.FrontBase')

@section('base')
    <div class="c-layout-sidebar-content ">
        <div class="c-content-title-1">
            <h3 class="c-font-uppercase c-font-bold">Tài khoản đã mua</h3>
            <div class="c-line-left"></div>
        </div>
        <form class="form-horizontal form-find m-b-20" role="form" method="get">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group m-b-10 c-square ">
                        <span class="input-group-addon" id="basic-addon1">Mã tài khoản #</span>
                        <input type="text" class="form-control c-square c-theme" name="code"
                               value="{{ isset($inputData['code']) ? $inputData['code'] : ''}}" autofocus=""
                               placeholder="Mã tài khoản">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group m-b-10 c-square">
                        <span class="input-group-addon" id="basic-addon1">Game</span>

                        <select id="category_id" name="category_id" class="form-control c-square c-theme">
                            <option value="">-- Tất cả danh mục --</option>
                            @forelse($categories as $cat)
                                <option {{ isset($inputData['category_id']) && $inputData['category_id'] == $cat['id'] ? 'selected' : ''}} value="{{ isset($cat['id']) ? $cat['id'] : '' }}"> {{ isset($cat['title']) ? $cat['title'] : '' }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group m-b-10 c-square">
                        <span class="input-group-addon" id="basic-addon1">Số tiền</span>
                        <select name="price_range" class="form-control c-square c-theme">
                            <option value="">Chọn giá tiền</option>
                            @forelse(config('constants.PRICE_RANGE') as $index => $item)
                                <option {{ isset($inputData['price_range']) && $inputData['price_range'] == $index ? 'selected' : ''}} value="{{ $index }}">{{ $item }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="input-group m-b-10 c-square">
                        <div class="input-group date date-picker" data-date-format="yyyy-mm-dd" data-rtl="false">
                                    <span class="input-group-btn">
                                    <button class="btn default c-btn-square p-l-10 p-r-10" type="button"><i
                                                class="fa fa-calendar"></i></button>
                                    </span>
                            <input type="text" class="form-control c-square c-theme" name="start_date"
                                   autocomplete="off" autofocus="" placeholder="Từ ngày"
                                   value="{{ isset($inputData['start_date']) ? $inputData['start_date'] : ''}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group m-b-10 c-square">
                        <div class="input-group date date-picker" data-date-format="yyyy-mm-dd" data-rtl="false">
                                    <span class="input-group-btn">
                                    <button class="btn default c-btn-square p-l-10 p-r-10" type="button"><i
                                                class="fa fa-calendar"></i></button>
                                    </span>
                            <input type="text" class="form-control c-square c-theme" name="end_date" autocomplete="off"
                                   placeholder="Đến ngày"
                                   value="{{ isset($inputData['end_date']) ? $inputData['end_date'] : ''}}">
                        </div>
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <input type="submit" class="btn c-theme-btn c-btn-square m-b-10" value="Tìm kiếm">
                    <a class="btn c-btn-square m-b-10 btn-danger" href="{{ route('purchased.account') }}">Tất cả</a>
                </div>
            </div>
        </form>
        @include('errors.errorlist')
        <table class="table table-hover table-custom-res">
            <thead>
            <tr>
                <th>Thời gian</th>
                <th>Danh mục</th>
                <th>Tài khoản</th>
                <th>Trị giá</th>
            </tr>
            </thead>
            <tbody>
            @forelse($accounts as $acc)
                <tr>
                    <td>{{ isset($acc['date']) ? $acc['date'] : '' }}</td>
                    <td>{{ isset($acc['category']['title']) ? $acc['category']['title'] : '' }}</td>
                    <td class="load-modal account"><a>{{ isset($acc['account']) ? $acc['account'] : '' }}</a></td>
                    <td>{{ isset($acc['price']) ? $acc['price'] : '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Không có dữ liệu</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="LoadModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Thông tin tài khoản <span class="purchased-code" style="color: red"></span></h4>
                </div>

                <div class="modal-body">
                    <table style="margin-bottom: 0px; border: none" class="table borderless">
                        <tbody>
                        <tr>
                            <td>Tài khoản:</td>
                            <th class="purchased-account"></th>
                        </tr>
                        <tr>
                            <td>Mật khẩu:</td>
                            <th class="purchased-password"></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase"
                            data-dismiss="modal">Đóng
                    </button>
                </div>

                <script>
                    $(document).ready(function () {
                        $('.load-modal').each(function (index, elem) {
                            $(elem).unbind().click(function (e) {
                                e.preventDefault();
                                var curModal = $('#LoadModal');
                                // ajax
                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                var account = $(this).text();
                                $.ajax({
                                    url: '/ajax/getAccountInfo',
                                    type: 'POST',
                                    data: {_token: CSRF_TOKEN, account: account},
                                    dataType: 'JSON',
                                    success: function (data) {
                                        if (data !== null) {
                                            $('.purchased-code').text(data.code);
                                            $('.purchased-account').text(data.account);
                                            $('.purchased-password').text(data.password);
                                        } else {
                                            $('.purchased-code').text('Account not found !');
                                            $('.purchased-account').text('');
                                            $('.purchased-password').text();
                                        }
                                    }
                                });
                                curModal.modal('show').find('.modal-content').load($(elem).attr('rel'));
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    <style>
        .borderless td, .borderless th {
            border: none !important;
        }

        .account {
            cursor: pointer;
        }
    </style>
@endsection
