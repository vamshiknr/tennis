<?php

require_once './manageAcadamies.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$acadamies = new acadamies();
if (isset($_POST['addSubmit'])) {

    $academyName = trim($_POST['academy']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $colony = trim($_POST['colony']);
    $address = trim($_POST['address']);
    $landmark = trim($_POST['landmark']);
    $contactName = trim($_POST['contact_name']);
    $mobile = trim($_POST['mobile']);
    $clayCourts = trim($_POST['clay_courts']);
    $hardCourts = trim($_POST['hard_courts']);
    $academyURL = trim($_POST['academy_url']);
    $facebookPage = trim($_POST['facebook_page']);
    $twitterAccount = trim($_POST['twitter_account']);
    if ($clayCourts > 0) {
        $courtImages = $_FILES['uploadCourt'];

        //echo $acadamies->checkUniqueness($academyName, NULL, $city);
        if ($acadamies->checkUniqueness($academyName, NULL, $city) == 0) {
            $imageFolder = 'images/' . ACADEMY_IMAGES;
            $imageName = $imageFolder . '/' . $_FILES['academy_photo']['name'];
            move_uploaded_file($_FILES['academy_photo']['tmp_name'], '../' . $imageName);
            $academyId = $acadamies->insertAcademy($academyName, $state, $city, $colony, $address, $landmark, $contactName, $mobile, $clayCourts, $hardCourts, $academyURL, $facebookPage, $twitterAccount, $imageName);
            $courtFolder = 'images/' . COURT_IMAGES . '/' . $academyId;
            if (!file_exists('../' . $courtFolder)) {
                mkdir('../' . $courtFolder, 0777);
            }
            for ($i = 0; $i < count($courtImages['name']); $i++) {
                if ($courtImages['error'][$i] == 0 && in_array($courtImages['type'][$i], $allowed_image_types)) {
                    if (!move_uploaded_file($courtImages['tmp_name'][$i], '../' . $courtFolder . '/' . $courtImages['name'][$i])) {
                        header('Location: acadamies.php');
                    }
                }
            }
        }
        header('Location: acadamies.php');
    }
}

if (isset($_POST['editSubmit'])) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    exit;
    $academyId = trim($_POST['academyId']);
    $academyName = trim($_POST['academy']);
    $stateName = trim($_POST['state']);
    $cityName = trim($_POST['city']);
    $colonyName = trim($_POST['colony']);
    $addressName = trim($_POST['address']);
    $landmarkName = trim($_POST['landmark']);
    $contactPerson = trim($_POST['contact_name']);
    $mobileName = trim($_POST['mobile']);
    $clayCourtsValue = trim($_POST['clay_courts']);
    $hardCourtsValue = trim($_POST['hard_courts']);
    $academy_urlValue = trim($_POST['academy_url']);
    $facebook_pageValue = trim($_POST['facebook_page']);
    $twitter_accountValue = trim($_POST['twitter_account']);


    $catParent = trim($_POST['categoryparent']);
    $catStatus = trim($_POST['statuses']);

    if (!empty($academyName)) {
        if ($acadamies->updateCategory($academyId, $academyName, $catStatus, $catParent)) {
            header('Location:categories.php');
        } else {
            echo "Category already exists<br/>";
            echo "<a href='" . $_SERVER['HTTP_REFERER'] . "'>Back</a>";
        }
    }
}

if (isset($_POST['categoryDelete'])) {
    $catId = trim($_POST['categoryDelete']);
    if (!empty($catId)) {
        $acadamies->deleteCategory($catId);
        header('Location:categories.php');
    }
}

if (isset($_POST['selectCity'])) {
    $acadamies->fetchCityHTML(trim($_POST['selectedState']));
}
