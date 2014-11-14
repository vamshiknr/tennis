<?php

require_once './managePlayers.php';
require_once './Validation.php';
$validation = new Validation();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$players = new players();
if (isset($_POST['addSubmit'])) {

    $aita = trim($_POST['aita']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $name = $firstName . ' ' . $lastName;
    $birthday = date('Y-m-d', strtotime(trim($_POST['birthday'])));
    $gender = trim($_POST['gender']);
    $state = trim($_POST['state']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $academyId = trim($_POST['academyId']);
    $facebookPage = trim($_POST['facebook_page']);
    $twitterAccount = trim($_POST['twitter_account']);

    $errors = validatePlayer($_POST);
    if (count($errors) > 0) {
        $_SESSION['error'] = implode('<br/>', $errors);
        header('Location: addplayer.php');
    } else if ($players->checkUniqueness($email, $name, NULL, $academyId) == 0) {
        $imageFolder = 'images/' . PLAYER_IMAGES;
        $imageName = $imageFolder . '/' . rand(1111, 999999) . '_' . $_FILES['player_photo']['name'];
        if (!isset($insertedImage) && $_FILES['player_photo']['error'] != 0) {
            $_SESSION['error'] = 'Please upload an image for Player.';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            if ($_FILES['player_photo']['error'] == 0) {
                move_uploaded_file($_FILES['player_photo']['tmp_name'], '../' . $imageName);
            }
            $players->insertPlayer($aita, $firstName, $lastName, $name, $birthday, $gender, $state, $mobile, $email, $academyId, $facebookPage, $twitterAccount, $imageName);
        }
    } else {
        $_SESSION['error'] = 'Player already exists for this Academy. Please choose another';
        header('Location: addPlayer.php');
    }
    $_SESSION['success'] = 'Player added successfully';
    header('Location: players.php');
}

if (isset($_POST['editSubmit'])) {
    $aita = trim($_POST['aita']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $name = $firstName . ' ' . $lastName;
    $birthday = date('Y-m-d', strtotime(trim($_POST['birthday'])));
    $gender = trim($_POST['gender']);
    $state = trim($_POST['state']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $academyId = trim($_POST['academyId']);
    $facebookPage = trim($_POST['facebook_page']);
    $twitterAccount = trim($_POST['twitter_account']);
    $refno = trim($_POST['refno']);
    $insertedImage = trim($_POST['insertedImage']);
    $statuses = trim($_POST['statuses']);

    $errors = validatePlayer($_POST);
    if (count($errors) > 0) {
        $_SESSION['error'] = implode('<br/>', $errors);
        header('Location: editPlayer.php?pid=' . $aita . '&aid=' . $academyId);
    } else
    if ($players->checkUniqueness($email, $name, $aita, $academyId) == 0) {
        $imageFolder = 'images/' . PLAYER_IMAGES;
        $imageName = $imageFolder . '/' . rand(1111, 999999) . '_' . $_FILES['player_photo']['name'];
        if (!isset($insertedImage) && $_FILES['player_photo']['error'] != 0) {
            $_SESSION['error'] = 'Please upload an image for Player.';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            if ($_FILES['player_photo']['error'] == 0) {
                move_uploaded_file($_FILES['player_photo']['tmp_name'], '../' . $imageName);
                $insertedImage = $imageName;
            }
            $players->updatePlayer($aita, $firstName, $lastName, $name, $birthday, $gender, $state, $mobile, $email, $academyId, $facebookPage, $twitterAccount, $insertedImage, $statuses, $refno);
        }
    } else {
        $_SESSION['error'] = 'Player already exists for this academy. Please choose another';
        header('Location: editPlayer.php?pid=' . $aita . '&aid=' . $academyId);
    }
    $_SESSION['success'] = 'Player updated successfully';
    header('Location: players.php');
}

if (isset($_POST['deletePlayer'])) {
    $AITA = trim($_POST['deletePlayer']);
    if (!empty($AITA) && !$validation->validate_digits($AITA)) {
        $_SESSION['error'] = "You have tried to delete invalid Player";
        header('Location:players.php');
    } else if (!empty($AITA)) {
        $players->deletePlayer($AITA);
        header('Location:players.php');
    }
}

if (isset($_POST['selectCity'])) {
    $players->fetchCityHTML(trim($_POST['selectedState']));
}

unset($imageName);
if (isset($_POST['testPlayers'])) {
    try {
        if (isset($_FILES['importPlayers']) && $_FILES['importPlayers']['error'] != 0) {
            $_SESSION['error'] = "Please upload a csv file";
            header('Location: players.php');
        } else {

            $imageName = PLAYER_IMPORT . '/' . rand(1111, 999999) . '_' . $_FILES['importPlayers']['name'];
            move_uploaded_file($_FILES['importPlayers']['tmp_name'], '../' . $imageName);
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

                $aita = mysql_real_escape_string($csv_row[0]);
                $name = mysql_real_escape_string($csv_row[1]);
                $lastName = mysql_real_escape_string($csv_row[2]);
                $firstName = mysql_real_escape_string($csv_row[3]);
                $birthday = date('Y-m-d', strtotime($csv_row[4]));
                $gender = mysql_real_escape_string($csv_row[5]);
                $state = mysql_real_escape_string($csv_row[6]);
                $mobile = mysql_real_escape_string($csv_row[7]);
                $email = mysql_real_escape_string($csv_row[8]);
                $academyId = mysql_real_escape_string($csv_row[9]);
                $facebook = mysql_real_escape_string($csv_row[10]);
                $twitter = mysql_real_escape_string($csv_row[11]);
                $image = mysql_real_escape_string($csv_row[12]);
                $imagePath = explode('\\', $csv_row[12]);
                $imageNameValue = rand(1111, 999999) . '_' . $imagePath[count($imagePath) - 1];
                $content = file_get_contents($csv_row[12]);
                $fp = fopen('../images/player_images/' . $imageNameValue, 'w');
                fwrite($fp, $content);
                fclose($fp);

                $players->insertPlayer($aita, $firstName, $lastName, $name, $birthday, $gender, $state, $mobile, $email, $academyId, $facebook, $twitter, $imageNameValue);
            }
            $_SESSION['success'] = "Players imported successfully";
            header('Location: players.php');
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
}


/*
 * Purpose: Function to validate all the input parameters
 *
 * @param   Array   $params - Contains all the academy form fields
 *
 * @return  Boolean Returns true / false
 */

function validatePlayer($params)
{
    $error = array();
    $validation = new Validation();

    if (!empty($params['aita']) && !$validation->validate_digits($params['aita'])) {
        $error[] = "AITA Number only consists of Numbers.";
    } else if (empty($params['academy'])) {
        $error[] = "AITA Number is mandatory.";
    }
    if (!empty($params['firstName']) && !$validation->validate_alphanumeric($params['firstName'])) {
        $error[] = "First Name only consists of Alpha Numeric Characters.";
    } else if (empty($params['firstName'])) {
        $error[] = "First Name is mandatory.";
    }
    if (!empty($params['lastName']) && !$validation->validate_alphanumeric($params['lastName'])) {
        $error[] = "Last Name only consists of Alpha Numeric Characters.";
    } else if (empty($params['lastName'])) {
        $error[] = "Last Name is mandatory.";
    }
    if (!empty($params['birthday']) && !$validation->validate_date($params['birthday'], '/', true)) {
        $error[] = "Date Of Birth is Invalid.";
    } else if (empty($params['birthday'])) {
        $error[] = "Date Of Birth is mandatory.";
    }
    if (!empty($params['gender']) && !$validation->validate_gender($params['gender'])) {
        $error[] = "Invalid Gender selected.";
    } else if (empty($params['gender'])) {
        $error[] = "Gender is mandatory.";
    }
    if (!empty($params['state']) && !$validation->validate_alpha($params['state'])) {
        $error[] = "State only consists of Characters.";
    } else if (empty($params['state'])) {
        $error[] = "State is mandatory.";
    }
    if (!empty($params['mobile']) && !$validation->validate_digits($params['mobile'])) {
        $error[] = "Mobile only should contain numbers.";
    } else if (empty($params['mobile'])) {
        $error[] = "Mobile Number is mandatory.";
    }
    if (!empty($params['email']) && !$validation->validate_email_dot_underscore($params['email'])) {
        $error[] = "Email is Invalid.";
    } else if (empty($params['email'])) {
        $error[] = "Email is mandatory.";
    }
    if (!empty($params['academyId']) && !$validation->validate_digits($params['academyId'])) {
        $error[] = "Invalid Academy selected.";
    } else if (empty($params['email'])) {
        $error[] = "Academy is mandatory.";
    }
    //Non Mandatory field
    if (!empty($params['facebook_page']) && !$validation->validate_alphanumeric($params['facebook_page'])) {
        $error[] = "Invalid Facebook ID.";
    }
    //Non Mandatory field
    if (!empty($params['twitter_account']) && !$validation->validate_alphanumeric($params['twitter_account'])) {
        $error[] = "Invalid Twitter ID.";
    }

    if (isset($params['player_photo']) && empty($params['player_photo'])) {
        $error[] = "Choose an image to upload.";
    }
    return $error;
}
