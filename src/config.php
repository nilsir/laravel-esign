<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    'debug' => env('ESIGN_DEBUG', false), // 是否开启调试
    'app_id' => env('ESIGN_APP_ID', 'your-app-id'), // 请替换成自己的 AppId
    'secret' => env('ESIGN_SECRET', 'your-secret'), // 请替换成自己的 Secret
    'production' => env('ESIGN_PRODUCTION', false), // 是否正式环境

    'log' => [
        'level' => env('ESIGN_LOG_LEVEL', 'debug'),
        'permission' => 0777,
        'file' => env('ESIGN_LOG_FILE', storage_path('logs/esign.log')), // 开启调试时有效, 可指定日志文件地址
    ],
];
