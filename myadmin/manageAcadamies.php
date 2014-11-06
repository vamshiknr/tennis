<?php

require_once '../constants.php';
require_once 'checksession.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class acadamies
{

    private $db;
    public $perPage = PER_PAGE;
    public $first = 0;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getAcadamies($academyId = NULL, $limit = NULL)
    {
        return $this->_fetchAcadamies($academyId, $limit);
    }

    public function getToalRecords($academyId = NULL)
    {
        $str = $this->_execAcadamies($academyId, true);
        return $this->db->Total($str);
    }

    private function _fetchAcadamies($academyId = NULL, $limit = NULL)
    {
        $str = $this->_execAcadamies($academyId, $limit);
        $records = $this->db->returns($str);
        return $records;
    }

    private function _execAcadamies($academyid = NULL, $limit = NULL)
    {
        $temp = '';
        if (!is_null($academyid)) {
            $temp = " and ACADEMY_ID = " . trim((int) $academyid);
        }
        $str = "select * from academy "
                . "where 1=1 " . $temp;
        if (is_null($limit)) {
            $str .= ' limit ' . $this->first . ', ' . $this->perPage;
        }
        return $str;
    }

    public function checkUniqueness($name, $academyid = NULL, $city = NULL)
    {
        try {
            $cond = '';
            if (!is_null($academyid)) {
                $cond = ' and ACADEMY_ID!=' . $academyid;
            }
            if (!is_null($city)) {
                $cond = ' and CITY ="' . $city . '"';
            }
            $str = "select count(NAME) as tcount from academy "
                    . "where NAME='" . $name . "'" . $cond;
            $fObject = $this->db->fetchObject($str);
            return $fObject->tcount;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

    public function insertAcademy($academyName, $state, $city, $colony, $address, $landmark, $contactName, $mobile, $clay_courts, $hard_courts, $url, $facebook, $twitter, $photoLoc)
    {
        $str = 'insert into academy(NAME,STATE,CITY,COLONY,ADDRESS,LANDMARK,CONTACT_NAME,MOBILE,CLAY_COURTS,HARD_COURTS,'
                . 'URL,FACEBOOK,TWITTER,PHOTO,CREATED_BY, CREATED_DATETIME, UPDATED_BY) '
                . 'values ("' . $academyName . '", "' . $state . '", "' . $city . '", "' . $colony . '", "' . $address . '",'
                . ' "' . $landmark . '", "' . $contactName . '", "' . $mobile . '", "' . $clay_courts . '",'
                . ' "' . $hard_courts . '", "' . $url . '", "' . $facebook . '", "' . $twitter . '", "' . $photoLoc . '", '
                . '"' . $_SESSION['userId'] . '", now(), "' . $_SESSION['userId'] . '")';
        return $this->db->Execute($str);
    }

    public function deleteAcademy($categoryId)
    {
        $str = $this->_execAcadamies($categoryId);
        $str = 'delete from certification_categories where category_id = ' . $categoryId;
        $this->db->flatExecute($str);
        return true;
    }

    public function updateAcademy($categoryId, $categoryName, $statusId, $parentId)
    {
        if ($this->checkUniqueness($categoryName, $categoryId, $parentId) > 0) {
            return false;
        } else {
            $str = 'update certification_categories set category_name = "' . $categoryName . '",'
                    . ' category_parent_id = ' . $parentId . ','
                    . ' updatedby=' . $_SESSION['userId'] . ','
                    . ' category_status_id=' . $statusId
                    . ' where category_id=' . $categoryId;
            $this->db->Execute($str);
            return true;
        }
    }

    public function fetchStatuses()
    {
        $str = "select * from certfication_status";
        return $this->db->Returns($str);
    }

    public function fetchStates($stateCode = NULL)
    {
        try {
            $cond = '';
            if (!is_null($stateCode)) {
                $cond = " where state='" . trim($stateCode) . "'";
            }
            $selectState = "select state, name from state" . $cond;
            return $this->db->Returns($selectState);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

    public function fetchCities($stateCode = NULL)
    {
        try {
            $cond = '';
            if (!is_null($stateCode)) {
                $cond = " where state='" . trim($stateCode) . "'";
            }
            $selectCity = "select city, state from city" . $cond;
            return $this->db->Returns($selectCity);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

    public function fetchCityHTML($stateCode = NULL)
    {
        try {
            if (!is_null($stateCode) || !empty($stateCode)) {
                $cities = $this->fetchCities($stateCode);
                $op = '';
                if (mysql_num_rows($cities) > 0) {
                    while ($city = mysql_fetch_object($cities)) {
                        $op .= "<option value='" . $city->city . "'>" . $city->city . '-' . $city->state . "</option>";
                    }
                } else {
                    $op = '<option value="0">--No City Present--</option>';
                }
            } else {
                $op = '<option value="0">--No City Present--</option>';
            }
            echo $op;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

}
