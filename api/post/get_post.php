<?php
const STATUS_OK = 0;
const STATUS_BAD_REQUEST = 1;
const STATUS_BAD_SIZE = 2;
const STATUS_LOAD_ERROR = 3;
const STATUS_BAD_USER_ID = 4;
const STATUS_BAD_SESSION_ID = 5;
const STATUS_NOT_LOGGED = 6;

//todo да, всё очень просто. я просто не успевал и поэтому
// превращенный в апи шаблон стал снова шаблоном,
// но зато он теперь лежит в апи.. 
// когда-нибудь я это исправлю. честно :)
function get_posts($count = 10, $offset = 0) {
$_GET['count'] = $count;
$_GET['offset'] = $offset;
require_once($_SERVER['DOCUMENT_ROOT']."/db.php");
global $database;

$response = [
    status => STATUS_OK
];

$datas = [];

if ((!isset($_GET['count']) or !isset($_GET['offset']))) {
    if (!isset($_GET['post_id'])) {
        $response[status] = STATUS_BAD_REQUEST;
    } else {
        
        $datas = $database->select("post", [
            "[>]user" => ["user_id" => "user_id"]
        ], [
            "post.post_id (post_id)",
            "post.title (title)",
            "post.text (text)",
            "post.publish_date (publish_date)",
            "user.login (login)"
        ], [
            "post_id" => $_GET['post_id']
        ]);
    }
} else {
    $datas = $database->select("post", [
        "[>]user" => ["user_id" => "user_id"]
    ], [
        "post.post_id (post_id)",
        "post.title (title)",
        "post.text (text)",
        "post.publish_date (publish_date)",
        "user.login (login)"
    ], [
        "LIMIT" => [$_GET['offset'], $_GET['count']],
        "ORDER" => [
            // Order by column with sorting by customized order.
            "post.publish_date" => "DESC"
        ]
    ]);
}

if (!empty($datas)) {
    for ($i=0; $i < count($datas); $i++) { 
        $datas[$i][vote] = $database->count("vote", [
            "type" => 0,
            "where_id" => $datas[$i][post_id],
            "positive" => 1
        ]) - $database->count("vote", [
            "type" => 0,
            "where_id" => $datas[$i][post_id],
            "positive" => 0
        ]);
    
        $datas[$i][tag] = $database->select("tag_post_con", [
            "[>]tag" => ["tag_id" => "tag_id"]
        ],[
            "tag.name"
        ],[
            "post_id" => $datas[$i][post_id]
        ]);
        render_post($datas[$i]);
    }
}
}

function get_post($post_id) {
    $_GET['post_id'] = $post_id;
    require_once($_SERVER['DOCUMENT_ROOT']."/db.php");
    global $database;
    
    $response = [
        status => STATUS_OK
    ];
    
    $datas = [];
    
    if (!isset($_GET['post_id'])) {
        $response[status] = STATUS_BAD_REQUEST;
    } else {
        
        $datas = $database->select("post", [
            "[>]user" => ["user_id" => "user_id"]
        ], [
            "post.post_id (post_id)",
            "post.title (title)",
            "post.text (text)",
            "post.publish_date (publish_date)",
            "user.login (login)"
        ], [
            "post_id" => $_GET['post_id']
        ]);
    }

    
    if (!empty($datas)) {
        for ($i=0; $i < count($datas); $i++) { 
            $datas[$i][vote] = $database->count("vote", [
                "type" => 0,
                "where_id" => $datas[$i][post_id],
                "positive" => 1
            ]) - $database->count("vote", [
                "type" => 0,
                "where_id" => $datas[$i][post_id],
                "positive" => 0
            ]);
        
            $datas[$i][tag] = $database->select("tag_post_con", [
                "[>]tag" => ["tag_id" => "tag_id"]
            ],[
                "tag.name"
            ],[
                "post_id" => $datas[$i][post_id]
            ]);
            render_post($datas[$i], true);
        }
    }
}

// Nice try, but not today; :)
// echo json_encode($datas, JSON_UNESCAPED_UNICODE);

