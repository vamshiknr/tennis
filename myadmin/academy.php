<?php

require_once './manageAcadamies.php';
require_once './Validation.php';
$validation = new Validation();
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

    $courtImages = $_FILES['uploadCourt'];

    $errors = validateAcademy($_POST);
    if (count($errors) > 0) {
        $_SESSION['error'] = implode('<br/>', $errors);
        header('Location: addacademy.php');
    } else if ($acadamies->checkUniqueness($academyName, NULL, $city) == 0) {
        $imageFolder = 'images/' . ACADEMY_IMAGES;
        $imageName = $imageFolder . '/' . rand(1111, 999999) . '_' . $_FILES['academy_photo']['name'];
        if (!isset($insertedImage) && $_FILES['academy_photo']['error'] != 0) {
            $_SESSION['error'] = 'Please upload an image for Academy.';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            if ($_FILES['academy_photo']['error'] == 0) {
                move_uploaded_file($_FILES['academy_photo']['tmp_name'], '../' . $imageName);
            }
            $academyId = $acadamies->insertAcademy($academyName, $state, $city, $colony, $address, $landmark, $contactName, $mobile, $clayCourts, $hardCourts, $academyURL, $facebookPage, $twitterAccount, $imageName);
            if ($clayCourts > 0) {
                if ($clayCourtsValue > 0 && isset($_FILES['uploadCourt'])) {
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
            } else {
                $_SESSION['error'] = 'Academy Name already exists. Please choose another';
                header('Location: addacademy.php?id=' . $academyId);
            }
            $_SESSION['success'] = 'Academy added successfully';
            header('Location: acadamies.php');
        }
    }
}

if (isset($_POST['editSubmit'])) {
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
    $academyStatus = trim($_POST['statuses']);
    $insertedImage = trim($_POST['insertedImage']);

    $errors = validateAcademy($_POST);
    if (count($errors) > 0) {
        $_SESSION['error'] = implode('<br/>', $errors);
        header('Location: editacademy.php?id=' . $academyId);
    } else if ($acadamies->checkUniqueness($academyName, $academyId, $cityName) == 0) {
        $imageFolder = 'images/' . ACADEMY_IMAGES;
        $imageName = $imageFolder . '/' . rand(1111, 999999) . '_' . $_FILES['academy_photo']['name'];
        if (!isset($insertedImage) && $_FILES['academy_photo']['error'] != 0) {
            $_SESSION['error'] = 'Please upload an image for Academy.';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            if ($_FILES['academy_photo']['error'] == 0) {
                move_uploaded_file($_FILES['academy_photo']['tmp_name'], '../' . $imageName);
                $insertedImage = $imageName;
            }
            $acadamies->updateAcademy($academyName, $stateName, $cityName, $colonyName, $addressName, $landmarkName, $contactPerson, $mobileName, $clayCourtsValue, $hardCourtsValue, $academy_urlValue, $facebook_pageValue, $twitter_accountValue, $insertedImage, $academyStatus, $academyId);
            //exit;
            if ($clayCourtsValue > 0 && isset($_FILES['uploadCourt'])) {
                $courtImages = $_FILES['uploadCourt'];
                $courtFolder = 'images/' . COURT_IMAGES . '/' . $academyId;
                if (!file_exists('../' . $courtFolder)) {
                    mkdir('../' . $courtFolder, 0777);
                }
                for ($i = 0; $i < count($courtImages['name']); $i++) {
                    if ($courtImages['error'][$i] == 0 && in_array($courtImages['type'][$i], $allowed_image_types)) {
                        if (!move_uploaded_file($courtImages['tmp_name'][$i], '../' . $courtFolder . '/' . $courtImages['name'][$i])) {
                            $_SESSION['error'] = 'Unable to upload Clay Court images';
                            header('Location: acadamies.php');
                        }
                    }
                }
            }
        }
    } else {
        $_SESSION['error'] = 'Academy Name already exists. Please choose another';
        header('Location: editacademy.php?id=' . $academyId);
    }
    $_SESSION['success'] = 'Academy updated successfully';
    header('Location: acadamies.php');
}

if (isset($_POST['deleteAcademy'])) {
    $acadId = trim($_POST['deleteAcademy']);
    if (!empty($acadId) && !$validation->validate_digits($acadId)) {
        $_SESSION['error'] = "You have tried to delete invalid Academy";
        header('Location:acadamies.php');
    } else if (!empty($acadId)) {
        $acadamies->deleteAcademy($acadId);
        header('Location:acadamies.php');
    }
}

if (isset($_POST['selectCity'])) {
    $acadamies->fetchCityHTML(trim($_POST['selectedState']));
}

