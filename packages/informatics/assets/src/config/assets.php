<?php

return [

    'javascript' => [
        'jquery',
        'popper',
        'bootstrap',
        'perfect-scrollbar',
        'moment',
        'jquery-ui',
        'jquery-switchbutton',
        'peity',
        'bracket',
        'string-vn',
        'sweet-alert',
        'noty',
        'notifi',
        'custom',
        'base'
    ],

    'stylesheets' => [
        'font-awesome',
        'bootstrap',
        'ionicons',
        'perfect-scrollbar',
        'jquery-switchbutton',
        'bracket',
        'nifty',
        'sweet-alert',
        'noty',
        'theme-dust',
        'custom',
    ],

    'resources' => [

        'javascript' => [

            'jquery' => [
                'use_cdn' => false,
                'fallback' => 'jQuery',
                'location' => 'top',
                'src' => [
                    'local' => '/backend/lib/jquery/jquery.js',
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js',
                ],
            ],
            'bootstrap' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/lib/bootstrap/bootstrap.js',
                    'cdn' => '//maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js',
                ],
            ],
            'popper' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/lib/popper.js/popper.js',
                ],
            ],
            'perfect-scrollbar' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js',
                ],
            ],
            'moment' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/lib/moment/moment.js',
                ],
            ],
            'jquery-ui' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/lib/jquery-ui/jquery-ui.js',
                ],
            ],
            'jquery-switchbutton' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/lib/jquery-switchbutton/jquery.switchButton.js',
                ],
            ],
            'peity' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/lib/peity/jquery.peity.js',
                ],
            ],
            'bracket' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/js/bracket.js',
                ],
            ],
            'jquery-nestable' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/lib/jquery/jquery.nestable.js',
                ],
            ],
            'ck-editor' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/lib/ckeditor/ckeditor.js',
                ],
            ],
            'ck-finder' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/js/ckfinder/ckfinder.js',
                ],
            ],
            'sweet-alert' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/lib/sweetalert/sweetalert.min.js',
                ],
            ],
            'noty' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/lib/noty/lib/noty.min.js',
                ],
            ],
            'notifi' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/js/notifi.js',
                ],
            ],
            'string-vn' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/js/stringvn.js',
                ],
            ],
            'datatable' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => [
                        '/backend/lib/datatable/jquery.dataTables.min.js',
                        '/backend/lib/datatable/dataTables.bootstrap.min.js',
                        '/backend/lib/datatable/datatable.js',
                    ]
                ],
            ],
            'custom' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/js/custom.js',
                ],
            ],
            'base' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => '/backend/js/base.js',
                ],
            ],
        ],

        'stylesheets' => [

            'font-awesome' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/lib/font-awesome/css/font-awesome.css',
                ],
            ],
            'bootstrap' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/lib/bootstrap/bootstrap.min.css',
                ],
            ],
            'ionicons' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/lib/Ionicons/css/ionicons.css',
                ],
            ],
            'perfect-scrollbar' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/lib/perfect-scrollbar/css/perfect-scrollbar.css',
                ],
            ],
            'jquery-switchbutton' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/lib/jquery-switchbutton/jquery.switchButton.css',
                ],
            ],
            'bracket' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/css/bracket.css',
                ],
            ],
            'nifty' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/css/nifty.min.css',
                ],
            ],
            'theme-dust' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/css/theme-dust.min.css',
                ],
            ],
            'jquery-nestable' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/css/jquery.nestable.css',
                ],
            ],
            'sweet-alert' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/lib/sweetalert/sweetalert.css',
                ],
            ],
            'noty' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/lib/noty/lib/noty.css',
                ],
            ],
            'datatable' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => [
                        '/backend/lib/datatable/dataTables.bootstrap.min.css',
                        '/backend/lib/datatable/datatable.css',
                    ]
                ],
            ],
            'custom' => [
                'use_cdn' => false,
                'location' => 'top',
                'src' => [
                    'local' => '/backend/css/custom.css',
                ],
            ],
        ]

    ]

];