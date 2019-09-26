@extends('layout.FrontMaster')

@section('content')
    {{--@php(dd($account->category->title))--}}
    <div class="c-content-box c-size-lg c-overflow-hide c-bg-white">
        <div class="container">
            <div class="c-shop-product-details-4">
                <div class="row">
                    <div class="col-md-4 m-b-20">
                        <div class="c-product-header">
                            <div class="c-content-title-1">
                                <h3 class="c-font-uppercase c-font-bold">
                                    #{{ isset($account->code) ? $account->code : ''   }}</h3>
                                <span class="c-font-red c-font-bold">{{ isset($account->category->title) ? $account->category->title : ''   }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 visible-sm visible-xs visible-sm">
                        <div class="text-center m-t-20">

                            <img class="img-responsive img-thumbnail"
                                 src="{{ isset($account->thumb) ? $account->thumb : ''   }}">
                        </div>
                        <div class="c-product-meta">
                            <div class="c-content-divider">
                                <i class="icon-dot"></i>
                            </div>
                            <div class="row">

                                {{--@php(dd($account))--}}
                                <div class="col-sm-4 col-xs-6 c-product-variant">
                                    <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                        Tướng: <span
                                            class="c-font-red">{{ isset($account->count_champs) ? $account->count_champs : 0   }}</span>
                                    </p>
                                </div>


                                <div class="col-sm-4 col-xs-6 c-product-variant">
                                    <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                        Trang phục: <span
                                            class="c-font-red">{{ isset($account->count_skins) ? $account->count_skins : 0   }}</span>
                                    </p>
                                </div>


                                <div class="col-sm-4 col-xs-6 c-product-variant">
                                    <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">Đá
                                        quý: <span
                                            class="c-font-red">{{ isset($account->count_gems) ? $account->count_gems : 0   }}</span>
                                    </p>
                                </div>


                                <div class="col-sm-4 col-xs-6 c-product-variant">
                                    <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                        Ngọc <span
                                            class="c-font-red">{{ isset($account->count_jewels) ? $account->count_jewels : 0   }}</span>
                                    </p>
                                </div>


                                <div class="col-sm-4 col-xs-6 c-product-variant">
                                    <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                        Rank: <span class="c-font-red">{{ isset($account->rank->title) ? $account->rank->title : 0 }}</span></p>
                                </div>


                                <div class="col-sm-4 col-xs-6 c-product-variant">
                                    <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                        Trạng Thái: <span class="c-font-red">{{ isset($account->status->title) ? $account->status->title : 0 }}</span></p>
                                </div>


                                <div class="col-sm-12 col-xs-12 c-product-variant">
                                    <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                        Nổi bật:
                                        <span class="c-font-red">
                                            {{ isset($account->description) ? $account->description : ''   }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="c-content-divider">
                                <i class="icon-dot"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="c-product-meta">
                            <div class="c-product-price c-theme-font" style="float: none;text-align: center">

                                <div class="position0">
                                    {{ isset($account->price_atm) ? number_format($account->price_atm) : 0   }} ATM
                                </div>
                                <div class="position1">
                                    {{ isset($account->price_card) ? number_format($account->price_card) : 0   }} CARD
                                </div>
                            </div>
                            <div style="display: none">

                            </div>
                            <script type="text/javascript">
                                $(".c-product-price").append($(".position0"));
                                $(".c-product-price").append($(".position1"));
                            </script>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <div class="c-product-header">
                            <div class="c-content-title-1">
                                <button type="button"
                                        class="btn c-btn btn-lg c-theme-btn c-font-uppercase c-font-bold c-btn-square m-t-20 load-modal"
                                        rel="/buyacc/5309">Mua ngay
                                </button>
                                <a class="btn c-btn btn-lg c-bg-green-4 c-font-white c-font-uppercase c-font-bold c-btn-square m-t-20"
                                   href="/nap-the">Nạp thẻ cào</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-product-meta visible-md visible-lg">
                    <div class="c-content-divider">
                        <i class="icon-dot"></i>
                    </div>
                    @if(isset($account->is_random) && $account->is_random == 0)
                    <div class="row">
                        <div class="col-sm-4 col-xs-6 c-product-variant">
                            <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                Tướng: <span
                                    class="c-font-red">{{ isset($account->count_champs) ? $account->count_champs : 0   }}</span>
                            </p>
                        </div>

                        <div class="col-sm-4 col-xs-6 c-product-variant">
                            <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                Trang phục: <span
                                    class="c-font-red">{{ isset($account->count_skins) ? $account->count_skins : 0   }}</span>
                            </p>
                        </div>

                        <div class="col-sm-4 col-xs-6 c-product-variant">
                            <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">Đá
                                quý: <span
                                    class="c-font-red">{{ isset($account->count_gems) ? $account->count_gems : 0   }}</span>
                            </p>
                        </div>

                        <div class="col-sm-4 col-xs-6 c-product-variant">
                            <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                Ngọc <span
                                    class="c-font-red">{{ isset($account->count_jewels) ? $account->count_jewels : 0 }}</span>
                            </p>
                        </div>

                        <div class="col-sm-4 col-xs-6 c-product-variant">
                            <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                Rank: <span class="c-font-red">{{ isset($account->rank->title) ? $account->rank->title : 0 }}</span>
                            </p>
                        </div>

                        <div class="col-sm-4 col-xs-6 c-product-variant">
                            <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                Trạng Thái: <span class="c-font-red">{{ isset($account->status->title) ? $account->status->title : ''}}</span>
                            </p>
                        </div>

                        <div class="col-sm-12 col-xs-12 c-product-variant">
                            <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                                Nổi bật:
                                <span class="c-font-red">
                                    {{ isset($account->description) ? $account->description : ''   }}
                                </span>
                            </p>
                        </div>
                    </div>
                    @endif
                    <div class="c-content-divider">
                        <i class="icon-dot"></i>
                    </div>

                </div>
            </div>
        </div>


        <div class="container m-t-20 content_post">

            {!! isset($content) && !empty($content) ? $content : '' !!}

            <div class="buy-footer" style="text-align: center">
                <button type="button"
                        class="btn c-btn btn-lg c-theme-btn c-font-uppercase c-font-bold c-btn-square m-t-20 load-modal"
                        rel="/buyacc/5309">Mua ngay
                </button>
            </div>
        </div>

        <div class="container m-t-20 ">

            <div class="game-item-view" style="margin-top: 40px">
                <div class="c-content-title-1">
                    <h3 class="c-center c-font-uppercase c-font-bold">Tài khoản liên quan</h3>
                    <div class="c-line-center c-theme-bg"></div>
                </div>
                @php($accounts_relate = \App\Helpers\Accounts::getAccountsRelated($account))

                    <div class="row row-flex  item-list">
                        @forelse($accounts_relate as $item)
                            {{--@php(dd($item))--}}
                            <div class="col-sm-6 col-md-3">
                                <div class="classWithPad">
                                    <div class="image">
                                        <a href="{{$item['url']}}">
                                            <img src="{{$item['thumb']}}">
                                            <span class="ms">MS: {{$item['code']}}</span>
                                        </a>
                                    </div>
                                    <div class="description">
                                        {{$item['description']}}
                                    </div>
                                    <div class="attribute_info">
                                        <div class="row">
                                            <div class="col-xs-6 a_att">
                                                Tướng: <b>{{$item['count_champs']}}</b>
                                            </div>

                                            <div class="col-xs-6 a_att">
                                                Trang phục: <b>{{$item['count_skins']}}</b>
                                            </div>

                                            <div class="col-xs-6 a_att">
                                                Đá quý: <b>{{$item['count_gems']}}</b>
                                            </div>

                                            <div class="col-xs-6 a_att">
                                                Ngọc 90: <b>{{$item['count_jewels']}}</b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="a-more">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="price_item">
                                                    {{ $item['price_atm'] ? number_format($item['price_atm']) : 0   }} đ
                                                </div>
                                            </div>
                                            <div class="col-xs-6 ">
                                                <div class="view">
                                                    <a href="{{$item['url']}}">Chi tiết</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
            </div>
            <div class="tab-vertical tutorial_area">
                <div class="panel-group" id="accordion">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="LoadModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('buyacc') }}" accept-charset="UTF-8"
                      class="form-horizontal" enctype="multipart/form-data">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <input name="account_code" type="hidden" value="{{ isset($account->code) ? $account->code : '' }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">Xác nhận mua tài khoản</h4>
                    </div>

                    <div class="modal-body">
                        <div class="c-content-tab-4 c-opt-3" role="tabpanel">
                            <ul class="nav nav-justified" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#payment" role="tab" data-toggle="tab" class="c-font-16" aria-expanded="true">Thanh toán</a>
                                </li>
                                <li role="presentation">
                                    <a href="#info" role="tab" data-toggle="tab" class="c-font-16" aria-expanded="false">Tài khoản</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="payment">
                                    <ul class="c-tab-items p-t-0 p-b-0 p-l-5 p-r-5">
                                        <li class="c-font-dark">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th colspan="2">Thông tin tài khoản #{{ isset($account->code) ? $account->code : ''}}</th>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                <tr>
                                                    <td>Nhà phát hành:</td>
                                                    <th>Garena</th>
                                                </tr>
                                                <tr>
                                                    <td>Tên game:</td>
                                                    <th>{{ isset($account->category->title) ? $account->category->title : '' }}</th>
                                                </tr>
                                                <tr>
                                                    <td>Giá tiền:</td>
                                                    <th class="text-info">{{ isset($account->price_atm) ? number_format($account->price_atm) : 0}}đ</th>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </li>
                                    </ul>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="info">
                                    <ul class="c-tab-items p-t-0 p-b-0 p-l-5 p-r-5">
                                        <li class="c-font-dark">
                                            <table class="table table-striped">
                                                @if(isset($account->is_random) && $account->is_random == 0)
                                                <tbody>
                                                    <tr>
                                                        <th colspan="2">Chi tiết tài khoản #{{ isset($account->code) ? $account->code : ''}}</th>
                                                    </tr>

                                                    <tr>
                                                        <td style="width: 50%">Tướng:</td>
                                                        <td class="text-danger" style="font-weight: 700">{{ isset($account->count_champs) ? $account->count_champs : ''}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td style="width: 50%">Trang phục:</td>
                                                        <td class="text-danger" style="font-weight: 700">{{ isset($account->count_jewels) ? $account->count_jewels : ''}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td style="width:50%">Đá quý:</td>
                                                        <td class="text-danger" style="font-weight: 700">{{ isset($account->count_gems) ? $account->count_gems : 0}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td style="width:50%">Rank:</td>
                                                        <td class="text-danger" style="font-weight: 700">{{ isset($account->rank->title) ? $account->rank->title : ''}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td style="width:50%">Trạng Thái:</td>
                                                        <td class="text-danger" style="font-weight: 700">{{ isset($account->status->title) ? $account->status->title : ''}}</td>
                                                    </tr>
                                                </tbody>
                                                @endif
                                            </table>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            @if(!Sentinel::getUser())
                                <label class="col-md-12 form-control-label text-danger"
                                       style="text-align: center;margin: 10px 0; ">
                                    Bạn phải đăng nhập mới có thể mua tài khoản tự động.
                                </label>
                            @elseif(Sentinel::getUser()->amount < $account['price_atm'])
                                <label class="col-md-12 form-control-label text-danger"
                                       style="text-align: center;margin: 10px 0; ">
                                    Bạn không đủ số dư để mua tài khoản này. Bạn hãy click vào nút nạp thẻ để nạp thêm
                                    và mua tài khoản.
                                </label>
                            @endif
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div class="modal-footer">
                        @if(!Sentinel::getUser())
                            <a class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold" href="/login">Đăng nhập</a>
                        @elseif(Sentinel::getUser()->amount < $account['price_atm'])
                            <a class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold" href="/nap-the" id="d3">Nạp thẻ cào</a>
                        @else
                            <button type="submit" class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold">Xác nhận</button>
                        @endif
                        <button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
                    </div>
                </form>

                <script>
                    $(document).ready(function () {
                        $('.load-modal').each(function (index, elem) {
                            $(elem).unbind().click(function (e) {
                                e.preventDefault();
                                var curModal = $('#LoadModal');
                                curModal.modal('show').find('.modal-content').load($(elem).attr('rel'));
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>

@endsection
