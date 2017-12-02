<?php

return [
    /* ------------------------------------------------------------------------------------------------
     |  Log files storage path
     | ------------------------------------------------------------------------------------------------
     */
    'storage-path'  => storage_path('logs'),

    /* ------------------------------------------------------------------------------------------------
     |  Locale
     | ------------------------------------------------------------------------------------------------
     |  Supported locales :
     |    'auto', 'ar', 'de', 'en', 'es', 'fa', 'fr', 'hy', 'it', 'nl', 'pl', 'pt-BR', 'ro', 'ru', 'sv', 'tr', 'zh-TW', 'zh'
     */
    'locale'        => 'zh',

    /* ------------------------------------------------------------------------------------------------
     |  Route settings
     | ------------------------------------------------------------------------------------------------
     */
    'route'         => [
        'enabled'    => true,

        'attributes' => [
            'prefix'     => 'log-viewer',

            'middleware' => null,
        ],
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Log entries per page
     | ------------------------------------------------------------------------------------------------
     |  This defines how many log entries are displayed per page.
     */
    'per-page'      => 25,

    /* ------------------------------------------------------------------------------------------------
     |  LogViewer's Facade
     | ------------------------------------------------------------------------------------------------
     */
    'facade'        => 'LogViewer',

    /* ------------------------------------------------------------------------------------------------
     |  Download settings
     | ------------------------------------------------------------------------------------------------
     */
    'download'      => [
        'prefix'    => 'laravel-',

        'extension' => 'log',
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Menu settings
     | ------------------------------------------------------------------------------------------------
     */
    'menu'  => [
        'filter-route'  => 'log-viewer::logs.filter',

        'icons-enabled' => true,
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Icons
     | ------------------------------------------------------------------------------------------------
     */
    'icons' =>  [
        /**
         * Font awesome >= 4.3
         * http://fontawesome.io/icons/
         */
        'all'       => 'fa fa-list',                 // http://fontawesome.io/icon/list/
        'emergency' => 'fa fa-bug',                  // http://fontawesome.io/icon/bug/
        'alert'     => 'fa fa-bullhorn',             // http://fontawesome.io/icon/bullhorn/
        'critical'  => 'fa fa-heartbeat',            // http://fontawesome.io/icon/heartbeat/
        'error'     => 'fa fa-times-circle',         // http://fontawesome.io/icon/times-circle/
        'warning'   => 'fa fa-exclamation-triangle', // http://fontawesome.io/icon/exclamation-triangle/
        'notice'    => 'fa fa-exclamation-circle',   // http://fontawesome.io/icon/exclamation-circle/
        'info'      => 'fa fa-info-circle',          // http://fontawesome.io/icon/info-circle/
        'debug'     => 'fa fa-life-ring',            // http://fontawesome.io/icon/life-ring/
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Colors
     | ------------------------------------------------------------------------------------------------
     */
    'colors' =>  [
        'levels'    => [
            'empty'     => '#D1D1D1',
            'all'       => '#8A8A8A',
            'emergency' => '#B71C1C',
            'alert'     => '#D32F2F',
            'critical'  => '#F44336',
            'error'     => '#FF5722',
            'warning'   => '#FF9100',
            'notice'    => '#4CAF50',
            'info'      => '#1976D2',
            'debug'     => '#90CAF9',
        ],
    ],
    'background-images' => [
        '/assets/img/background/1.jpg',
        '/assets/img/background/2.jpg',
        '/assets/img/background/3.jpg',
        '/assets/img/background/4.jpg',
        '/assets/img/background/5.jpg',
        '/assets/img/background/6.jpg',
        '/assets/img/background/7.jpg'
    ]
];
