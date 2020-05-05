<?php

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

const STATUS_OK = 0;
const STATUS_BAD_LOGIN = 1;
const STATUS_BAD_PASSWORD = 2;
const STATUS_INCORRECT = 3;

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

if (!isset($_POST[login]) or 
    (!preg_match('/^[A-Za-z][A-Za-z0-9_]{3,16}$/', $_POST[login]) and 
        empty(filter_var($_POST[login], FILTER_VALIDATE_EMAIL)))) {
    $response[status] = STATUS_BAD_LOGIN;

} elseif (!isset($_POST[password]) or !preg_match('/^[A-Za-z0-9_]{8,128}$/', $_POST[password])) {
    $response[status] = STATUS_BAD_PASSWORD;

} else {
    require_once($_SERVER['DOCUMENT_ROOT']."/db.php");

    $login_type = empty(filter_var($_POST[login], FILTER_VALIDATE_EMAIL)) ?
        "login" : "email";

    $sdata = $database->select("user", 
        [user_id, pass_hash, session_id], 
        [$login_type => $_POST[login]]
    )[0];

    if(!password_verify($_POST[password], $sdata[pass_hash]) or null == $sdata) {
        $response[status] = STATUS_INCORRECT;
        $response[data] = [
            $sdata,
            password_hash($_POST[password],PASSWORD_DEFAULT )
        ];
        
    } else {
        
        $sid = $sdata[session_id];
        $uid = $sdata[user_id];
        if(null == $sid) {
            $sid = generateCode(64);
            $database->update("user", [
                "session_id" => $sid
            ], [
                "login" => $_POST[login]
            ]);
        }
        $response[data] = [
            sid => $sid,
            uid => $uid
        ];
    }
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);