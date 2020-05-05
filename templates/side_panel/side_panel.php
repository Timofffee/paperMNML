<div class="col hide-xs hide-sm">
    <? 
        # pin tags
        # require_once 'templates/pin-tags.php';

        # profile
        require_once 'templates/side_panel/panel_profile.php';

        # Button 'New Post'
        if($is_logged): ?>
            <a href="/new_post" class="button primary icon is-full-width is-center" >
                <img src="https://icongr.am/fontawesome/plus.svg?size=16&color=ffffff" alt="icon" style="margin-left: -20px; margin-right: 10px">
                New post
            </a>
        <? endif; ?>
</div>