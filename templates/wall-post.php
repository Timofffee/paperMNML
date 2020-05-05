<?php


function get_posts($offset = 0, $count = 10) {
    global $database;

    $datas = $database->select("post", [
        "[>]user" => ["user_id" => "user_id"]
    ], [
        "post.post_id (post_id)",
        "post.title (title)",
        "post.text (text)",
        "post.publish_date (publish_date)",
        "user.login (login)"
    ], [
        "LIMIT" => [$offset, $count]
    ]);
    $datas[0][vote] = $database->count("vote", [
        "type" => 0,
        "where_id" => $post_id,
        "positive" => 1
    ]) - $database->count("vote", [
        "type" => 0,
        "where_id" => $post_id,
        "positive" => 0
    ]);

    foreach($datas as $data) {
        $data[vote] = $database->count("vote", [
            "type" => 0,
            "where_id" => $data[post_id],
            "positive" => 1
        ]) - $database->count("vote", [
            "type" => 0,
            "where_id" => $data[post_id],
            "positive" => 0
        ]);

        $data[tag] = $database->select("tag_post_con", [
            "[>]tag" => ["tag_id" => "tag_id"]
        ],[
            "tag.name"
        ],[
            "post_id" => $data[post_id]
        ]);
        render_post($data);
    }
}
# vote_id	type	where_id	from_id	to_id	positive	date

function get_post($post_id) {
    global $database;

    $data = $database->select("post", [
        "[>]user" => ["user_id" => "user_id"]
    ], [
        "post.post_id (post_id)",
        "post.title (title)",
        "post.text (text)",
        "post.publish_date (publish_date)",
        "user.login (login)"
    ], [
        "post_id" => $post_id
    ])[0];

    $data[vote] = $database->count("vote", [
        "type" => 0,
        "where_id" => $post_id,
        "positive" => 1
    ]) - $database->count("vote", [
        "type" => 0,
        "where_id" => $post_id,
        "positive" => 0
    ]);

    $data[tag] = $database->select("tag_post_con", [
        "[>]tag" => ["tag_id" => "tag_id"]
    ],[
        "tag.name"
    ],[
        "post_id" => $data[post_id]
    ]);

    render_full_post($data);
}

function render_post($data) { ?>

    <div class="card tread">
        <!-- vote (left side) -->
        <div class="col vote" id="post_<?=$data[post_id]?>">
            <a href="javascript:void(0)" class="arrow top is-center" onclick="upVote($('#post_<?=$data[post_id]?>'))">up</a>
            <span class="is-center"><b><?=$data[vote]?></b></span>
            <a href="javascript:void(0)" class="arrow down is-center" onclick="downVote(this)">down</a>
        </div>

        <!-- header -->
        <header>
            <small>Posted by <a href="/@<?=$data[login]?>"><?=$data[login]?></a></small>
            <small><a href="/post/<?=$data[post_id]?>"><?=$data[publish_date]?></a></small>
            <h3><a href="/post/<?=$data[post_id]?>" class="text-dark"><?=$data[title]?></a></h3>
            <hr class="is-marginless">
        </header>

        <!-- body here -->
        <article class="t_1000" id="post_1">
<?
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
        
        <p>
            <button onclick=" $('#post_1').removeClass('t_1000');this.parentElement.style.display = 'none'" class="button clear">Show more</button>
        </p>
        
        
        <!-- tag -->
        <? 
        foreach ($data[tag] as $key => $value) { ?>
            <a class="tag is-small" href="/tag/<?=$value[name]?>"><?=$value[name]?></a>
        <? } ?>
        
        <hr style="margin-bottom: 0.5rem">

        <!-- post footer -->
        <div style="padding-bottom: 0.5rem" class="row" class="is-vertical-align">
                <a href="/post/<?=$data[post_id]?>/#comments" class="is-vertical-align text-grey">
                <img src="https://icongr.am/fontawesome/commenting-o.svg" alt="" style="margin:0 0.5rem; margin-left: 1.5rem; width: 1.5rem">0
            </a>
            <a href="" class="is-vertical-align text-grey">
                <img src="https://icongr.am/fontawesome/share-alt.svg" alt="" style="margin:0 0.5rem; margin-left: 1.5rem; width: 1.5rem">
            </a>
            <a href="" class="is-vertical-align text-grey">
                <img src="https://icongr.am/fontawesome/floppy-o.svg" alt="" style="margin:0 0.5rem; margin-left: 1.5rem; width: 1.5rem">
            </a>
        </div>
    </div>

<? }


function render_full_post($data) { ?>

<div class="card tread">
    <!-- vote (left side) -->
    <div class="col vote">
        <a href="" class="arrow top is-center">up</a>
            <span class="is-center"><b><?=$data[vote]?></b></span>
        <a href="" class="arrow down is-center">down</a>
    </div>

    <!-- header -->
    <header>
        <small>Posted by <a href="/@<?=$data[login]?>"><?=$data[login]?></a></small>
        <small><a href="/post/<?=$data[post_id]?>"><?=$data[publish_date]?></a></small>
        <a href="/post/<?=$data[post_id]?>" class="text-dark"><h3><?=$data[title]?></h3></a>
        <hr class="is-marginless">
    </header>

    <!-- body here -->
    <article>
<?
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
    
    
    <!-- tag -->
    <? 
    foreach ($data[tag] as $key => $value) { ?>
        <a class="tag is-small" href="/tag/<?=$value[name]?>"><?=$value[name]?></a>
    <? } ?>
    <hr style="margin-bottom: 0.5rem">

    <!-- post footer -->
    <div style="padding-bottom: 0.5rem" class="row" class="is-vertical-align">
            <a href="/post/<?=$data[post_id]?>/#comments" class="is-vertical-align text-grey">
            <img src="https://icongr.am/fontawesome/commenting-o.svg" alt="" style="margin:0 0.5rem; margin-left: 1.5rem; width: 1.5rem">0
        </a>
        <a href="" class="is-vertical-align text-grey">
            <img src="https://icongr.am/fontawesome/share-alt.svg" alt="" style="margin:0 0.5rem; margin-left: 1.5rem; width: 1.5rem">
        </a>
        <a href="" class="is-vertical-align text-grey">
            <img src="https://icongr.am/fontawesome/floppy-o.svg" alt="" style="margin:0 0.5rem; margin-left: 1.5rem; width: 1.5rem">
        </a>
    </div>
</div>

<? } ?>