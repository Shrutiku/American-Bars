<?php

require '../src/Instagram.php';

/////// CONFIG ///////
$username = 'php.viral';
$password = 'viral@123';
$debug = false;

$photo = 'http://www.themobileindian.com/images/nnews/2015/10/16989/reglobe.jpg';     // path to the photo
$caption = null;   // caption
//////////////////////

$i = new Instagram($username, $password, $debug);

try {
    $i->login();
} catch (InstagramException $e) {
    $e->getMessage();
    exit();
}

try {
    $i->uploadPhoto($photo, $caption);
} catch (Exception $e) {
    echo $e->getMessage();
}
