<?php

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

const STATUS_OK = 0;
const STATUS_BAD_LOGIN = 1;
const STATUS_BAD_EMAIL = 2;
const STATUS_BAD_PASSWORD = 3;
const STATUS_LOGIN_EXISTS = 4;
const STATUS_EMAIL_EXISTS = 5;
const STATUS_DB_ERROR = 6;

$response = [
    status => STATUS_OK
];


function generateCode($length = 6)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code.= $chars[mt_rand(0, $clen) ];
    }
    return $code;
}

if (!isset($_POST[login]) or !preg_match('/^[A-Za-z][A-Za-z0-9_]{3,16}$/', $_POST[login])) {
    $response[status] = STATUS_BAD_LOGIN;

} elseif (!isset($_POST[email]) or empty(filter_var($_POST[email], FILTER_VALIDATE_EMAIL))) {
    $response[status] = STATUS_BAD_EMAIL;
}
 elseif (!isset($_POST[password]) or !preg_match('/^[A-Za-z0-9_]{8,128}$/', $_POST[password])) {
    $response[status] = STATUS_BAD_PASSWORD;
    
} else {
    require_once($_SERVER['DOCUMENT_ROOT']."/db.php");
    
    if($database->has("user",[
            "login" => $_POST[login]
    ])) {
        $response[status] = STATUS_LOGIN_EXISTS;
    
    } elseif($database->has("user",[
        "email" => $_POST[email]
    ])) {
        $response[status] = STATUS_EMAIL_EXISTS;

    } else {
        $database->insert("user", [
            "login" => $_POST[login],
            "email" => $_POST[email],
            "pass_hash" => password_hash($_POST[password], PASSWORD_DEFAULT)
        ]);
        
        if ($database->error()[0] != "00000") { 
            $response[status] = STATUS_DB_ERROR;
        }
    }
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);