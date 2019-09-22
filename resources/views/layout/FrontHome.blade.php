@extends('layout.FrontMaster')

@section('content')

    @include('layout.partials.FrontSlider')

    <div class="c-content-box c-size-md c-bg-white">
        <div class="container">


        @php($account_widgets = \App\Helpers\Widgets::getAccountWidget())
            <!-- Begin: Testimonals 1 component -->
            <div class="c-content-client-logos-slider-1  c-bordered" data-slider="owl">
                <!-- Begin: Title 1 component -->
                <div class="c-content-title-1">
                    <h3 class="c-center c-font-uppercase c-font-bold">Danh mục game</h3>
                    <div class="c-line-center c-theme-bg"></div>
                </div>
                <div class="row row-flex-safari game-list">
                    @foreach($account_widgets as $account_widget)
                        @php($account_category = Categories::findCategoryById($account_widget['config']['cat_id']))
                        @if($account_category)
                            <div class="col-sm-3 col-xs-6 p-5">
                                <div class="classWithPad">
                                    <div class="news_image">
                                        <a href="{{$account_category['url']}}" class="">
                                            <img src="{{ isset($account_category['thumb']) && !empty($account_category['thumb']) ? $account_category['thumb'] : 'https://shopmobaviet.vn/upload-usr/images/e331JcMRds_1562179324.jpg'  }}">
                                        </a>
                                    </div>
                                    <div class="news_title">
                                        <a href="{{$account_category['url']}}">
                                            {{$account_category['title']}}
                                        </a>
                                    </div>
                                    <div class="news_description">
                                        <p>
                                            Số tài khoản: {{ \App\Helpers\Accounts::countAccountByCategory($account_widget['config']['cat_id'])  }}
                                        </p>
                                        <p>
                                            Đã bán: {{ \App\Helpers\Accounts::countAccountSaleByCategory($account_widget['config']['cat_id'])  }}
                                        </p>
                                    </div>
                                    <div class="a-more">
                                        <div class="row">

                                            <div class="col-xs-12">
                                                <div class="view">
                                                    <a href="{{$account_category['url']}}">Xem tất cả</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!-- End-->
            </div>
            <!-- End-->
        </div>
    </div>


    @include('layout.partials.FrontPartner')

@endsection
