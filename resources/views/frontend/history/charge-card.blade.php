@extends('layout.FrontBase')

@section('base')
    <div class="c-layout-sidebar-content ">
        <div class="c-content-title-1">
            <h3 class="c-font-uppercase c-font-bold">Thẻ cào đã nạp</h3>
            <div class="c-line-left"></div>
        </div>
        <form class="form-horizontal form-find m-b-20" role="form" method="get">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group m-b-10 c-square ">
                        <span class="input-group-addon" id="basic-addon1">Thẻ cào</span>
                        <input type="text" class="form-control c-square c-theme" name="find" value="{{ isset($inputData['find']) ? $inputData['find'] : ''}}" autofocus=""
                               placeholder="Mã thẻ,serial ...">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group m-b-10 c-square">
                        <span class="input-group-addon" id="basic-addon1">Loại thẻ</span>
                        <select class="form-control c-square c-theme">.
                            <option selected="selected"> Tất cả loại thẻ</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group m-b-10 c-square">
                        <span class="input-group-addon" id="basic-addon1">Kiểu nạp </span>
                        <select id="type_charge" class="form-control c-square c-theme">
                            <option value="1" selected="selected">
                                Nạp tự động
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="input-group m-b-10 c-square">
                        <span class="input-group-addon" id="basic-addon1">Trạng thái</span>
                        <select class="form-control  c-square c-theme" name="status" id="vsvsd">
                            <option class="stt_all" value=""> Tất cả</option>
                            @forelse(config('chargecard.STATUS') as $index => $status)
                            <option {{ isset($inputData['status']) && $inputData['status'] == $index ? 'selected' : ''}} class="stt_1" value="{{ $index }}">
                                {{ $status }}
                            </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group m-b-10 c-square">
                        <div class="input-group date date-picker" data-date-format="yyyy-mm-dd" data-rtl="false">
                                    <span class="input-group-btn">
                                    <button class="btn default c-btn-square p-l-10 p-r-10" type="button"><i
                                                class="fa fa-calendar"></i></button>
                                    </span>
                            <input type="text" class="form-control c-square c-theme" name="start_date"
                                   autocomplete="off" autofocus="" placeholder="Từ ngày" value="{{ isset($inputData['start_date']) ? $inputData['start_date'] : ''}}">
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
                            <input type="text" class="form-control c-square c-theme" name="end_date"
                                   autocomplete="off"
                                   placeholder="Đến ngày" value="{{ isset($inputData['end_date']) ? $inputData['end_date'] : ''}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <button type="submit" class="btn c-theme-btn c-btn-square m-b-10" style="margin-left: 0px"><i
                                class="glyphicon glyphicon-search"></i> Tìm kiếm
                    </button>
                    <a class="btn c-btn-square m-b-10 btn-danger" style="margin-left: 0px"
                       href="{{ route('charge.card.history') }}"><i class="glyphicon glyphicon-calendar"></i> Tất
                        cả</a>
                </div>
            </div>
        </form>

        <table class="table table-hover table-custom-res">
            <thead>
            <tr role="row">
                <th>Thời gian</th>
                <th>Kiểu nạp</th>
                <th>Nhà mạng</th>
                <th>Mã thẻ</th>
                <th>Serial</th>
                <th>Mệnh giá</th>
                <th>Kết quả</th>
                <th>Thực nhận</th>
            </tr>
            </thead>
            <tbody>
            @forelse($chargeCardHistory as $item)
                <tr>
                    <td>{{ isset($item['charge_time']) ? $item['charge_time'] : '' }}</td>
                    <td>Nạp tự động</td>
                    <td>{{ isset($item['card_type']) ? $item['card_type'] : '' }}</td>
                    <td>{{ isset($item['pin']) ? $item['pin'] : '' }}</td>
                    <td>{{ isset($item['serial']) ? $item['serial'] : '' }}</td>
                    <td>{{ isset($item['amount1']) ? $item['amount1'] : '' }}</td>
                    <td>{{ isset($item['status']) ? config('chargecard.STATUS')[$item['status']] : '' }}</td>
                    <td>{{ isset($item['amount1']) ? $item['amount1'] : '' }}</td>
                    <td></td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
