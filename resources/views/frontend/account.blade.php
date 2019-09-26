@extends('layout.FrontMaster')

@section('content')
    @php($request = app('request')->request->all())
    @php($conditions = \App\Helpers\BasicHelper::conditionHandle($request))
    @php($accounts = \App\Helpers\Accounts::getAccountsByCategory($category['id'], $conditions))
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info" role="alert">
                    <h2 class="alert-heading">{{ $category['title'] }}</h2>
                    <p></p>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 15px">
            <div class="m-l-10 m-r-10">
                <form class="form-inline m-b-10" role="form" method="get">
                    <div class="col-md-3 col-sm-4 p-5 field-search">
                        <div class="input-group c-square">
                            <span class="input-group-addon">Tìm kiếm</span>
                            <input type="text" class="form-control c-square"
                                   value="{{ isset($request['account']) ? $request['account'] : '' }}"
                                   placeholder="Account" name="account">
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-4 p-5 field-search">
                        <div class="input-group c-square">
                            <span class="input-group-addon">Mã số</span>
                            <input type="text" class="form-control c-square"
                                   value="{{ isset($request['code']) ? $request['code'] : '' }}" placeholder="Mã số"
                                   name="code">
                        </div>
                    </div>
                    <input hidden value="{{ isset($accounts[0]['is_random']) ? $accounts[0]['is_random'] : ''  }}"
                           name="is_random">
                    @if((isset($accounts[0]['is_random']) && $accounts[0]['is_random'] == 0) || isset($request['is_random']) && $request['is_random'] == 0)
                        <div class="col-md-4">
                            <div class="input-group m-b-10 c-square">
                                <span class="input-group-addon" id="basic-addon1">Gía tiền</span>
                                <select name="price_range" class="form-control c-square c-theme">
                                    <option value="">Chọn giá tiền</option>
                                    @forelse(config('constants.PRICE_RANGE') as $index => $item)
                                        <option {{ isset($request['price_range']) && $request['price_range'] == $index ? 'selected' : ''}} value="{{ $index }}">{{ $item }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-4 col-xs-12  p-5 field-search">
                            <div class="input-group c-square">
                                <span class="input-group-addon">Đá quý</span>
                                <select name="gems" class="form-control c-square" title="-- Không chọn --">
                                    <option value="">-- Không chọn --</option>
                                    <option {{ isset($request['gems']) && $request['gems'] == 0 ? 'selected' : '' }} value="0">
                                        Không
                                    </option>
                                    <option {{ isset($request['gems']) && $request['gems'] == 1 ? 'selected' : '' }} value="1">
                                        Có
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-4 col-xs-12  p-5 field-search">
                            <div class="input-group c-square">
                                <span class="input-group-addon">Ngọc</span>
                                <select name="jewels" class="form-control c-square" title="-- Không chọn --">
                                    <option value="">-- Không chọn --</option>
                                    <option {{ isset($request['jewels']) && $request['jewels'] == 0 ? 'selected' : '' }} value="0">
                                        Không
                                    </option>
                                    <option {{ isset($request['jewels']) && $request['jewels'] == 1 ? 'selected' : '' }} value="1">
                                        Có
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-4 col-xs-12  p-5 field-search">
                            <div class="input-group c-square">
                                <span class="input-group-addon">Rank</span>
                                <select name="rank" class="form-control c-square" title="-- Không chọn --">
                                    <option value="">-- Không chọn --</option>
                                    @forelse($ranks as $index => $rank)
                                        <option {{ isset($request['rank']) && $request['rank'] == $index ? 'selected' : '' }} value="{{ $index }}">{{ $rank }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-4 col-xs-12  p-5 field-search">
                            <div class="input-group c-square">
                                <span class="input-group-addon">Trạng Thái</span>
                                <select name="status" class="form-control c-square" title="-- Không chọn --">
                                    <option value="">-- Không chọn --</option>
                                    @forelse($accountStatus as $index => $status)
                                        <option {{ isset($request['status']) && $request['status'] == $index ? 'selected' : '' }} value="{{ $index }}">{{ $status }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-3 col-sm-4 p-5 no-radius">
                        <button type="submit" class="btn c-square c-theme c-btn-green">Tìm kiếm</button>
                        <a class="btn c-square m-l-0 btn-danger" href="{{ Request::url() }}">Tất
                            cả</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row row-flex  item-list">

            @forelse($accounts as $account)
                <div class="col-sm-6 col-md-3">
                    <div class="classWithPad">
                        <div class="image">
                            <a href="{{ isset($account->url) && !empty($account->url) ? $account->url : '/'  }}">
                                <img src="{{ isset($account->thumb) && !empty($account->thumb) ? $account->thumb : ''  }}">
                                <span class="ms">MS: {{ isset($account->code) && !empty($account->code) ? $account->code : 0  }}</span>
                            </a>
                        </div>
                        <div class="description">
                            {{ isset($account->description) && !empty($account->description) ? $account->description : ''  }}
                        </div>
                        <div class="attribute_info">
                            <div class="row">
                                @if(isset($account->is_random) && $account->is_random == 0)
                                    <div class="col-xs-6 a_att">
                                        Tướng:
                                        <b>{{ isset($account->count_champs) && !empty($account->count_champs) ? $account->count_champs : 0  }}</b>
                                    </div>

                                    <div class="col-xs-6 a_att">
                                        Trang phục:
                                        <b>{{ isset($account->count_skins) && !empty($account->count_skins) ? $account->count_skins : 0  }}</b>
                                    </div>

                                    <div class="col-xs-6 a_att">
                                        Đá quý:
                                        <b>{{ isset($account->count_gems) && !empty($account->count_gems) ? $account->count_gems : 0  }}</b>
                                    </div>

                                    <div class="col-xs-6 a_att">
                                        Ngọc 90:
                                        <b>{{ isset($account->count_jewels) && !empty($account->count_jewels) ? $account->count_jewels : 0  }}</b>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="a-more">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="price_item">
                                        {{ isset($account->price_atm) && !empty($account->price_atm) ? number_format($account->price_atm) . ' đ' : 0  }}
                                    </div>
                                </div>
                                <div class="col-xs-6 ">
                                    <div class="view">
                                        <a href="{{ isset($account->url) && !empty($account->url) ? $account->url : '/'  }}">Chi
                                            tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h3 style="color: red; margin-left: 20px">Không tìm thấy account phù hợp với điều kiện của bạn !</h3>
            @endforelse
        </div>

        @include('partials.pagination',  ['paginator'=>$accounts])

        <div class="tab-vertical tutorial_area">
            <div class="panel-group" id="accordion">
            </div>
        </div>
    </div>

@endsection
