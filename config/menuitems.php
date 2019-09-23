<?php

return [

    /*
     * menu navigation super admin
     */

    'super-admin' => [
        'Dashboard' => 'admin.dashboard',
        'Đại lý'    => [
            'Danh sách đại lý' => 'admin.index',
            'Thêm mới đại lý'  => 'admin.create',
        ],
        'Tool'      => [
            'Danh sách tool' => 'tool.index',
            'Thêm mới tool'  => 'tool.create',
        ],
    ],

    /*
     * menu navigation system admin
     */

    'agency' => [
        'Dashboard'  => 'admin.dashboard',
        'Người dùng' => [
            'Danh sách người dùng' => 'user.index',
            'Thêm mới người dùng'  => 'user.create'
        ],
    ],

    /*
    * Icons for all
    */

    'Icons' => [
        'Dashboard'        => '<i class="fa fa-home"></i>',
        'Tài khoản'        => '<i class="fa fa-bar-chart"></i>',
        'Đại lý'           => '<i class="fa fa-user-secret"></i>',
        'Người dùng'       => '<i class="fa fa-users"></i>',
        'Super Admin Tool' => '<i class="fa fa-cogs"></i>',
        'Tool'             => '<i class="fa fa-cogs"></i>',
        'Bố cục website'   => '<i class="fa fa-cogs"></i>',
        'Pages'            => '<i class="fa fa-cogs"></i>',
    ]
];
