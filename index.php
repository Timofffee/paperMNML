<? require_once("db.php"); ?> 
<!DOCTYPE html>
<html lang="en">



<?php 
$_HEAD = [
    "title" => "pprMNML",
    "description" => "Minimalistic forum"
];
require_once("templates/head.php"); ?>

<body class="bg-light">
    <? require_once("templates/header.php"); ?>
    <main style="margin-top: 6rem" class="container">
        
        <div class="row reverse">
            <? require_once("templates/side-panel.php"); ?>
            <!-- wall -->
            <div class="col col-9-md">
                <!-- sort panel -->
                <!-- <div class="row">
                    <div class="col card sort row is-paddingless">
                        <nav class="col tabs is-marginless">
                            <a href="" class="active">Все</a>
                            <a href="">Подписки</a>
                        </nav>
                        <div class="col- is-right is-marginless is-vertical-align">
                        <details class="dropdown" id="wall-filter">
                            <summary class="button clear">
                                    <img src="https://icongr.am/fontawesome/align-justify.svg" alt="" style="margin:0; width:1em;margin-right:0.5em">
                            </summary>
                            <div class="card filter is-top">
                                <p><a href="#">Edit</a></p>
                                <p><a href="#">Alerts&nbsp;<span class="tag">3</span></a></p>
                                <hr class="is-marginless">
                                <p><a href="#" class="text-error">Logout</a></p>
                            </div>
                        </details>
                            
                        </div>
                        
                        
                    </div>
                </div> -->
                <!-- post -->
                <?
                    require_once("api/post/get_post.php");
                    get_posts();
                ?>

            </div>
        </div>
    </main>
    <!-- <script src="https://unpkg.com/tiny-editor/dist/bundle.js"></script> -->
    <!-- <script>
        $(document).click( function(event){
            if( $(event.target).closest(".dropdown").length ) 
                return;
            $('.dropdown').removeAttr('open');
            event.stopPropagation();
        });
        
    </script> -->

<script src="/js/maintainscroll.js"></script>

</body>
