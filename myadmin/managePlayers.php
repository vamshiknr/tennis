<?php

require_once '../constants.php';
require_once 'checksession.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class players
{

    private $db;
    public $perPage = PER_PAGE;
    public $first = 0;

    public function __construct()
    {
        $this->db = new DB();
    }

    /*
     * Function to get Players
     *
     * Access is Public
     *
     * @Param   Int     $academyId
     * @Param   String  $playerId
     * @Param   Boolean $limit
     * @return  Object  DB Result Object
     */

    public function getPlayers($academyId = NULL, $playerId = NULL, $limit = NULL)
    {
        return $this->_fetchPlayers($academyId, $playerId, $limit);
    }

    /*
     * Function to get Total records
     *
     * Access is Public
     *
     * @Param   Int     $academyId
     * @Param   String  $playerId
     * @return  Int     Total number of records
     */

    public function getToalRecords($academyId = NULL, $playerId = NULL)
    {
        $str = $this->_execPlayers($academyId, $playerId, true);
        return $this->db->Total($str);
    }

    /*
     * Function to get Players
     *
     * Access is Private
     *
     * @Param   Int     $academyId
     * @Param   String  $playerId
     * @Param   Boolean $limit
     * @return  Object  DB Result Object
     */

    private function _fetchPlayers($academyId = NULL, $playerId = NULL, $limit = NULL)
    {
        $str = $this->_execPlayers($academyId, $playerId, $limit);
        $records = $this->db->returns($str);
        return $records;
    }

    /*
     * Function to get frame a query for players
     *
     * Access is Private
     *
     * @Param   Int     $academyId
     * @Param   String  $playerId
     * @Param   Boolean $limit
     * @return  String  String
     */

    private function _execPlayers($academyid = NULL, $playerId = NULL, $limit = NULL)
    {
        $temp = '';
        $jCond = '';
        $jCols = '';
        if (!is_null($academyid)) {
            $temp .= " and ACADEMY_ID = " . trim((int) $academyid);
        }
        if (!is_null($academyid)) {
            $temp .= " and AITA = " . trim((int) $playerId);
        }
        if (is_null($limit)) {
            $jCols .= ', a.NAME as academyName, p.NAME as NAME';
            $jCond .= ' p join academy a on a.ACADEMY_ID = p.ACADEMY_ID ';
        }
        $str = "select * " . $jCols . " from player " . $jCond
                . "where 1=1 " . $temp;
        if (is_null($limit)) {
            $str .= ' limit ' . $this->first . ', ' . $this->perPage;
        }
        return $str;
    }

    /*
     * Function to check uniqueness of the player
     *
     * Access is Private
     *
     * @Param   String  $email
     * @Param   String  $name
     * @Param   String  $playerId
     * @Param   Int     $academyId
     * @return  Int     Count
     */

    public function checkUniqueness($email, $name = NULL, $playerId = NULL, $academyid = NULL)
    {
        try {
            $cond = ' and s.statusname = "Active"';
            if (!is_null($academyid)) {
                $cond .= ' and p.ACADEMY_ID ="' . $academyid . '"';
            }
            if (!is_null($playerId)) {
                $cond .= ' and p.AITA!="' . $playerId . '"';
            }
            if (!is_null($name)) {
                $cond .= ' and p.NAME!="' . $name . '"';
            }
            $str = "select count(p.NAME) as tcount from player p"
                    . " join academystatus s on s.statusid = p.status "
                    . "where p.EMAIL='" . $email . "'" . $cond;
            $fObject = $this->db->fetchObject($str);
            return $fObject->tcount;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

    /*
     * Function to Insert Player
     *
     * Access is public
     *
     * @Param Int    $aita
     * @Param String $firstName
     * @Param String $lastName
     * @Param String $name
     * @Param Date   $dob
     * @Param String $gender
     * @Param String $state
     * @Param String $mobile
     * @Param String $email
     * @Param Int    $academy_id
     * @Param String $facebook
     * @Param String $twitter
     * @Param String $photoPath
     *
     * @return Boolean
     *
     */

    public function insertPlayer($aita, $firstName, $lastName, $name, $dob, $gender, $state, $mobile, $email, $academy_id, $facebook, $twitter, $photoPath)
    {
        try {
            $str = 'insert into player(AITA,NAME,LAST_NAME,FIRST_NAME,DOB,GENDER,STATE,MOBILE,EMAIL,ACADEMY_ID,'
                    . 'FACEBOOK,TWITTER,PHOTO,CREATED_BY, CREATED_DATETIME, UPDATED_BY) '
                    . 'values ("' . $aita . '", "' . $name . '", "' . $lastName . '", "' . $firstName . '", "' . $dob . '",'
                    . ' "' . $gender . '", "' . $state . '", "' . $mobile . '", "' . $email . '",'
                    . ' "' . $academy_id . '", "' . $facebook . '", "' . $twitter . '", "' . $photoPath . '", '
                    . '"' . $_SESSION['userId'] . '", now(), "' . $_SESSION['userId'] . '")';
            return $this->db->Execute($str);
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: players.php');
        }
    }

    /*
     * Function to delete Player
     *
     * From status master table, 3-Deleted
     * @Param   Int $AITA
     * @return  Boolean
     */

    public function deletePlayer($AITA)
    {
        //$str = $this->_execPlayers($AITA);
        $str = 'update player set status = 3 where AITA = ' . $AITA;
        $this->db->flatExecute($str);
        return true;
    }

    /*
     * Function to Update Academy
     *
     * Access is public
     *
     * @Param Int    $aita
     * @Param String $firstName
     * @Param String $lastName
     * @Param String $name
     * @Param Date   $dob
     * @Param String $gender
     * @Param String $state
     * @Param String $mobile
     * @Param String $email
     * @Param Int    $academy_id
     * @Param String $facebook
     * @Param String $twitter
     * @Param String $photoPath
     * @Param Int    $statuses
     * @Param Int    $refNo
     *
     * @return Boolean
     *
     */

    public function updatePlayer($aita, $firstName, $lastName, $name, $dob, $gender, $state, $mobile, $email, $academy_id, $facebook, $twitter, $photoPath, $statuses, $refNo)
    {
        if ($this->checkUniqueness($email, $name, $aita, $academy_id) == 0) {
            return false;
        } else {
            $str = 'update player set AITA = "' . $aita . '",'
                    . ' NAME = "' . $name . '",'
                    . ' LAST_NAME = "' . $lastName . '",'
                    . ' FIRST_NAME = "' . $firstName . '",'
                    . ' DOB = "' . $dob . '",'
                    . ' GENDER = "' . $gender . '",'
                    . ' STATE = "' . $state . '",'
                    . ' MOBILE = "' . $mobile . '",'
                    . ' EMAIL = "' . $email . '",'
                    . ' ACADEMY_ID = "' . $academy_id . '",'
                    . ' FACEBOOK = "' . $facebook . '",'
                    . ' TWITTER = "' . $twitter . '",'
                    . ' PHOTO = "' . $photoPath . '",'
                    . ' UPDATED_BY=' . $_SESSION['userId'] . ','
                    . ' status=' . $statuses
                    . ' where refno=' . $refNo;
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
