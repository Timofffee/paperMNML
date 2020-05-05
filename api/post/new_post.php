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

require_once($_SERVER['DOCUMENT_ROOT']."/db.php");

if (isset($_POST['title']) and 
    isset($_POST['tags']) and 
    isset($_POST['text']) and
    isset($_POST['user_id'])
) {
    $database->insert("post",[
        "title" => $_POST['title'],
        "text" => $_POST['text'],
        "user_id" => $_POST['user_id']
    ]);

    $post_id = $database->id();
    foreach(explode(',', $_POST['tags']) as $tag) {
        $tag_id = 0;
        if (!$database->has("tag",[
            "name" => trim($tag)
        ])) {
            $database->insert("tag",[
                "name" => trim($tag)
            ]);
            $tag_id = $database->id();
        } else {
            $tag_id = $database->select("tag", [
                "tag_id"
            ], [
                "name" => trim($tag)
            ])[0]["tag_id"];
        }
        $database->insert("tag",[
            "tag_id" => $tag_id,
            "post_id" => $post_id
        ]);

    }
} else {
    $response[status] = STATUS_BAD_EMAIL;
    $response[data] = $_POST;
}


echo json_encode($response, JSON_UNESCAPED_UNICODE);