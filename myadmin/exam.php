<?php

require_once './manageExams.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$exams = new exams();
if (isset($_POST['addSubmit'])) {
    $examName = trim($_POST['examname']);
    $examTime = calculateTime(trim($_POST['minutes']), trim($_POST['seconds']));
    $examAttempts = trim($_POST['examAttemts']);
    $examCategory = $_POST['examCategory'];
    $examStatus = $_POST['examStatus'];
    $examQuestionCount = $_POST['examQuestionCount'];
    if (!empty($examName)) {
        if ($exams->checkUniqueness($examName, NULL, $examCategory) < 1) {
            $exams->insertExam($examName, $examTime, $examAttempts, $examCategory, $examStatus, $examQuestionCount);
            header('Location:exams.php');
        } else {
            echo "Exam already exists<br/>";
            echo "<a href='" . $_SERVER['HTTP_REFERER'] . "'>Back</a>";
        }
    } else {
        echo "Name should not be empty<br/>";
        echo "<a href='" . $_SERVER['HTTP_REFERER'] . "'>Back</a>";
    }
}

if (isset($_POST['editexamSubmit'])) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    exit;
    $examName = trim($_POST['examname']);
    $examTime = calculateTime(trim($_POST['minutes']), trim($_POST['seconds']));
    $examAttempts = trim($_POST['examAttemts']);
    $examStatus = trim($_POST['statuses']);
    $examId = trim($_POST['examid']);
    if (!empty($catName)) {
        if ($exams->updateCategory($catId, $catName, $catStatus, $catParent)) {
            header('Location:categories.php');
        } else {
            echo "Category already exists<br/>";
            echo "<a href='" . $_SERVER['HTTP_REFERER'] . "'>Back</a>";
        }
    }
}

if (isset($_POST['examDelete'])) {
    $examId = trim($_POST['examDelete']);
    if (!empty($examId)) {
        $exams->deleteExam($examId);
        header('Location:exams.php');
    }
}

function calculateTime($minutes, $seconds)
{
    return ((int) trim($minutes) * 60 ) + ((int) trim($seconds));
}
