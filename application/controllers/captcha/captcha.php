<?php
session_start();
include 'rand.php';
$alphaNumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
$random = substr(str_shuffle($alphaNumeric), 0, $randval);
$image = imagecreatefromjpeg("back.jpg");

$textColor = imagecolorallocate($image, 0, 0, 0);
imagestring($image, 16, 15, 28, $random, $textColor);

$_SESSION['image_random_value'] = md5($random);

header("Expires: Tue, 21 Jul 2015 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Chace-Control: no-store, no-chace, must-revalidate");
header("Chace-Control: post-check=0, pre-check=0", false);
header("Pragma: no-chace");
header('Content-type: image/jpeg');
imagejpeg($image);
imagedestroy($image);

function LoadJpeg($imgname)
{
    /* Attempt to open */
    $im = @imagecreatefromjpeg($imgname);

    /* See if it failed */
    if(!$im)
    {
        /* Create a black image */
        $im  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

    return $im;
}

?>