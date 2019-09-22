<?php

return [

    /*
     * menu navigation super admin
     */

    'super-admin' => [
        'Dashboard' => 'admin.dashboard',
        'Đại lý' => [
            'Danh sách đại lý' => 'admin.index',
            'Thêm mới đại lý' => 'admin.create',
        ],
        'Người dùng' => [
            'Danh sách người dùng' => 'users.index'
        ],
    ],

    /*
     * menu navigation system admin
     */

    'agency' => [
        'Dashboard' => 'admin.dashboard',
        'Người dùng' => [
            'Danh sách người dùng' => 'users.index',
            'Thêm mới người dùng' => 'users.create'
        ],
    ],

    /*
    * Icons for all
    */

    'Icons' => [
        'Dashboard' => '<i class="fa fa-home"></i>',
        'Tài khoản' => '<i class="fa fa-bar-chart"></i>',
        'Đại lý' => '<i class="fa fa-user-secret"></i>',
        'Người dùng' => '<i class="fa fa-users"></i>',
        'Super Admin Tool' => '<i class="fa fa-cogs"></i>',
        'Bố cục website' => '<i class="fa fa-cogs"></i>',
        'Pages' => '<i class="fa fa-cogs"></i>',
    ]
];
