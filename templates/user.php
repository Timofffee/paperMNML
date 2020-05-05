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

<script>
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
