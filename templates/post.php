<? 

require_once("api/post/get_post.php");
get_post($_GET["post_id"]);

?>
<div class="card comments" id="comments">
    <header>
        <h3>Comments</h3>
        <hr>
    </header>
    
    <form class="col" id="create_comment" onsubmit="addComment(this)">
        <textarea name="comment_text" id="comment_text_new" rows="3" style="resize:none;margin-bottom: 10px" placeholder="new comment..."></textarea>
        <button type="submit">Send</button>
    </form>

    <?php
    global $database;
    $comments = $database->select("post_comment", [
        "[>]user" => ["user_id" => "user_id"]
    ], [
        "user.login (login)",
        "user.avatar (avatar)",
        "post_comment.comment_id (comment_id)",
        "post_comment.text (text)",
        "post_comment.date (date)"
    ], [
        "post_id" => $_GET["post_id"]
    ]);
    
    foreach ($comments as $comment) { ?>

        <div class="col comment" id="comment_<?=$comment[comment_id]?>">
            <header class="row">
                <div class="row vote is-vertical-align is-marginless">
                    <!-- <span class="is-center" style="margin-right:0.8rem text-grey"><b>123</b></span>
                    <a href="" class="arrow small top is-center is-marginless">up</a>
                    <a href="" class="arrow small down is-center is-marginless">down</a> -->
                    <a href="/@<?=$comment[login]?>" class="button clear avatar tiny is-paddingless is-rounded bg-grey">
                        <img class="is-rounded avatar-img" src="<?=($comment[avatar] != null) ? $comment[avatar] : "/img/default_avatar.jpg"?>" />  
                    </a>
                    <a href="/@<?=$comment[login]?>" class="button clear is-vertical-align is-paddingless">
                        <?=$comment[login]?>
                    </a>
                    <sup><small><a href="/post/<?=$_GET["post_id"]?>/#comment_<?=$comment[comment_id]?>" class="text-grey"><?=time_elapsed_string($comment[date])?></a></small></sup>
                </div>
            </header>
            <div class="col">
                <p class="is-marginless">
                    <?=$comment[text]?>
                </p>
                <!-- <small><a href="">Reply</a></small> -->
            </div>
        </div>
    <? } ?>
</div>


