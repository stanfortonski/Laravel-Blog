<?php

return [
    'description_length' => 255,

    'author_content_length' => 512,

    'pagination' => 50,

    'main_page_max_random_count' => 5,

    'timestamp_format' => 'Y-m-d',

    'theme' => env('BLOG_THEME', 'default'),

    'relative_posts_limit' => 3,

    'no-image' => [
        'background' => '#868e96',
        'color' => '#dee2e6'
    ],

    'allow_register' => false,

    'available_locales' => [
        'en',
        'pl'
    ],
];
