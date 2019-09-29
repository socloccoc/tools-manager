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
        'Người dùng'    => [
            'Danh sách người dùng' => 'user.index',
            'Thêm mới người dùng'  => 'user.create',
        ],
        'Analytics'     => [
            'Thống kê' => 'analytics.index'
        ],
        'Tool'          => [
            'Danh sách tool' => 'tool.index',
            'Thêm mới tool'  => 'tool.create',
        ],
        'Key'           => [
            'Danh sách key' => 'key.index',
            'Thêm mới key'  => 'key.create',
        ],
        'Affiliate'     => [
            'Danh sách Link' => 'affiliate.index',
            'Thêm mới Link'  => 'affiliate.create',
        ],
        'Order'         => [
            'Danh sách order' => 'order.list',
        ]
    ],

    /*
     * menu navigation agency
     */
    'agency'      => [
        'Dashboard'  => 'user.index',
        'Người dùng' => [
            'Danh sách người dùng' => 'user.index',
            'Thêm mới người dùng'  => 'user.create'
        ],
        'Key'        => [
            'Danh sách key' => 'key.index',
            'Thêm mới key'  => 'key.create',
        ],
    ],

    /*
     * menu navigation user
     */
    'user'        => [
        'Dashboard' => 'user-key.index',
        'Key'       => [
            'Danh sách key' => 'user-key.index'
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
        'Analytics'        => '<i class="fa fa-cogs"></i>',
        'Affiliate'        => '<i class="fa fa-cogs"></i>',
        'Order'            => '<i class="fa fa-cogs"></i>',
        'Bố cục website'   => '<i class="fa fa-cogs"></i>',
        'Pages'            => '<i class="fa fa-cogs"></i>',
    ]
];
