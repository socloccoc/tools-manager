<div class="br-sideleft overflow-y-auto">
    <div class="br-sideleft-menu">
        <ul class="side-menu">
            <li class="sm-sub sms-profile">
                <a class="clearfix" href="#">
                    <img class="img-circle img-md img-border"
                         src="{{ isset($user_picture) && !empty($user_picture) ? $user_picture : asset('images/default_avatar.png') }}"
                         alt="{{isset($users_name) && !empty($users_name) ? $users_name : '' }}"
                    />
                    <span class="f-11">
                    <span class="d-block">{{isset($users_name) && !empty($users_name) ? $users_name : '' }}</span>
                    <small class="">{{isset($user->roles[0]) && !empty($user->roles[0]) ? ucfirst($user->roles[0]) : '' }}</small>
                </span>
                </a>
                <ul>
                    <li><a href="#">View Profile</a></li>
                    <li><a href="{{ URL::route('logout') }}">Đăng xuất</a></li>
                </ul>
            </li>
            {!! App::make('App\Helpers\MenuItemHelper')->getMenu() !!}
        </ul>
    </div>
</div>