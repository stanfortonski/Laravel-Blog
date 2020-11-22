<?php

return [
    '403' => [
        'title' => 'Forbidden',
        'description' => 'You are not authorized for that action.'
    ],

    '404' => [
        'title' => 'Page Not Found',
        'description' => 'Can\'t find page with that address.'
    ],

    '405' => [
        'title' => 'Method Not Allowed',
        'description' => 'This action is not defined.'
    ],

    '419' => [
        'title' => 'Page expired',
        'description' => 'Probably your session expired.'
    ],

    '429' => [
        'title' => 'Too Many Requests',
        'description' => 'Please wait before performing this action again.'
    ],

    '500' => [
        'title' => 'Internal server error',
        'description' => 'We apologize for the problems. We will correct them as soon as possible.'
    ],

    '503' => [
        'title' => 'In Maintaining',
        'description' => 'Website is in the maintaining.'
    ]
];
