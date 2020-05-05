<?php
function createThumbnail($imageDirectory, $imageName, $thumbDirectory, $thumbWidth) {
    $explode = explode(".", $imageName);
    $filetype = $explode[1];

    if ($filetype == 'jpg') {
        $srcImg = imagecreatefromjpeg("$imageDirectory/$imageName");
    } else
    if ($filetype == 'jpeg') {
        $srcImg = imagecreatefromjpeg("$imageDirectory/$imageName");
    } else
    if ($filetype == 'png') {
        $srcImg = imagecreatefrompng("$imageDirectory/$imageName");
    } else
    if ($filetype == 'gif') {
        $srcImg = imagecreatefromgif("$imageDirectory/$imageName");
    }

    $origWidth = imagesx($srcImg);
    $origHeight = imagesy($srcImg);

    $ratio = $origWidth / $thumbWidth;
    $thumbHeight = $origHeight / $ratio;

    $thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
    imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);

    if ($filetype == 'jpg') {
        imagejpeg($thumbImg, "$thumbDirectory/$imageName");
    } else
    if ($filetype == 'jpeg') {
        imagejpeg($thumbImg, "$thumbDirectory/$imageName");
    } else
    if ($filetype == 'png') {
        imagepng($thumbImg, "$thumbDirectory/$imageName");
    } else
    if ($filetype == 'gif') {
        imagegif($thumbImg, "$thumbDirectory/$imageName");
    }
}
    ?>