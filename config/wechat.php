<?php

return [
    'debug' => true,
    'app_id' => env('WECHAT_APP_ID'),
    'secret' => env('WECHAT_APP_SECRET'),
    'token' => env('WECHAT_TOKEN'),

    'aes_key' => env('WECHAT_AES_KEY'),

    'log' => storage_path('logs/wechat.log'),

    'oauth' => [
        'scopes' => [
            'snsapi_userinfo'
        ],
        'callback' => '/wechat_oauth_callback'
    ],
    'session_user_key' => 'wechat_user',
    'target_url_before_redirect_key' => 'target_url_before_redirect'
];