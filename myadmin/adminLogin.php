<?php

require_once '../constants.php';
//session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$db = new DB();
$username = trim($_POST['username']);
$password = trim($_POST['password']);
if ($username != '' && $password != '') {
    $strQuery = "select * from admin where username='" . $username . "' and password='" . $password . "'";
    $records = $db->fetchObject($strQuery);
    if (count($records) > 0) {
        $_SESSION['is_session_active'] = 1;
        $_SESSION['username'] = $username;
        $_SESSION['userId'] = $records->adminid;
        header("Location:dashboard.php");
    } else {
        echo "Invalid Username and Passowrd";
        exit;
    }
} else {
    header('Location:index.php');
}
