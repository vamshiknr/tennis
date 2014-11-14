<?php

/*
 *
 * File		:	Validation.php
 * Purpose	:	This class is used for validating field values at server side
 *
 * Header Information	: class Validation
 * -----------------------------------------------------------------------------------------------------------------
 * Declaration	:
 * -----------------------------------------------------------------------------------------------------------------
 * Method Header Information	:
  validate_alphanumeric_space($str), validate_alpha($str), validate_numeric($str),
  validate_email_dot_underscore($str), validate_alphanumeric($str), validate_alphanumeric_space_apostrophe($str),
  validate_alphanumeric_upper_small_digit($str)
 */

class Validation
{

    /**
     * Purpose: To validate alphanumeric character with space
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar	$str String to validate
     * @return
     */
    public function validate_alphanumeric_space($str)
    {
        $result = preg_match('/^[a-zA-Z0-9 ]+$/', $str);
        if (!$result || $result == 0) {
            return false;
        } else if ($result || $result != 0) {
            return true;
        }
    }

    /**
     * Purpose: To validate alphanumeric character with space
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar	$str String to validate
     * @return
     */
    public function validate_alphanumeric_spacehypen($str)
    {
        $result = preg_match('/^[a-zA-Z0-9_ ]+$/', $str);
        if (!$result || $result == 0) {
            return false;
        } else if ($result || $result != 0) {
            return true;
        }
    }

    /**
     * Purpose: To validate alphanumeric character
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar	$str String to validate
     * @return
     */
    public function validate_alphanumeric_address($str)
    {
        $regexp = "/^[a-zA-Z0-9 #&\-\_\:\.\/\,]+$/";
        $notallowed = "/[!@$%^*?~+<>|=\}\[\]\{\\\'\"\;\`]/";
        $result = preg_match($notallowed, $str);
        if ($result || $result == 1) {
            return false;
        } else if (!$result || $result == 0) {
            return true;
        }
    }

    /**
     * Purpose: To validate alpha character
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar	$str String to validate
     * @return
     */
    public function validate_alpha($str)
    {
        $result = preg_match('/^[a-zA-Z]+$/', $str);
        if (!$result || $result == 0) {
            return false;
        } else if ($result || $result != 0) {
            return true;
        }
    }

    /**
     * Purpose: To validate numeric character
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar	$str String to validate
     * @return
     */
    public function validate_numeric($str)
    {
        if (!preg_match('/^[1-9][0-9]*$/', $str) || preg_match('/^[1-9][0-9]*$/', $str) == 0) {
            return false;
        } else if (preg_match('/^[1-9][0-9]*$/', $str) || preg_match('/^[1-9][0-9]*$/', $str) != 0) {
            return true;
        }
    }

    /**
     * Purpose: To validate digits
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar	$str String to validate
     * @return
     */
    public function validate_digits($str)
    {
        if (!preg_match('/^[0-9]+$/', $str) || preg_match('/^[0-9]+$/', $str) == 0) {
            return false;
        } else if (preg_match('/^[0-9]+$/', $str) || preg_match('/^[0-9]+$/', $str) != 0) {
            return true;
        }
    }

