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
                . "where status=1 " . $temp;
        if (is_null($limit)) {
            $str .= ' limit ' . $this->first . ', ' . $this->perPage;
        }
        return $str;
    }

    public function checkUniqueness($name, $academyid = NULL, $city = NULL)
    {
        try {
            $cond = ' and s.statusname = "Active"';
            if (!is_null($academyid)) {
                $cond .= ' and a.ACADEMY_ID!=' . $academyid;
            }
            if (!is_null($city)) {
                $cond .= ' and a.CITY ="' . $city . '"';
            }
            $str = "select count(a.NAME) as tcount from academy a"
                    . " join academystatus s on s.statusid = a.status "
                    . "where a.NAME='" . $name . "'" . $cond;
            $fObject = $this->db->fetchObject($str);
            return $fObject->tcount;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

    /*
     * Function to Insert Academy
     *
     * Access is public
     *
     * @Param String $academyName
     * @Param String $state
     * @Param String $city
     * @Param String $colony
     * @Param String $address
     * @Param String $landmark
     * @Param String $contactName
     * @Param String $mobile
     * @Param Int $clay_courts
     * @Param Int $hard_courts
     * @Param String $url
     * @Param String $facebook
     * @Param String $twitter
     * @Param String $photoLoc
     *
     * @return Boolean
     *
     */

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

    /*
     * Function to delete Academy
     *
     * From status master table, 3-Deleted
     * @Param   Int $academyId
     * @return  Boolean
     */

    public function deleteAcademy($academyId)
    {
        $str = $this->_execAcadamies($academyId);
        $str = 'update academy set status = 3 where ACADEMY_ID = ' . $academyId;
        $this->db->flatExecute($str);
        return true;
    }

    /*
     * Function to Update Academy
     *
     * Access is public
     *
     * @Param String $academyName
     * @Param String $state
     * @Param String $city
     * @Param String $colony
     * @Param String $address
     * @Param String $landmark
     * @Param String $contactName
     * @Param String $mobile
     * @Param Int $clay_courts
     * @Param Int $hard_courts
     * @Param String $url
     * @Param String $facebook
     * @Param String $twitter
     * @Param String $photoLoc
     * @Param Int $status
     *
     * @return Boolean
     *
     */

    public function updateAcademy($academyName, $state, $city, $colony, $address, $landmark, $contactName, $mobile, $clay_courts, $hard_courts, $url, $facebook, $twitter, $photoLoc, $academyStatus, $academyId)
    {
        if ($this->checkUniqueness($academyName, $academyId, $city) > 0) {
            return false;
        } else {
            $str = 'update academy set NAME = "' . $academyName . '",'
                    . ' STATE = "' . $state . '",'
                    . ' CITY = "' . $city . '",'
                    . ' COLONY = "' . $colony . '",'
                    . ' ADDRESS = "' . $address . '",'
                    . ' LANDMARK = "' . $landmark . '",'
                    . ' CONTACT_NAME = "' . $contactName . '",'
                    . ' MOBILE = "' . $mobile . '",'
                    . ' CLAY_COURTS = "' . $clay_courts . '",'
                    . ' HARD_COURTS = "' . $hard_courts . '",'
                    . ' URL = "' . $url . '",'
                    . ' FACEBOOK = "' . $facebook . '",'
                    . ' TWITTER = "' . $twitter . '",'
                    . ' PHOTO = "' . $photoLoc . '",'
                    . ' UPDATED_BY=' . $_SESSION['userId'] . ','
                    . ' status=' . $academyStatus
                    . ' where ACADEMY_ID=' . $academyId;
            $this->db->Execute($str);
            return true;
        }
    }

    public function fetchStatuses()
    {
        $str = "select * from academystatus";
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

    /*
     * Function to check Image extension
     *
     * Access is Public
     * @param String $imageName
     * @return Boolean
     */

    public function isValidImageExt($imageName)
    {
        try {
            $ext = array('jpg', 'jpeg', 'png');
            $imageArray = explode('.', $imageName);
            $length = count($imageArray);
            if (in_array($imageArray[$length - 1], $ext)) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

}
