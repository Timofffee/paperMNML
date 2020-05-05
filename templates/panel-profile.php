<?php
function panel_profile_insert_data() {
    global $database;
    #mhah.. okay
    if (isset($_COOKIE[uid]) and 
    isset($_COOKIE[sid]) and 
    $database->has("user",[
        "AND" => [
            "user_id" => $_COOKIE[uid],
            "session_id" => $_COOKIE[sid]
        ]
    ])):
    require_once("templates/panel-login.php");
        
    else:
        require_once("templates/panel-auth.php");
    endif;
}
?>
    <div class="card panel">
        <? panel_profile_insert_data() ?>
    </div>



