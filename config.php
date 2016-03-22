<?php
return [
    'plugins' => [
        'Url',
        'GetImagesLinks',
        'ResizeImages',
        'SaveImagesMySql'
    ],
    'mysql' => [
        'serverName' => 'localhost',
        'user' => 'root',
        'password' => '123456',
        'db' => 'parser',
    ],
    'url' => [
        'depth' => 1
    ]
];