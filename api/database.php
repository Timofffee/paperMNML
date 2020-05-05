<?php

require_once 'vendor/medoo.php';

// Using Medoo namespace
use Medoo\Medoo;

// Initialize
$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => $_CONFIG['database']['name'],
    'server'        => $_CONFIG['database']['server'],
    'username'      => $_CONFIG['database']['user'],
    'password'      => $_CONFIG['database']['password']
]);

$is_logged = 
    isset($_COOKIE[uid]) and 
    isset($_COOKIE[sid]) and 
    $database->has("user",[
        "AND" => [
            "user_id" => $_COOKIE[uid],
            "session_id" => $_COOKIE[sid]
        ]
    ]);