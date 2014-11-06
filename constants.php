<?php

session_start();
require_once 'configure.php';
require_once 'classes/database.class.php';
require_once 'classes/global.class.php';
require_once 'classes/mail.class.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$http = 'http://';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
    $http = 'https://';
}
$base_url = $http . $_SERVER['HTTP_HOST'] . '/10is';
$admin_url = $http . $_SERVER['HTTP_HOST'] . '/10is/myadmin';
define('PER_PAGE', 4);
define('CLAY_COURT_LIMIT', '10');
define('HARD_COURT_LIMIT', '10');
define('ACADEMY_IMAGES', 'academy_images');
define('COURT_IMAGES', 'court_images');

$allowed_image_types = array('image/jpeg', 'image/jpg', 'image/png');
?>