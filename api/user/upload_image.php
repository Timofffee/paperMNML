<?php

// $rest_json = file_get_contents("php://input");
// $_POST = json_decode($rest_json, true);

const STATUS_OK = 0;
const STATUS_BAD_TYPE = 1;
const STATUS_BAD_SIZE = 2;
const STATUS_LOAD_ERROR = 3;
const STATUS_BAD_USER_ID = 4;
const STATUS_BAD_SESSION_ID = 5;
const STATUS_NOT_LOGGED = 6;

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

$type = "";
switch ($_FILES["image"]["type"]) {
    case 'image/png':
        $type = ".png";
        break;
    case 'image/jpeg':
    case 'image/jpg':
        $type = ".jpg";
        break;
}

require_once($_SERVER['DOCUMENT_ROOT']."/db.php");

if (!isset($_POST[user_id])) {
    $response[status] = STATUS_BAD_USER_ID;
    $response[data] = $_POST;
} else if (!isset($_POST[session_id])) {
    $response[status] = STATUS_BAD_SESSION_ID;
} else if (!$database->has("user",[
    "AND" => [
            "user_id" => $_POST[user_id],
            "session_id" => $_POST[session_id]
        ]
    ])) {
    $response[status] = STATUS_NOT_LOGGED;
} else if (empty($type)) {
    $response[status] = STATUS_BAD_TYPE;
} else if ($_FILES['image']['size'] > 400000) {
    $response[status] = STATUS_BAD_SIZE;
} else {
    $uploaddir = $_SERVER['DOCUMENT_ROOT']."/img/profile/";
    $uploadfile = $_POST['user_id']."_".generateCode().$type;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir.$uploadfile) and
        $database->update("user", [
            "avatar" => "/img/profile/".$uploadfile
        ], [
            "user_id" => $_POST[user_id]
        ])) {
        $response[data] =  ["path" => "/img/profile/".$uploadfile];
    } else {
        $response[status] = STATUS_LOAD_ERROR;
    }
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);