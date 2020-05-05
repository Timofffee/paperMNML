<div class="card panel">
    <? 
        if (isset($_COOKIE[uid]) and 
        isset($_COOKIE[sid]) and 
        $database->has("user",[
            "AND" => [
                "user_id" => $_COOKIE[uid],
                "session_id" => $_COOKIE[sid]
            ]
        ])):
        require_once("templates/side_panel/panel_login.php");
            
        else:
            require_once("templates/side_panel/panel_auth.php");
        endif;
    ?>
</div>



