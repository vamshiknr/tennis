<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ob_start();
//session_start();
if (!isset($_SESSION['is_session_active']) || $_SESSION['is_session_active'] != 1) {
    header('Location: index.php');
}