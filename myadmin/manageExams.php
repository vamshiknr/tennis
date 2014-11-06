<?php

require_once '../constants.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class exams
{

    private $db;
    public $perPage = PER_PAGE;
    public $first = 0;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getExams($examId = NULL, $limit = NULL)
    {
        return $this->_fetchExams($examId, $limit);
    }

    public function getToalRecords($examId = NULL)
    {
        $str = $this->_execExams($examId, true);
        return $this->db->Total($str);
    }

    private function _fetchExams($examId = NULL, $limit = NULL)
    {
        $str = $this->_execExams($examId, $limit);
        $records = $this->db->returns($str);
        return $records;
    }

    private function _execExams($examId = NULL, $limit = NULL)
    {
        $temp = '';
        if (!is_null($examId)) {
            $temp = " and ce.exam_id = " . trim((int) $examId);
        }
        $str = "select ce.*, ca.adminusername as createdby from certification_exam ce "
                . "join certfication_status cs on ce.exam_status_id = cs.status_id "
                . "left join certification_admin ca on ca.adminid = ce.createdby "
                . "where cs.status_title = 'Active'" . $temp;
        if (is_null($limit)) {
            $str .= ' limit ' . $this->first . ', ' . $this->perPage;
        }
        return $str;
    }

    public function checkUniqueness($name, $examId = NULL, $category = NULL)
    {
        try {
            $cond = '';
            if (!is_null($examId)) {
                $cond = ' and ce.exam_id!=' . $examId;
            }
            $jcond = "ce.exam_title='" . $name . "' ";
            $joinCond = '';
            if (!is_null($category) && is_array($category)) {
                $jcond = '';
                foreach ($category as $new) {
                    if (!empty($jcond)) {
                        $jcond .= ' OR ';
                    } else {
                        $jcond .= '(';
                    }
                    $joinCond = ' left join certification_exam_categories cec on cec.exam_id = ce.exam_id ';
                    $jcond .= '(ce.exam_title="' . $name . '" and cec.category_id=' . $new . ')';
                }
                $jcond .= ')';
            }
            $str = "select count(ce.exam_title) as tcount from certification_exam ce "
                    . "join certfication_status cs on ce.exam_status_id = cs.status_id "
                    . "left join certification_admin ca on ca.adminid = ce.createdby "
                    . $joinCond
                    . "where cs.status_title = 'Active' and " . $jcond . $cond;
            $fObject = $this->db->fetchObject($str);
            return $fObject->tcount;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

    public function insertExam($examName, $time, $noOfAttempts, $examCategory, $examStatus, $examQuestionCount)
    {
        $str = 'insert into certification_exam(exam_title, exam_time, exam_attempts_count, exam_status_id, createdby, createddatetime, updatedby) '
                . 'values ("' . $examName . '", "' . $time . '", "' . $noOfAttempts . '", "1", "' . $_SESSION['userId'] . '", now(), "' . $_SESSION['userId'] . '")';
        $examId = $this->db->Execute($str);
        $this->insertExamCategories($examId, $examCategory, $examStatus, $examQuestionCount);
    }

    private function insertExamCategories($examId, $category, $status, $examCount)
    {
        $values = '';
        $index = 0;
        foreach ($category as $new) {
            if (!empty($values)) {
                $values .= ', ';
            }
            if ($new != 0) {
                $values .= '(' . $examId . ', ' . $new . ', ' . $status[$index] . ', ' . $examCount[$index] . ', now(), "' . $_SESSION['userId'] . '", "' . $_SESSION['userId'] . '")';
            }
        }
        if (!empty($values)) {
            $str = 'insert into certification_exam_categories'
                    . '(exam_id, category_id, exam_categories_status_id, exam_category_question_count, createddatetime, createdby, updatedby) '
                    . 'values ' . $values;
            $examId = $this->db->Execute($str);
        }
    }

    public function deleteExam($examId)
    {
        $str = $this->_execExams($examId);
        $str = 'delete from certification_exam where exam_id = ' . $examId;
        $this->db->flatExecute($str);
        return true;
    }

    public function updateExam($examId, $examName, $statusId, $parentId)
    {
        if ($this->checkUniqueness($examName, $examId, $parentId) > 0) {
            return false;
        } else {
            $str = 'update certification_categories set category_name = "' . $examName . '",'
                    . ' category_parent_id = ' . $parentId . ','
                    . ' updatedby=' . $_SESSION['userId'] . ','
                    . ' category_status_id=' . $statusId
                    . ' where category_id=' . $examId;
            $this->db->Execute($str);
            return true;
        }
    }

    public function fetchStatuses()
    {
        $str = "select * from certfication_status";
        return $this->db->Returns($str);
    }

}
