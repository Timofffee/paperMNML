<?
    $user = $database->select("user", [
        "user_id",
        "login",
        "email",
        "role",
        "reg_date",
        "avatar"
    ], [
        "user_id" => $_COOKIE['uid']
    ])[0];
?>


<div class="row">
            
    <div class="col-auto" style="max-width: 5rem;margin-bottom:0;">
        <a href="/@<?=$user[login]?>" class="button clear avatar is-paddingless is-rounded bg-grey">
        <img class="is-rounded avatar-img" src="<?=($user[avatar] != null) ? $user[avatar] : "/img/default_avatar.jpg"?>" />
        </a>
    </div>
    <div class="col is-marginless " style="overflow: hidden; line-height: 1.3;">
        <p style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis; font-weight: 600; font-size:1.8rem"><?=$user[login]?></p>
        <small><a href="javascript:void(0);" onclick="profileLogout();" class="text-grey">Logout</a></small>    
    </div>
    <div class="col-auto is-marginless" style="max-width: 5rem;">
        <a href="/settings" class="">
        <img src="https://icongr.am/fontawesome/gear.svg" style="margin:0 1rem; margin-left: 2rem; width: 1.5rem"/>
        </a>
    </div>
</div>
<!-- <hr style="margin-left: -2rem;margin-right: -2rem;"> -->
<!-- Будущий функционал -->
<!-- <div class="row">
    <span class="is-large"><b>1634644</b> рейтинг</span>
    <span class="is-large"><b>3.2M</b> подписчиков</span>
</div> -->
<hr style="margin-left: -2rem;margin-right: -2rem;">
<!-- <a href="" class="button clear is-full-width is-marginless" style="text-align: left;">Ответы</a> -->
<a href="" class="button clear is-full-width is-marginless" style="text-align: left;">Комментарии</a>
<a href="" class="button clear is-full-width is-marginless" style="text-align: left;">Оценки</a>
<!-- <a href="" class="button clear is-full-width is-marginless" style="text-align: left;">Сохраненное</a> -->
<!-- <a href="" class="button clear is-full-width is-marginless" style="text-align: left;">Подписки</a> -->
<!-- <a href="" class="button clear is-full-width is-marginless" style="text-align: left;">Игнор-лист</a> -->


<script>
    function profileLogout() {
        document.cookie = "uid=DONT_TOUCH; max-age=0;path=/";
        document.cookie = "sid=OAOAOAOAOa; max-age=0;path=/";
        location.reload(true);
    }
</script>