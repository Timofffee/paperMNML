<?php
$_HEAD_TMP = [
    "title" => "pprMNML",
    "description" => "Minimalistic forum"
];

$_HEAD = (isset($_HEAD)) ? array_merge($_HEAD_TMP, $_HEAD) : $_HEAD_TMP;
?>

<head>
    <link rel="icon" href="/img/logo.svg">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="/vendor/viewerjs/viewer.css">

    <title><?=$_HEAD['title']?></title>
    <meta name="description" content="<?=$_HEAD['description']?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="http://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <script src="/vendor/viewerjs/viewer.js"></script>
    <script src="/vendor/tinytim.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function make_bigger_image(obj) {
            let options = {
                button:false,
                toolbar:false,
                navbar: false,
                title: false,
                loop:false,
                rotatable: false,
                tooltip: false,
                zoomRatio: 0.5,
                minZoomRatio: 0.5,
                maxZoomRatio: 2.0
            };
            let viewer = new Viewer(obj, options);
        }
    </script>

    
</head>