    /**
     * Purpose: To validate email
     *                    Allowed characters are .,_,@
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar	$str String to validate
     * @return
     */
    public function validate_email_dot_underscore($str)
    {
        $regexp = "/^[^0-9_.][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/";
        if (preg_match($regexp, $str) || preg_match($regexp, $str) != 0) {
            list($username, $domain) = explode('@', $str);
            if (!checkdnsrr($domain, 'MX')) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Purpose: To validate alpha numeric value
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar $str String to validate
     * @return
     */
    public function validate_alphanumeric($str)
    {
        $regexp = "/^[A-Za-z0-9]+$/";
        $result = preg_match($regexp, $str);
        if (!$result || $result == 0) {
            return false;
        } else if ($result || $result != 0) {
            return true;
        }
    }

    /**
     * Purpose: To validate alpha numeric values with space, questionmark and apostrophe
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar $str String to validate
     * @return
     */
    public function validate_alphanumeric_space_apostrophe($str)
    {

        $splexp = "/^[A-Za-z0-9][A-Za-z0-9? \']*$/";

        if (!preg_match($splexp, $str) || preg_match($splexp, $str) == 0) {
            return false;
        }

        return true;
    }

    /**
     * Purpose: To validate alpha numeric values with one Uppercase and one lowercase and a digit as mandatory
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar $str String to validate
     * @return
     */
    public function validate_alphanumeric_upper_small_digit($str)
    {
        $regexp = "/[A-Z]+[a-z]+[\d]+$/";  // validates a Uppercae, a lower case and a number
        $result = preg_match($regexp, $str);

        if (!$result || $result == 0) {
            return false;
        } else if ($result || $result != 0) {
            return true;
        }
        // return preg_match($regexp,$str);
    }

    /**
     * Purpose: To validate alpha numeric values with one Uppercase and a digit as mandatory
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar $str String to validate
     * @return
     */
    public function validate_alphanumeric_password($str)
    {
        $regexpUpper = "#[A-Z]+#";  // Validates a Uppercae
        $regexpNumber = "#[0-9]+#"; // Validates a Number
        $regexpLower = "#[a-z]+#";  // Validates a Lowercase
        $regexpAllow = "#^[A-Za-z0-9]+#";  // Allowed characters


        if (!preg_match($regexpUpper, $str) || preg_match($regexpUpper, $str) == 0) {
            return false;
        } else if (!preg_match($regexpNumber, $str) || preg_match($regexpNumber, $str) == 0) {
            return false;
        } else if (!preg_match($regexpAllow, $str) || preg_match($regexpAllow, $str) == 0) {
            return false;
        }

        return true;
    }

    public function validate_alphanumeric_special_password($str)
    {
        $reuslt = preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@!#$\_\*\]).{8,16}$/", $str);
        if (!$result || $result == 0) {
            return false;
        } else if ($result || $result != 0) {
            return true;
        }
    }

    /**
     * Purpose: To validate alpha numeric values with one Character and one Number as mandatory
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar $str String to validate
     * @return
     */
    public function validate_alphanumeric_digicharman($str)
    {
        $regexpUpper = "#[A-Z]+#";  // Validates a Uppercae
        $regexpNumber = "#[1-9]+#"; // Validates a Number
        $regexpLower = "#[a-z]+#";  // Validates a Lowercase
        $regexpupperLower = "#[A-Za-z]+#";  // Validates a Lowercase or Uppercase

        if (!preg_match($regexpupperLower, $str) || preg_match($regexpupperLower, $str) == 0) {
            return false;
        } else if (!preg_match($regexpNumber, $str) || preg_match($regexpNumber, $str) == 0) {
            return false;
        }
        return true;
    }

    public function validate_alphanumeric_hash($str)
    {
        $regexp = "/^[a-zA-Z0-9#&-_:\.\/\( \)\,]+$/";
        $result = preg_match($regexp, $str) == 0;

        if (!$result || $result == 0) {
            return false;
        } else if ($result || $result != 0) {
            return true;
        }
    }

    public function validateUSAZip($zip_code)
    {
        if (!preg_match("/^[0-9]{5}([-][0-9]{4})?$/", $zip_code) || preg_match("/^[0-9]{5}([-][0-9]{4})?$/", $zip_code) == 0)
            return false;
        else
            return true;
    }

    public function validatenospecialcharacters($value)
    {
        $notallowed = "/[#&\-\_\:\.\/\,!@$%^*?~+<>|=\}\[\]\{\\\'\"\;\`]/";
        if (preg_match($notallowed, $value) || preg_match($notallowed, $value) == 1) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Purpose: To validate date
     *
     * Access is restricted to class and its child classes
     *
     * @param	varchar	$str String to validate
     * @return
     */
    public function validate_date($str, $delimiter, $regFormat = false)
    {


        $fArray = explode($delimiter, $str);
        if (count($fArray) != 3) {
            return false;
        } else {
            if (!$regFormat) {
                $month = $fArray[0];
                $date = $fArray[1];
                $year = $fArray[2];
            } else {
                $month = $fArray[1];
                $date = $fArray[2];
                $year = $fArray[0];
            }
            if (!is_numeric($month)) {
                return false;
            } else {
                if ($month > 12 || $month < 01) {
                    return false;
                } else {
                    if (!is_numeric($date)) {
                        return false;
                    } else {
                        if ($date > 31 || $date < 01) {
                            return false;
                        } else {
                            if (!is_numeric($year)) {
                                return false;
                            } else {
                                if ($year > date('Y')) {
                                    return false;
                                } else {
                                    $isDateValid = checkdate($month, $date, $year);
                                    return $isDateValid;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Purpose: To validate URL with a specific format
     *
     * Access is public
     *
     * @param   String  $value
     * @return  Boolean
     */
    public function validateURL($value)
    {
        $pattern = '/^([\d\w]+?:\/\/)?([\w\d\.\-]+)(\.\w+)(:\d{1,5})?(\/\S*)?$/i';
        if (!preg_match($pattern, $value) || preg_match($pattern, $value) == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Purpose: To validate URL with a specific format
     *
     * Access is public
     *
     * @param   String  $value
     * @return  Boolean
     */
    public function validate_gender($value)
    {
        if (strtolower($value) == 'm' || strtolower($value) == 'f') {
            return true;
        } else {
            return false;
        }
    }

}
