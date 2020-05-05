<?
    $user = [];
    if ($is_logged) {
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
    }
?>

<header class="is-top bg-dark is-fixed" style="top:0; width:100%;">
    <nav class="nav container is-center ">
        <div class="nav-left">
            <a class="brand row hide-xs" href="/">
                <img src="/img/logo.svg" alt="">paperMNML
            </a>
            <a class="brand row hide-sm hide-md hide-lg" href="/">
                pprMNML
            </a>
            <!-- <a>
                <b>Горячее</b>
            </a>
            <a href="/new">
                <b>Свежее</b>
            </a>
            <a href="/community">
                <b>Сообщества</b>
            </a> -->
        </div>

        <div class="nav-right">
            <!-- search -->
            <input type="text" id="search-input" placeholder="Search" style="width:0;max-width: calc(100% - 11rem); transition: all 1s cubic-bezier(0.22, 1, 0.36, 1);" class="is-hidden">
            <a href="javascript:void(0)" onclick="searchPressed()" class="button clear bg-grey is-rounded" style="padding:0.5rem">
                <img class="is-rounded" src="https://icongr.am/fontawesome/search.svg?size=20&color=d2d6dd" />
            </a>

            <!-- <a href="" class="button clear bg-grey is-rounded" style="padding:0.5rem">
                <img class="is-rounded" src="https://icongr.am/fontawesome/bell-o.svg?size=20&color=d2d6dd" />
            </a> -->
            
            <? if (empty($user)): ?>
            <a class="button avatar small clear bg-grey is-paddingless is-rounded">

                <img class="is-rounded avatar-img" src="/img/default_avatar.jpg"/>
            </a>
            <? else: ?>
                <a href="/@<?=$user[login]?>" class="button avatar small clear bg-grey is-paddingless is-rounded">

                    <img class="is-rounded avatar-img" src="<?=($user[avatar] != null) ? $user[avatar] : "/img/default_avatar.jpg"?>"/>
                </a>
            <? endif; ?>
        </div>
    </nav>
</header>

<script>
    function searchPressed() {
        if ($('#search-input').hasClass('is-hidden')) {
            $('#search-input').removeClass('is-hidden');
            $('#search-input').css("width", "calc(100% - 11rem)");
        } else {
            let search_text = $('#search-input').val();
            if (search_text != "") {
                window.location.href = "/search/"+search_text;
            }
        }
    }
</script>