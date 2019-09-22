<div class="c-layout-sidebar-menu c-theme ">
    <div class="row">
        <div class="col-md-12 col-sm-6 col-xs-6 m-t-15 m-b-20">
            <div class="c-content-title-3 c-title-md c-theme-border">
                <h3 class="c-left c-font-uppercase">Menu tài khoản</h3>
                <div class="c-line c-dot c-dot-left "></div>
            </div>
            @php( $routeName = Route::current()->getName() )
            <div class="c-content-ver-nav">
                <ul class="c-menu c-arrow-dot c-square c-theme">
                    <li><a href="{{ route('user.profile') }}"
                           class="{{ $routeName == 'user.profile' ? 'active' : '' }}">Thông tin tài khoản</a></li>
                    <li><a href="{{ route('change.password') }}"
                           class="{{ $routeName == 'change.password' ? 'active' : '' }}">Đổi mật khẩu</a></li>
                    {{--<li><a href="#" class="{{ $routeName == 'history' ? 'active' : '' }}">Lịch sử giao dịch</a></li>--}}
                </ul>
            </div>
        </div>

        <div class="col-md-12 col-sm-6 col-xs-6 m-t-15">
            <div class="c-content-title-3 c-title-md c-theme-border">
                <h3 class="c-left c-font-uppercase">Menu giao dịch</h3>
                <div class="c-line c-dot c-dot-left "></div>
            </div>
            <div class="c-content-ver-nav m-b-20">
                <ul class="c-menu c-arrow-dot c-square c-theme">
                    <li><a href="{{ route('charge.card') }}"
                           class="{{ $routeName == 'charge.card' ? 'active' : '' }}">Nạp thẻ tự động</a>
                    </li>
                    <li><a href="{{ route('charge.card.history') }}"
                           class="{{ $routeName == 'charge.card.history' ? 'active' : '' }}">Thẻ cào đã nạp</a>
                    </li>
                    <li><a href="{{ route('purchased.account') }}"
                           class="{{ $routeName == 'history' ? 'active' : '' }}">Tài khoản
                            đã mua</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
