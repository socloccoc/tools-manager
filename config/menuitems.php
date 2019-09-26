<?php

return [

    /*
     * menu navigation super admin
     */
    'super-admin' => [
        'Dashboard'     => 'admin.index',
        'Cộng tác viên' => [
            'Danh sách cộng tác viên' => 'admin.index',
            'Thêm mới cộng tác viên'  => 'admin.create',
        ],
        'Tool'          => [
            'Danh sách tool' => 'tool.index',
            'Thêm mới tool'  => 'tool.create',
        ],
        'Key'           => [
            'Danh sách key' => 'key.index',
            'Thêm mới key'  => 'key.create',
        ],
    ],

    /*
     * menu navigation system admin
     */
    'agency'      => [
        'Dashboard'  => 'user.index',
        'Người dùng' => [
            'Danh sách người dùng' => 'user.index',
            'Thêm mới người dùng'  => 'user.create'
        ],
        'Key'           => [
            'Danh sách key' => 'key.index',
            'Thêm mới key'  => 'key.create',
        ],
    ],

    /*
    * Icons for all
    */
    'Icons'       => [
        'Dashboard'        => '<i class="fa fa-home"></i>',
        'Tài khoản'        => '<i class="fa fa-bar-chart"></i>',
        'Cộng tác viên'    => '<i class="fa fa-user-secret"></i>',
        'Người dùng'       => '<i class="fa fa-users"></i>',
        'Super Admin Tool' => '<i class="fa fa-cogs"></i>',
        'Tool'             => '<i class="fa fa-cogs"></i>',
        'Key'              => '<i class="fa fa-cogs"></i>',
        'Bố cục website'   => '<i class="fa fa-cogs"></i>',
        'Pages'            => '<i class="fa fa-cogs"></i>',
    ]
];
