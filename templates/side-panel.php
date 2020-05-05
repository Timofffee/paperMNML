<div class="col hide-xs hide-sm">
    <? 
        # require_once("templates/pin-tags.php");    # pin tags
        require_once("templates/panel-profile.php"); # profile
        if($is_logged) {
            ?><a href="/new_post.php" class="button primary icon is-full-width is-center" ><img src="https://icongr.am/fontawesome/plus.svg?size=16&color=ffffff" alt="icon" style="margin-left: -20px; margin-right: 10px">New post</a><?
        }
    ?>
</div>