function render_post($data, $full = false) { 
    global $database;   ?>

    <div class="card tread">
        <!-- vote (left side) -->
        <div class="col vote">
            <a href="javascript:void(0)" class="arrow top is-center" onclick="upVote(this, $('post_<?=$data[post_id]?>_vote'))">up</a>
            <span class="is-center"><b id="post_<?=$data[post_id]?>_vote"><?=$data[vote]?></b></span>
            <a href="javascript:void(0)" class="arrow down is-center" onclick="downVote(this, $('post_<?=$data[post_id]?>_vote'))">down</a>
        </div>

        <!-- header -->
        <header>
            <small>Posted by <a href="/@<?=$data[login]?>"><?=$data[login]?></a></small>
            <small><a href="/post/<?=$data[post_id]?>"><?=$data[publish_date]?></a></small>
            <h3><a href="/post/<?=$data[post_id]?>" class="text-dark"><?=$data[title]?></a></h3>
            <hr class="is-marginless">
        </header>

        <!-- body here -->
        <? if($full) { ?>
            <article id="post_<?=$data[post_id]?>">
        <? } else { ?>
            <article class="t_1000" id="post_<?=$data[post_id]?>">
        <? }
            foreach (explode("\n\r", $data[text]) as $d) {
                $source = explode(" ", $d);
                switch (trim($source[0])) {
                    case "!img":
                        ?> 
                            <img class="is-horizontal-align" src="/img/post/<?=$data[post_id]?>/<?=$source[1]?>" onclick="make_bigger_image(this)"> 
                        <?
                        break;
                    case "!video":
                        ?> 
                        <video class="is-horizontal-align" controls="controls">
                            <source src="/video/post/<?=$data[post_id]?>/<?=$source[1]?>" type='video/ogg; codecs="theora, vorbis"'>
                            <source src="/video/post/<?=$data[post_id]?>/<?=$source[1]?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                            <source src="/video/post/<?=$data[post_id]?>/<?=$source[1]?>" type='video/webm; codecs="vp8, vorbis"'>
                            Тег video не поддерживается вашим браузером. 
                        </video> <?
                        break;
                    case "!youtube":
                        ?>
                            <iframe class="is-full-width" height="456" src="https://www.youtube.com/embed/<?=$source[1]?>?modestbranding=1&rel=0&color=white" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <?
                        break;
                    default:
                        ?> <p>
                            <?=$d?>
                        </p> <?
                }
            } 
        ?>
            
        </article>
        <? if(!$full) { ?>
            <p>
                <button onclick=" $('#post_<?=$data[post_id]?>').removeClass('t_1000');this.parentElement.style.display = 'none'" class="button clear">Show more</button>
            </p>
        <? } ?>
        
        
        
        <!-- tag -->
        <? 
        foreach ($data[tag] as $key => $value) { ?>
            <a class="tag is-small" href="/tag/<?=$value[name]?>"><?=$value[name]?></a>
        <? } ?>
        
        <hr style="margin-bottom: 0.5rem">

        <!-- post footer -->
        <div style="padding-bottom: 0.5rem" class="row" class="is-vertical-align">
            <a href="/post/<?=$data[post_id]?>/#comments" class="is-vertical-align text-grey">
                <img src="https://icongr.am/fontawesome/commenting-o.svg" alt="" style="margin:0 0.5rem; margin-left: 1.5rem; width: 1.5rem">
                <? echo $database->count("post_comment", [
                    "post_id" => $data[post_id]
                ])?>
            </a>
            <!-- <a href="" class="is-vertical-align text-grey">
                <img src="https://icongr.am/fontawesome/share-alt.svg" alt="" style="margin:0 0.5rem; margin-left: 1.5rem; width: 1.5rem">
            </a> -->
            <!-- <a href="" class="is-vertical-align text-grey">
                <img src="https://icongr.am/fontawesome/floppy-o.svg" alt="" style="margin:0 0.5rem; margin-left: 1.5rem; width: 1.5rem">
            </a> -->
        </div>
    </div>

<? }