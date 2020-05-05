<?php

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

const STATUS_OK = 0;
const STATUS_BAD_ID= 1;

$response = [
    status => STATUS_OK
];

require_once($_SERVER['DOCUMENT_ROOT']."/db.php");

if(!$database->has("user", [
    "user_id" => $_POST['user_id']
])) {
    $response[status] = STATUS_BAD_ID;
} else {
    $user = $database->select("user", [
        "user_id",
        "login",
        "email",
        "role",
        "reg_date",
        "avatar"
    ], [
        "user_id" => $_POST['user_id']
    ])[0];
    
    $response[data] = $user;
}


echo json_encode($response, JSON_UNESCAPED_UNICODE);