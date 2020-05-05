<?php
$_CONFIG = [
    'database' => [
        'server'   => 'localhost',
        'name'     => 'site4',
        'user'     => 'root',
        'password' => ''
    ]
];

$_HEAD_TMP  = [
    'title' => 'paperMNML',
    'description' => 'paperMNML is a social network based on the endless desire of people to share useless information with others.'
];

$_PAGES = [
    'index' => [
        'template'      => 'feed.php'
    ],
    'user' => [
        'template'      => 'user.php'
        'head_template' => 'user_head.php'
    ],
    'post' => [
        'template'      => 'post.php'
        'head_template' => 'post_head.php'
    ],
    'new_post' => [
        'template'      => 'new_post.php'
    ],
    'search' => [
        'template'      => 'search.php'
    ],
    'error_404' => [
        'template'      => 'error_404.php'
    ],
    'forgot_password' => [
        'template'      => 'forgot_password.php'
    ]
];

$_USER = [];