if (isset($_POST['testAcademies'])) {
    if (isset($_FILES['importAcademies']) && $_FILES['importAcademies']['error'] != 0) {
        $_SESSION['error'] = "Please upload a csv file";
        header('Location: acadamies.php');
    } else {
        $imageName = PLAYER_IMPORT . '/' . rand(1111, 999999) . '_' . $_FILES['importAcademies']['name'];
        move_uploaded_file($_FILES['importAcademies']['tmp_name'], '../' . $imageName);
        $count = 0;
        $contact = '';
        $fh = fopen('../' . $imageName, "r");
        while (($csv_row = fgetcsv($fh, 500, ',')) !== false) {
            if ($count == 0) {
                $count++;
                continue;
            }

            foreach ($csv_row as &$row) {
                $row = strtr($row, array("'" => "\'", '"' => '\"'));
            }
            if (!empty($contact)) {
                $contact .= ', ';
            }
            $academyName = mysql_real_escape_string($csv_row[0]);
            $state = mysql_real_escape_string($csv_row[1]);
            $city = mysql_real_escape_string($csv_row[2]);
            $colony = mysql_real_escape_string($csv_row[3]);
            $address = mysql_real_escape_string($csv_row[4]);
            $landmark = mysql_real_escape_string($csv_row[5]);
            $contactName = mysql_real_escape_string($csv_row[6]);
            $mobile = mysql_real_escape_string($csv_row[7]);
            $clayCourts = mysql_real_escape_string($csv_row[8]);
            $hardCourts = mysql_real_escape_string($csv_row[9]);
            $url = mysql_real_escape_string($csv_row[10]);
            $facebook = mysql_real_escape_string($csv_row[11]);
            $twitter = mysql_real_escape_string($csv_row[12]);
            $image = mysql_real_escape_string($csv_row[13]);
            $imagePath = explode('\\', $csv_row[13]);
            $imageNameValue = rand(1111, 999999) . '_' . $imagePath[count($imagePath) - 1];
            $content = file_get_contents($csv_row[13]);
            $fp = fopen('../images/academy_images/' . $imageNameValue, 'w');
            fwrite($fp, $content);
            fclose($fp);

            //$players->insertPlayer($aita, $firstName, $lastName, $name, $birthday, $gender, $state, $mobile, $email, $academyId, $facebook, $twitter, $imageNameValue);
            $academyId = $acadamies->insertAcademy($academyName, $state, $city, $colony, $address, $landmark, $contactName, $mobile, $clayCourts, $hardCourts, $url, $facebook, $twitter, $imageNameValue);
            $courtFolder = 'images/' . COURT_IMAGES . '/' . $academyId;
            if (!file_exists('../' . $courtFolder)) {
                mkdir('../' . $courtFolder, 0777);
            }
        }
        $_SESSION['success'] = "Academies imported successfully";
        header('Location: acadamies.php');
    }
}

/*
 * Purpose: Function to validate all the input parameters
 *
 * @param   Array   $params - Contains all the academy form fields
 *
 * @return  Boolean Returns true / false
 */

function validateAcademy($params)
{
    $error = array();
    $validation = new Validation();
    if (!empty($params['academy']) && !$validation->validate_alphanumeric($params['academy'])) {
        $error[] = "Academy Name only consists of Alpha numeric characters.";
    } else if (empty($params['academy'])) {
        $error[] = "Academy Name is mandatory.";
    }
    if (!empty($params['state']) && !$validation->validate_alpha($params['state'])) {
        $error[] = "State only consists of Characters.";
    } else if (empty($params['state'])) {
        $error[] = "State is mandatory.";
    }
    if (!empty($params['city']) && !$validation->validate_alpha($params['city'])) {
        $error[] = "City only consists of Characters.";
    } else if (empty($params['city'])) {
        $error[] = "City is mandatory.";
    }
    if (!empty($params['colony']) && !$validation->validate_alphanumeric_address($params['colony'])) {
        $error[] = "Colony contains invalid characters.";
    } else if (empty($params['colony'])) {
        $error[] = "Colony is mandatory.";
    }
    if (!empty($params['address']) && !$validation->validate_alphanumeric_address($params['address'])) {
        $error[] = "Address contains invalid characters.";
    } else if (empty($params['address'])) {
        $error[] = "Address is mandatory.";
    }
    if (!empty($params['landmark']) && !$validation->validate_alphanumeric_address($params['landmark'])) {
        $error[] = "Landmark contains invalid characters.";
    } else if (empty($params['landmark'])) {
        $error[] = "Landmark is mandatory.";
    }
    if (!empty($params['contact_name']) && !$validation->validate_alpha($params['contact_name'])) {
        $error[] = "Contact Name contains invalid characters.";
    } else if (empty($params['contact_name'])) {
        $error[] = "Contact Name is mandatory.";
    }
    if (!empty($params['mobile']) && !$validation->validate_digits($params['mobile'])) {
        $error[] = "Mobile only should contain numbers.";
    } else if (empty($params['mobile'])) {
        $error[] = "Mobile Number is mandatory.";
    }
    //Non Mandatory field
    if (!empty($params['clay_courts']) && !$validation->validate_digits($params['clay_courts'])) {
        $error[] = "Clay Courts only should contain numbers.";
    }
    //Non Mandatory field
    if (!empty($params['hard_courts']) && !$validation->validate_digits($params['hard_courts'])) {
        $error[] = "Hard Courts only should contain numbers.";
    }
    //Non Mandatory field
    if (!empty($params['academy_url']) && !$validation->validateURL($params['academy_url'])) {
        $error[] = "Invalid URL.";
    }
    //Non Mandatory field
    if (!empty($params['facebook_page']) && !$validation->validate_alphanumeric($params['facebook_page'])) {
        $error[] = "Invalid Facebook ID.";
    }
    //Non Mandatory field
    if (!empty($params['twitter_account']) && !$validation->validate_alphanumeric($params['twitter_account'])) {
        $error[] = "Invalid Twitter ID.";
    }

    if (isset($params['academy_photo']) && empty($params['academy_photo'])) {
        $error[] = "Choose an image to upload.";
    }
    return $error;
}
