<!DOCTYPE html>
<html lang="en">

<? 
require_once 'config.php';
require_once 'api/database.php'; 

$page = (isset($_GET['page']) and in_array($page, $_PAGES)) ? $_GET['page'] : 'index';

if (in_array('head_template', $_PAGES[$page])) {
    require_once $_PAGES[$page]['head_template'];
}  

require_once 'templates/page_base/head.php'; 
?>

<body class="bg-light">
    <? require_once 'templates/page_base/header.php'; ?>
    <main style="margin-top: 6rem" class="container">
        
        <div class="row reverse">
            <? require_once 'templates/side_panel/side_panel.php'; ?>
            <div class="col col-9-md">
                <?
                    if (in_array('template', $_PAGES[$page])) {
                        require_once $_PAGES[$page]['template'];
                    }
                ?>
            </div>
        </div>
    </main>
</body>
