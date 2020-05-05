<? require_once("db.php"); ?> 
<!DOCTYPE html>
<html lang="en">

<? 
$_HEAD = [
    "title" => "Password recovery",
    "description" => ""
];
require_once("templates/head.php"); 
?>

<body class="bg-light">
    <? require_once("templates/header.php"); ?>
    <main style="margin-top: 6rem" class="container">
        
        <div class="row reverse">
            <? require_once("templates/side-panel.php"); ?>
            <div class="col col-9-md">
                <div class="card">
                    <h1>Password recovery</h1>
                    <p>Sorry, but the password recovery function doesn't work at the moment. Come back later.</p>
                    <img src="https://res.cloudinary.com/teepublic/image/private/s--ZvtzJF3a--/t_Preview/b_rgb:262c3a,c_lpad,f_jpg,h_630,q_90,w_1200/v1551119051/production/designs/4283587_0.jpg" alt="">
                </div>
            </div>
        </div>
    </main>

<script src="/js/maintainscroll.js"></script>
</body>
