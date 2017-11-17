<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    'route' => [
        'enabled' => false,
        'open_platform' => [
            'uri' => 'serve',
            'attributes' => [
                'prefix' => 'open-platform',
                'middleware' => null,
            ],
        ],
    ],

    'defaults' => [
        'debug' => true,
        'response_type' => 'array',
        'use_laravel_cache' => true,
        'log' => [
            'level' => env('WECHAT_LOG_LEVEL', 'debug'),
            'file' => env('WECHAT_LOG_FILE', storage_path('logs/wechat.log')),
        ],
    ],

    'official_account' => [
        'app_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID', 'your-app-id'),
        'secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET', 'your-app-secret'),
        'token' => env('WECHAT_OFFICIAL_ACCOUNT_TOKEN', 'your-token'),
        'aes_key' => env('WECHAT_OFFICIAL_ACCOUNT_AES_KEY', ''),

        /*
         * OAuth 配置
         *
         * only_wechat_browser: 只在微信浏览器跳转
         * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
         * callback：OAuth授权完成后的回调页地址(如果使用中间件，则随便填写。。。)
         */
        // 'oauth' => [
        //     'only_wechat_browser' => false,
        //     'scopes'   => array_map('trim', explode(',', env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_SCOPES', 'snsapi_userinfo'))),
        //     'callback' => env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_CALLBACK', '/examples/oauth_callback.php'),
        // ],
    ],

    /*
     * 开放平台第三方平台
     */
    // 'open_platform' => [
    //     'app_id'  => env('WECHAT_OPEN_PLATFORM_APPID', ''),
    //     'secret'  => env('WECHAT_OPEN_PLATFORM_SECRET', ''),
    //     'token'   => env('WECHAT_OPEN_PLATFORM_TOKEN', ''),
    //     'aes_key' => env('WECHAT_OPEN_PLATFORM_AES_KEY', ''),
    // ],

    /*
     * 小程序
     */
    // 'mini_program' => [
    //     'app_id'  => env('WECHAT_MINI_PROGRAM_APPID', ''),
    //     'secret'  => env('WECHAT_MINI_PROGRAM_SECRET', ''),
    //     'token'   => env('WECHAT_MINI_PROGRAM_TOKEN', ''),
    //     'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY', ''),
    // ],

    /*
     * 微信支付
     */
    'payment' => [
        'sandbox_mode'       => env('WECHAT_PAYMENT_SANDBOX', true),
        'app_id'             => env('WECHAT_PAYMENT_APPID', ''),
        'secret'             => env('WECHAT_PAYMENT_SECRET', ''),
        'mch_id'             => env('WECHAT_PAYMENT_MERCHANT_ID', 'your-mch-id'),
        'key'                => env('WECHAT_PAYMENT_KEY', 'key-for-signature'),
        'cert_path'          => env('WECHAT_PAYMENT_CERT_PATH', 'path/to/cert/apiclient_cert.pem'),
        'key_path'           => env('WECHAT_PAYMENT_KEY_PATH', 'path/to/cert/apiclient_key.pem'),
        'notify_url'         => 'https://mall.md168.cn/notify/payment',
        // 'device_info'     => env('WECHAT_PAYMENT_DEVICE_INFO', ''),
        // 'sub_app_id'      => env('WECHAT_PAYMENT_SUB_APP_ID', ''),
        // 'sub_merchant_id' => env('WECHAT_PAYMENT_SUB_MERCHANT_ID', ''),
        // ...
    ],

    /*
     * 企业微信
     */
    // 'work' => [
    //     // 企业 ID
    //     'corp_id' => 'xxxxxxxxxxxxxxxxx',

    //     // 应用列表
    //     'agents' => [
    //         'contacts' => [
    //             'agent_id' => 100020,
    //             'secret'   => env('WECHAT_WORK_AGENT_CONTACTS_SECRET', ''),
    //         ],
    //        //...
    //    ],
    // ],
];
