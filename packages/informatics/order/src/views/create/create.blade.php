@extends('base::layout.master')

@section('breadcrumb')

    @include('base::layout.partials.breadcrumb', ['title'=>'Thêm mới đơn hàng', 'breadcrumbs'=>[
        ['url'=>'/manager', 'label'=>'Bảng điều khiển'],
        ['label'=>'Thêm mới đơn hàng'],
    ]])

@endsection
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
@section('content')

    @include('errors.errorlist')

    <div class="row">
        <div class="col-xs-12">
            <div class="tab-base">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Thông tin chi tiết</a></li>
                </ul>
                <div class="tab-content">
                    <form class="form-horizontal" method="POST" action="{{ route('order.store') }}" novalidate
                          autocomplete="off">
                        <div class="parent-border col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary count btn-circle btn-lg">1</button>
                                </div>
                                <div class="col-sm-offset-11">
                                    <button type="button" id="deleteRow" class="btn btn-danger btn-circle btn-lg"><i
                                                class="fa fa-trash"></i></button>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label" for="full_name">Họ và tên:</label>
                                <input type="text" class="form-control" maxlength="191" name="full_name[]"
                                       placeholder="Họ và tên">
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="phone">SĐT:</label>
                                <input type="tel" class="form-control" maxlength="20" name="phone[]"
                                       placeholder="0987654321">
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="province">Tỉnh :</label>
                                <select class="form-control province" name="province[]" required>
                                    <option value="">--- Tỉnh, thành phố ---</option>
                                    @forelse($province as $item)
                                        <option value="{{ $item['province'] }}">{{ $item['province'] }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="district">Huyện :</label>
                                <select class="form-control district" name="district[]" required>
                                    <option value="">--- Huyện ---</option>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="village">Xã :</label>
                                <select class="form-control village" name="village[]">
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="street">Đường:</label>
                                <input required maxlength="191" type="text" class="form-control" name="street[]">
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="store_name">Tên store:</label>
                                <input required maxlength="191" type="text" class="form-control" name="store_name[]">
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="product_name">Tên sản phẩm:</label>
                                <input required maxlength="191" type="text" class="form-control" name="product_name[]">
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="product_link">Đơn hàng/link sp:</label>
                                <input maxlength="191" type="text" class="form-control" name="product_link[]">
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="quantity">Số lượng:</label>
                                <input required type="number" class="form-control" name="quantity[]">
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="option_1">Lựa chọn 1:</label>
                                <input maxlength="191" type="text" class="form-control" name="option_1[]">
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="option_2">Lựa chọn 2:</label>
                                <input maxlength="191" type="text" class="form-control" name="option_2[]">
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="promo_code">Promo code:</label>
                                <input maxlength="191" type="text" class="form-control" name="promo_code[]">
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label" for="transport">Vận chuyển:</label>
                                <input maxlength="191" required type="text" class="form-control" name="transport[]">
                            </div>
                        </div>
                        <div id="append-container">
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button type="button" id="addRow" class="btn btn-success btn-circle btn-lg"><i
                                            class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="navbar navbar-inverse navbar-fixed-bottom">
                            <div class="navbar-footer pull-right">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <button onclick="confirm('Bạn chắc chắn muốn lưu và xuất file không ?');"
                                                type="submit" class="btn btn-lg btn-success">Save
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->

@endsection

<script>
    $(window).load(function () {
        var bs = new base({
            forms: [{
                validate: true,
                $obj: $('form')
            }]
        });
    });
    $(document).ready(function () {
        initAddress('.parent-border');

        function initAddress(parentClass) {
            $('.province').each(function () {
                $(this).on('change', function () {
                    var province = $(this).val();
                    var province_elm = $(this);
                    $.ajax({
                        url: '/order/ajax/getDistrictByProvince',
                        type: 'GET',
                        data: {province: province},
                        dataType: 'JSON',
                        success: function (data) {
                            province_elm.parents(parentClass).find('.district, .village').find('option').not(':first').remove();
                            $.each(data, function (i, item) {
                                province_elm.parents(parentClass).find('.district').append($('<option>', {
                                    value: item.district,
                                    text: item.district
                                }));
                            });
                            province_elm.parents(parentClass).find('.district').each(function () {
                                $(this).on('change', function () {
                                    var district = $(this).val();
                                    var district_eml = $(this);
                                    $.ajax({
                                        url: '/order/ajax/getVillageByDistrict',
                                        type: 'GET',
                                        data: {district: district, province: province},
                                        dataType: 'JSON',
                                        success: function (data) {
                                            district_eml.parents(parentClass).find('.village').find('option').remove();
                                            $.each(data, function (i, item) {
                                                district_eml.parents(parentClass).find('.village').append($('<option>', {
                                                    value: item.village,
                                                    text: item.village
                                                }));
                                            });
                                        }
                                    });
                                });
                            });
                        }
                    });
                });
            });
        }

        $('#deleteRow').hide();
        // $('.count').parents().show();
        $('#addRow').on('click', function (e) {
            var len = $('.child-border').length;
            $('.parent-border').clone().find(':input').each(function (idx, ele) {
                ele.value = '';
            }).end().find('#deleteRow').show().end().find('.form-group').toggle(true).end()
                .toggleClass('parent-border child-border').hide()
                .appendTo('#append-container').slideDown('slow');
            $('.child-border').each(function (idx, ele) {
                $(this).find('.count').html(idx + 2).css('margin-left', '10px');
            });
            initAddress('.child-border');
        });

        $('#append-container').on('click', '[id^=deleteRow]', function (e) {
            $(this).closest('.child-border, .parent-border')
                .find(':input:not(button)').get()
                .reduce(function (acc, ele) {
                    acc[ele.name || ele.id] = ele.value;
                    return acc;
                }, {});
            $(this).closest('.child-border, .parent-border').remove();
            $('.child-border').each(function (idx, ele) {
                $(this).find('.count').html(idx + 2).css('margin-left', '10px');
            });
        });

    });
</script>
<style>
    .navbar-nav li {
        margin-top: 8px;
        margin-bottom: 8px;
    }

    .parent-border, .child-border {
        border: 1px solid #CCC;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .btn-circle.btn-lg {
        width: 50px;
        height: 50px;
        padding: 10px 16px;
        font-size: 18px;
        line-height: 1.33;
        border-radius: 25px;
    }
</style>