<div class="row">
            
    <div class="col-auto" style="max-width: 5rem;margin-bottom:0;">
        <a href="/@<?=$_USER[login]?>" class="button clear avatar is-paddingless is-rounded bg-grey">
        <img class="is-rounded avatar-img" src="<?=($_USER[avatar] != null) ? $_USER[avatar] : "/img/default_avatar.jpg"?>" />
        </a>
    </div>
    <div class="col is-marginless " style="overflow: hidden; line-height: 1.3;">
        <p style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis; font-weight: 600; font-size:1.8rem"><?=$_USER[login]?></p>
        <small><a href="javascript:void(0);" onclick="profileLogout();" class="text-grey">Logout</a></small>    
    </div>
    <div class="col-auto is-marginless" style="max-width: 5rem;">
        <a href="/settings" class="">
        <img src="https://icongr.am/fontawesome/gear.svg" style="margin:0 1rem; margin-left: 2rem; width: 1.5rem"/>
        </a>
    </div>
</div>
<hr style="margin-left: -2rem;margin-right: -2rem;">
<a href="" class="button clear is-full-width is-marginless" style="text-align: left;">Комментарии</a>
<a href="" class="button clear is-full-width is-marginless" style="text-align: left;">Оценки</a>


<script>
    function profileLogout() {
        deleteCookie("uid");
        deleteCookie("sid");
        location.reload(true);
    }
</script>