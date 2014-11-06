<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
unset($_SESSION['is_session_active']);
unset($_SESSION['username']);
session_destroy();
header('Location: index.php');
