<? 
require_once("db.php"); 
if (!isset($_GET["login"]) or 
    !$database->has("user", [
        "login" => $_GET['login']
    ])) {
    header("Location: /");
} 
$suser = $database->select("user", [
    "user_id",
    "login",
    "email",
    "role",
    "reg_date",
    "avatar", 
    "session_id"
], [
    "login" => $_GET['login']
])[0];

$is_owner = $suser[user_id] == $_COOKIE[uid] and $suser[session_id] == $_COOKIE[sid];

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        // 'h' => 'hour',
        // 'i' => 'minute',
        // 's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(' ', $string) : 'just now';
}
?> 

<!DOCTYPE html>
<html lang="en">

<? 
$_HEAD = [
    # Когда-нибудь добавлю раздел "кратко о себе"
    # и это пойдёт в описание страницы))
    "title" => $_GET['login'],
    "description" => "About user"
];
require_once("templates/head.php"); ?>

<body class="bg-light">
    <? require_once("templates/header.php"); ?>
    <main style="margin-top: 6rem" class="container">
        
        <div class="row reverse">
            <? require_once("templates/side-panel.php"); ?>
            <!-- wall -->
            <div class="col col-9-md">
                <!-- tabs -->
                <!-- <div class="row">
                    <div class="col card sort row is-paddingless">
                        <nav class="col tabs is-marginless">
                            <a href="" class="active">Общее</a>
                            <a href="">Настройки</a>
                        </nav>
                    </div>
                </div> -->
                <!-- main -->
                <div class="card">
                    <div class="row">
                
                        <div class="col-auto" style="max-width: 10rem;margin-bottom:0;margin: 1rem 2rem">
                            <div class="button clear avatar large is-paddingless is-rounded bg-grey">
                                <img id="avatar-in-profile" class="is-rounded avatar-img" src="<?=($suser[avatar] != null) ? $suser[avatar] : "/img/default_avatar.jpg"?>" />
                                <? if($is_owner): ?>
                                    <img class="avatar-load" src="https://icongr.am/fontawesome/camera.svg?color=f3f4f5">
                                    <input type="file" name="" class="avatar-load-button" id="avatar-load-button" accept="image/png,image/jpg,image/jpeg">
                                <? endif; ?>
                            </div>
                        </div>
                        <div class="col" style="line-height: 1;">
                            <h2 style="padding-top: 2rem"><?=$suser[login]?></h2>
                            <p>On paperMNML <?=time_elapsed_string("@".strtotime($suser[reg_date]), true)?>
                            
                            </p>
                        </div>
                        <? if($is_owner): ?>
                        <div class="col-auto" style="max-width: 5rem;padding-top: 2rem">
                            <a href="/settings" class="">
                            <img src="https://icongr.am/fontawesome/gear.svg" style="margin:0 1rem; margin-left: 2rem; width: 2rem"/>
                            </a>
                        </div>
                        <? endif; ?>
                    </div>
                    <hr>
                    <p>Put <b class="text-success">23</b> like and <b class="text-error">999</b> dislike</p>
                    <hr>
                    <div class="row profile-stats">
                        <div class="col-3 profile-stats-block">
                            <b style="font-size:4rem;font-weight: 400; line-height:1;">114</b><br>
                            <span>Rating</span>
                        </div>
                        <div class="col-3 profile-stats-block">
                            <b style="font-size:4rem;font-weight: 400; line-height:1;">5</b><br>
                            <span>Comments</span>
                        </div>
                        <div class="col-3 profile-stats-block">
                            <b style="font-size:4rem;font-weight: 400; line-height:1;">23</b><br>
                            <span>Posts</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<script>
    function getCookie(name) {

    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ))
        return matches ? decodeURIComponent(matches[1]) : undefined
    }

    $("#avatar-load-button").change(function(){
        let formData = new FormData();
        
        let imagefile = document.querySelector('#avatar-load-button');
        formData.append("image", $("#avatar-load-button")[0].files[0]);
        formData.append("user_id", getCookie('uid'));
        formData.append("session_id", getCookie('sid'));
        axios.post('/api/user/upload_image.php', formData, {
            headers: {
            'Content-Type': 'multipart/form-data'
            }
        })
        .then(function (response) {
            if (response.data.status == 1) {
                alert("Bad type. Only .png or .jpg");
            } else if(response.data.status == 2) {
                alert("Big size. Max size 500kb");
            } else if(response.data.status == 3) {
                alert("Can't load file on server. Try later");
            } else if(response.data.status == 4) {
                alert("Bad user id");
            } else if(response.data.status == 5) {
                alert("Bad session id");
            } else if(response.data.status == 6) {
                alert("Error. Not logged");
            } else if(response.data.status == 0) {
                $('.avatar-img').attr("src", response.data["data"]["path"]);
            } 
            
        })
        .catch(function (error) {
            console.log(error);
        });
    });
</script>

<script src="/js/maintainscroll.js"></script>
</body>
